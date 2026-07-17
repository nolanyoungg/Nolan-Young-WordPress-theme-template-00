<?php
namespace NYforms;

defined( 'ABSPATH' ) || exit;

class Rest {
	public function hooks() { add_action( 'rest_api_init', array( $this, 'routes' ) ); }

	public function routes() {
		register_rest_route( 'nyforms/v1', '/forms', array(
			array( 'methods' => \WP_REST_Server::READABLE, 'callback' => array( $this, 'forms' ), 'permission_callback' => array( $this, 'manage' ) ),
			array( 'methods' => \WP_REST_Server::CREATABLE, 'callback' => array( $this, 'create' ), 'permission_callback' => array( $this, 'manage' ) ),
		) );
		register_rest_route( 'nyforms/v1', '/forms/import', array( 'methods' => \WP_REST_Server::CREATABLE, 'callback' => array( $this, 'import' ), 'permission_callback' => array( $this, 'manage' ) ) );
		register_rest_route( 'nyforms/v1', '/forms/(?P<id>\\d+)', array(
			array( 'methods' => \WP_REST_Server::READABLE, 'callback' => array( $this, 'form' ), 'permission_callback' => array( $this, 'manage' ) ),
			array( 'methods' => \WP_REST_Server::EDITABLE, 'callback' => array( $this, 'update' ), 'permission_callback' => array( $this, 'manage' ) ),
			array( 'methods' => \WP_REST_Server::DELETABLE, 'callback' => array( $this, 'trash_form' ), 'permission_callback' => array( $this, 'manage' ) ),
		) );
		register_rest_route( 'nyforms/v1', '/forms/(?P<id>\\d+)/export', array( 'methods' => \WP_REST_Server::READABLE, 'callback' => array( $this, 'export' ), 'permission_callback' => array( $this, 'manage' ) ) );
		register_rest_route( 'nyforms/v1', '/forms/(?P<form_id>\\d+)/entries', array( 'methods' => \WP_REST_Server::READABLE, 'callback' => array( $this, 'entries' ), 'permission_callback' => array( $this, 'entries_permission' ) ) );
		register_rest_route( 'nyforms/v1', '/entries/(?P<id>\\d+)', array(
			array( 'methods' => \WP_REST_Server::READABLE, 'callback' => array( $this, 'entry' ), 'permission_callback' => array( $this, 'entries_permission' ) ),
			array( 'methods' => \WP_REST_Server::EDITABLE, 'callback' => array( $this, 'update_entry' ), 'permission_callback' => array( $this, 'entries_permission' ) ),
		) );
	}

	public function manage() { return current_user_can( 'nyforms_manage_forms' ); }
	public function entries_permission() { return current_user_can( 'nyforms_view_entries' ); }
	public function forms() { return rest_ensure_response( Plugin::instance()->repository->forms() ); }
	public function form( $request ) { return $this->respond_form( $request['id'] ); }
	public function create( $request ) { $id = Plugin::instance()->repository->create_form( $request->get_json_params() ); return is_wp_error( $id ) ? $this->client_error( $id ) : $this->respond_form( $id, 201 ); }
	public function update( $request ) { $form = Plugin::instance()->repository->update_form( $request['id'], $request->get_json_params() ); return is_wp_error( $form ) ? $this->client_error( $form ) : rest_ensure_response( $form ); }
	public function trash_form( $request ) { return Plugin::instance()->repository->set_form_status( $request['id'], 'trash' ) ? new \WP_REST_Response( null, 204 ) : new \WP_Error( 'nyforms_not_found', __( 'Form not found.', 'nyforms' ), array( 'status' => 404 ) ); }
	public function export( $request ) { $form = Plugin::instance()->repository->form( $request['id'] ); if ( ! $form ) { return new \WP_Error( 'nyforms_not_found', __( 'Form not found.', 'nyforms' ), array( 'status' => 404 ) ); } return rest_ensure_response( array( 'nyforms_format' => 1, 'exported_at' => gmdate( 'c' ), 'form' => $form['definition'] ) ); }
	public function import( $request ) { $payload = $request->get_json_params(); if ( ! is_array( $payload ) || 1 !== absint( $payload['nyforms_format'] ?? 0 ) || empty( $payload['form'] ) ) { return new \WP_Error( 'nyforms_invalid_import', __( 'The file is not a supported NYforms export.', 'nyforms' ), array( 'status' => 400 ) ); } $id = Plugin::instance()->repository->create_form( $payload['form'] ); return is_wp_error( $id ) ? $this->client_error( $id ) : $this->respond_form( $id, 201 ); }
	public function entries( $request ) { $status = sanitize_key( $request->get_param( 'status' ) ?: 'active' ); if ( ! in_array( $status, array( 'active', 'spam', 'trashed' ), true ) ) { return new \WP_Error( 'nyforms_invalid_status', __( 'Unsupported entry status.', 'nyforms' ), array( 'status' => 400 ) ); } return rest_ensure_response( Plugin::instance()->repository->entries( $request['form_id'], $status, sanitize_text_field( $request->get_param( 'search' ) ?: '' ), min( 100, absint( $request->get_param( 'per_page' ) ?: 50 ) ), absint( $request->get_param( 'offset' ) ?: 0 ) ) ); }
	public function entry( $request ) { $entry = Plugin::instance()->repository->entry( $request['id'] ); if ( ! $entry ) { return new \WP_Error( 'nyforms_not_found', __( 'Entry not found.', 'nyforms' ), array( 'status' => 404 ) ); } Plugin::instance()->repository->update_entry_status( $entry['id'], $entry['status'], true ); return rest_ensure_response( $entry ); }
	public function update_entry( $request ) { $status = sanitize_key( $request->get_param( 'status' ) ?: 'active' ); if ( ! in_array( $status, array( 'active', 'spam', 'trashed' ), true ) ) { return new \WP_Error( 'nyforms_invalid_status', __( 'Unsupported entry status.', 'nyforms' ), array( 'status' => 400 ) ); } return Plugin::instance()->repository->update_entry_status( $request['id'], $status, $request->has_param( 'is_read' ) ? rest_sanitize_boolean( $request->get_param( 'is_read' ) ) : null ) ? rest_ensure_response( Plugin::instance()->repository->entry( $request['id'] ) ) : new \WP_Error( 'nyforms_not_found', __( 'Entry not found.', 'nyforms' ), array( 'status' => 404 ) ); }
	private function client_error( $error ) { $data = $error->get_error_data(); if ( ! is_array( $data ) || empty( $data['status'] ) ) { $error->add_data( array( 'status' => 400 ) ); } return $error; }
	private function respond_form( $id, $status = 200 ) { $form = Plugin::instance()->repository->form( $id ); return $form ? new \WP_REST_Response( $form, $status ) : new \WP_Error( 'nyforms_not_found', __( 'Form not found.', 'nyforms' ), array( 'status' => 404 ) ); }
}
