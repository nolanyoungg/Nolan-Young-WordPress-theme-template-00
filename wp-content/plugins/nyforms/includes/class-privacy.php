<?php
namespace NYforms;
defined( 'ABSPATH' ) || exit;
class Privacy {
	public function hooks() { add_action( 'admin_init', array( $this, 'policy' ) ); add_filter( 'wp_privacy_personal_data_exporters', array( $this, 'exporters' ) ); add_filter( 'wp_privacy_personal_data_erasers', array( $this, 'erasers' ) ); }
	public function policy() { if ( function_exists( 'wp_add_privacy_policy_content' ) ) { wp_add_privacy_policy_content( __( 'NYforms', 'nyforms' ), wp_kses_post( __( '<p>NYforms stores submitted values, submission time, referring page, and requested upload metadata. People may request export or erasure through the site privacy request form or WordPress privacy tools.</p>', 'nyforms' ) ) ); } }
	public function exporters( $exporters ) { $exporters['nyforms'] = array( 'exporter_friendly_name' => __( 'NYforms submissions', 'nyforms' ), 'callback' => array( $this, 'exporter' ) ); return $exporters; }
	public function erasers( $erasers ) { $erasers['nyforms'] = array( 'eraser_friendly_name' => __( 'NYforms submissions', 'nyforms' ), 'callback' => array( $this, 'eraser' ) ); return $erasers; }
	public function exporter( $email, $page = 1 ) { global $wpdb; $limit = 50; $offset = ( max( 1, $page ) - 1 ) * $limit; $ids = $wpdb->get_col( $wpdb->prepare( 'SELECT DISTINCT entry_id FROM ' . $wpdb->prefix . 'nyforms_entry_values WHERE value LIKE %s LIMIT %d OFFSET %d', '%' . $wpdb->esc_like( $email ) . '%', $limit, $offset ) ); $data = array(); foreach ( $ids as $id ) { $entry = Plugin::instance()->repository->entry( $id ); if ( ! $entry ) { continue; } $fields = array( array( 'name' => __( 'Entry ID', 'nyforms' ), 'value' => $entry['id'] ), array( 'name' => __( 'Form ID', 'nyforms' ), 'value' => $entry['form_id'] ), array( 'name' => __( 'Submitted', 'nyforms' ), 'value' => $entry['submitted_at'] ) ); foreach ( $entry['values'] as $key => $value ) { $fields[] = array( 'name' => $key, 'value' => is_array( $value ) ? implode( ', ', $value ) : $value ); } foreach ( Plugin::instance()->repository->files_for_entry( $id ) as $file ) { $fields[] = array( 'name' => sprintf( __( 'Upload: %s', 'nyforms' ), $file['field_key'] ), 'value' => $file['original_name'] . ' (' . $file['mime_type'] . ')' ); } $data[] = array( 'group_id' => 'nyforms-entries', 'group_label' => __( 'NYforms submissions', 'nyforms' ), 'item_id' => 'nyforms-entry-' . $id, 'data' => $fields ); } return array( 'data' => $data, 'done' => count( $ids ) < $limit ); }
	public function eraser( $email, $page = 1 ) {
	global $wpdb;

	$limit = 50;
	$email = sanitize_email( $email );

	/*
	 * Do not apply the WordPress privacy-tool page number as a SQL offset.
	 * Each callback deletes its result set, so an offset would skip rows after
	 * the first batch. Fetching the first remaining IDs is deletion-safe.
	 */
	$ids = $wpdb->get_col(
		$wpdb->prepare(
			'SELECT DISTINCT values_table.entry_id FROM ' . $wpdb->prefix . 'nyforms_entry_values values_table INNER JOIN ' . $wpdb->prefix . 'nyforms_entries entries_table ON entries_table.id = values_table.entry_id WHERE values_table.value LIKE %s ORDER BY values_table.entry_id LIMIT %d',
			'%' . $wpdb->esc_like( $email ) . '%',
			$limit
		)
	);

	foreach ( $ids as $id ) {
		Plugin::instance()->repository->delete_entry( $id );
	}

	return array(
		'items_removed'  => ! empty( $ids ),
		'items_retained' => false,
		'messages'       => array(),
		'done'           => count( $ids ) < $limit,
	);
}
	public static function public_request_allowed( $request ) { $email = sanitize_email( $request['email'] ?? '' ); $ip = wp_privacy_anonymize_ip( $_SERVER['REMOTE_ADDR'] ?? '' ); $key = 'nyforms_privacy_' . md5( $ip . '|' . strtolower( $email ) ); if ( get_transient( $key ) ) { return false; } $settings = get_option( 'nyforms_settings', array() ); if ( ! empty( $settings['recaptcha_enabled'] ) && ! self::captcha_valid( sanitize_text_field( $request['g-recaptcha-response'] ?? '' ), $settings ) ) { return false; } set_transient( $key, 1, HOUR_IN_SECONDS ); return true; }
	private static function captcha_valid( $token, $settings ) { $secret = sanitize_text_field( $settings['recaptcha_secret_key'] ?? '' ); if ( '' === $token || '' === $secret ) { return false; } $response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array( 'timeout' => 10, 'body' => array( 'secret' => $secret, 'response' => $token, 'remoteip' => wp_privacy_anonymize_ip( $_SERVER['REMOTE_ADDR'] ?? '' ) ) ) ); if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) { return false; } $body = json_decode( wp_remote_retrieve_body( $response ), true ); return ! empty( $body['success'] ); }
	public static function create_request( $email, $type ) { if ( ! function_exists( 'wp_create_user_request' ) ) { require_once ABSPATH . 'wp-admin/includes/user.php'; } $action = 'erase' === $type ? 'remove_personal_data' : 'export_personal_data'; $request_id = wp_create_user_request( $email, $action ); if ( is_wp_error( $request_id ) ) { return $request_id; } return wp_send_user_request( $request_id ); }
}
