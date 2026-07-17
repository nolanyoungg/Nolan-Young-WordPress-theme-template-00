<?php
namespace NYforms;

defined( 'ABSPATH' ) || exit;

class Admin {
	public function hooks() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_post_nyforms_admin', array( $this, 'action' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
	}

	public function menu() {
		add_menu_page( __( 'NYforms', 'nyforms' ), __( 'NYforms', 'nyforms' ), 'nyforms_manage_forms', 'nyforms', array( $this, 'forms_page' ), 'dashicons-feedback', 26 );
		add_submenu_page( 'nyforms', __( 'Forms', 'nyforms' ), __( 'Forms', 'nyforms' ), 'nyforms_manage_forms', 'nyforms', array( $this, 'forms_page' ) );
		add_submenu_page( 'nyforms', __( 'New Form', 'nyforms' ), __( 'New Form', 'nyforms' ), 'nyforms_manage_forms', 'nyforms-new', array( $this, 'new_form_page' ) );
		add_submenu_page( 'nyforms', __( 'Entries', 'nyforms' ), __( 'Entries', 'nyforms' ), 'nyforms_view_entries', 'nyforms-entries', array( $this, 'entries_page' ) );
		add_submenu_page( 'nyforms', __( 'Settings', 'nyforms' ), __( 'Settings', 'nyforms' ), 'nyforms_manage_forms', 'nyforms-settings', array( $this, 'settings_page' ) );
		add_submenu_page( 'nyforms', __( 'Import/Export', 'nyforms' ), __( 'Import/Export', 'nyforms' ), 'nyforms_manage_forms', 'nyforms-import-export', array( $this, 'import_export_page' ) );
		add_submenu_page( 'nyforms', __( 'Add-Ons', 'nyforms' ), __( 'Add-Ons', 'nyforms' ), 'nyforms_manage_forms', 'nyforms-addons', array( $this, 'addons_page' ) );
		add_submenu_page( 'nyforms', __( 'System Status', 'nyforms' ), __( 'System Status', 'nyforms' ), 'nyforms_manage_forms', 'nyforms-system-status', array( $this, 'system_status_page' ) );
		add_submenu_page( 'nyforms', __( 'Help', 'nyforms' ), __( 'Help', 'nyforms' ), 'nyforms_manage_forms', 'nyforms-help', array( $this, 'help_page' ) );
	}

	public function assets( $hook ) {
		if ( false === strpos( $hook, 'nyforms' ) ) { return; }
		wp_enqueue_style( 'nyforms-admin', NYFORMS_URL . 'assets/admin.css', array(), NYFORMS_VERSION );
		wp_enqueue_script( 'nyforms-admin', NYFORMS_URL . 'assets/admin.js', array(), NYFORMS_VERSION, true );
		if ( isset( $_GET['form'] ) ) {
			wp_enqueue_script( 'nyforms-builder', NYFORMS_URL . 'assets/builder.js', array( 'wp-api-fetch', 'wp-i18n' ), NYFORMS_VERSION, true );
			wp_add_inline_script( 'nyforms-builder', 'window.nyformsBuilder=' . wp_json_encode( array( 'nonce' => wp_create_nonce( 'wp_rest' ), 'restUrl' => esc_url_raw( rest_url( 'nyforms/v1/' ) ) ) ) . ';', 'before' );
		}
	}

	public function forms_page() {
		$this->require_manage();
		$form_id = absint( $_GET['form'] ?? 0 );
		if ( $form_id ) { $this->editor_page( $form_id ); return; }
		$search = sanitize_text_field( wp_unslash( $_GET['s'] ?? '' ) ); $status = sanitize_key( $_GET['status'] ?? '' ); if ( ! in_array( $status, array( 'active', 'draft', 'inactive', 'trash' ), true ) ) { $status = ''; }
		$all_forms = Plugin::instance()->repository->forms(); $forms = Plugin::instance()->repository->forms( $search, $status );
		echo '<div class="wrap nyforms-admin"><div class="nyforms-hero"><span class="nyforms-mark" aria-hidden="true">N</span><div><p class="nyforms-eyebrow">' . esc_html__( 'FORM WORKSPACE', 'nyforms' ) . '</p><h1>' . esc_html__( 'Forms', 'nyforms' ) . '</h1><p>' . esc_html__( 'Create, organize, and monitor every NYforms workflow.', 'nyforms' ) . '</p></div></div>';
		echo '<a class="page-title-action" href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=new' ), 'nyforms_admin' ) ) . '">' . esc_html__( 'New form', 'nyforms' ) . '</a>';
		$counts = array_count_values( wp_list_pluck( $all_forms, 'status' ) );
		echo '<div class="nyforms-list-controls"><ul class="nyforms-status-filter"><li><a' . ( '' === $status ? ' class="current"' : '' ) . ' href="' . esc_url( admin_url( 'admin.php?page=nyforms' ) ) . '">' . esc_html__( 'All', 'nyforms' ) . ' <span>' . count( $all_forms ) . '</span></a></li>'; foreach ( array( 'active' => __( 'Active', 'nyforms' ), 'draft' => __( 'Drafts', 'nyforms' ), 'inactive' => __( 'Inactive', 'nyforms' ), 'trash' => __( 'Trash', 'nyforms' ) ) as $slug => $label ) { echo '<li><a' . ( $slug === $status ? ' class="current"' : '' ) . ' href="' . esc_url( add_query_arg( array( 'page' => 'nyforms', 'status' => $slug ), admin_url( 'admin.php' ) ) ) . '">' . esc_html( $label ) . ' <span>' . absint( $counts[ $slug ] ?? 0 ) . '</span></a></li>'; } echo '</ul><form class="nyforms-search" method="get"><input type="hidden" name="page" value="nyforms"><label class="screen-reader-text" for="nyforms-form-search">' . esc_html__( 'Search forms', 'nyforms' ) . '</label><input id="nyforms-form-search" type="search" name="s" value="' . esc_attr( $search ) . '" placeholder="' . esc_attr__( 'Search forms', 'nyforms' ) . '"><button class="button" type="submit">' . esc_html__( 'Search', 'nyforms' ) . '</button></form></div><form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="nyforms_admin"><input type="hidden" name="operation" value="bulk_forms">' . wp_nonce_field( 'nyforms_admin', '_wpnonce', true, false ) . '<div class="tablenav top"><div class="alignleft actions"><label class="screen-reader-text" for="nyforms-bulk-action">' . esc_html__( 'Select bulk action', 'nyforms' ) . '</label><select id="nyforms-bulk-action" name="bulk_action"><option value="">' . esc_html__( 'Bulk actions', 'nyforms' ) . '</option><option value="activate">' . esc_html__( 'Mark active', 'nyforms' ) . '</option><option value="draft">' . esc_html__( 'Mark draft', 'nyforms' ) . '</option><option value="inactive">' . esc_html__( 'Mark inactive', 'nyforms' ) . '</option><option value="trash">' . esc_html__( 'Move to trash', 'nyforms' ) . '</option></select><button type="submit" class="button action">' . esc_html__( 'Apply', 'nyforms' ) . '</button></div><div class="tablenav-pages">' . sprintf( esc_html__( '%d items', 'nyforms' ), count( $forms ) ) . '</div></div><table class="widefat striped nyforms-forms-table"><thead><tr><td class="check-column"><input type="checkbox" class="nyforms-select-all" aria-label="' . esc_attr__( 'Select all forms', 'nyforms' ) . '"></td><th>' . esc_html__( 'Form', 'nyforms' ) . '</th><th>' . esc_html__( 'Status', 'nyforms' ) . '</th><th>' . esc_html__( 'Entries', 'nyforms' ) . '</th><th>' . esc_html__( 'Unread', 'nyforms' ) . '</th></tr></thead><tbody>';
		foreach ( $forms as $form ) {
			$edit = add_query_arg( array( 'page' => 'nyforms', 'form' => $form['id'] ), admin_url( 'admin.php' ) );
			$actions = array( '<a href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=duplicate&id=' . $form['id'] ), 'nyforms_admin' ) ) . '">' . esc_html__( 'Duplicate', 'nyforms' ) . '</a>', '<a href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=export_form&id=' . $form['id'] ), 'nyforms_admin' ) ) . '">' . esc_html__( 'Export JSON', 'nyforms' ) . '</a>' );
			if ( 'trash' === $form['status'] ) { $actions[] = '<a href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=restore&id=' . $form['id'] ), 'nyforms_admin' ) ) . '">' . esc_html__( 'Restore', 'nyforms' ) . '</a>'; $actions[] = '<a href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=delete&id=' . $form['id'] ), 'nyforms_admin' ) ) . '">' . esc_html__( 'Delete permanently', 'nyforms' ) . '</a>'; } else { $operation = 'active' === $form['status'] ? 'deactivate' : 'activate'; $label = 'active' === $form['status'] ? __( 'Deactivate', 'nyforms' ) : __( 'Activate', 'nyforms' ); $actions[] = '<a href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=' . $operation . '&id=' . $form['id'] ), 'nyforms_admin' ) ) . '">' . esc_html( $label ) . '</a>'; $actions[] = '<a href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=trash&id=' . $form['id'] ), 'nyforms_admin' ) ) . '">' . esc_html__( 'Trash', 'nyforms' ) . '</a>'; }
			$status_label = 'draft' === $form['status'] ? __( 'Draft', 'nyforms' ) : ucfirst( $form['status'] );
			echo '<tr><th class="check-column"><input type="checkbox" name="form_ids[]" value="' . absint( $form['id'] ) . '" aria-label="' . esc_attr( sprintf( __( 'Select %s', 'nyforms' ), $form['title'] ) ) . '"></th><td><a href="' . esc_url( $edit ) . '">' . esc_html( $form['title'] ) . '</a><div class="row-actions">' . implode( ' | ', $actions ) . '</div></td><td><span class="nyforms-status nyforms-status--' . esc_attr( $form['status'] ) . '">' . esc_html( $status_label ) . '</span></td><td>' . absint( $form['entries'] ) . '</td><td>' . absint( $form['unread'] ) . '</td></tr>';
		}
		echo '</tbody></table><div class="tablenav bottom"><div class="alignleft actions"><select name="bulk_action"><option value="">' . esc_html__( 'Bulk actions', 'nyforms' ) . '</option><option value="activate">' . esc_html__( 'Mark active', 'nyforms' ) . '</option><option value="draft">' . esc_html__( 'Mark draft', 'nyforms' ) . '</option><option value="inactive">' . esc_html__( 'Mark inactive', 'nyforms' ) . '</option><option value="trash">' . esc_html__( 'Move to trash', 'nyforms' ) . '</option></select><button type="submit" class="button action">' . esc_html__( 'Apply', 'nyforms' ) . '</button></div></div></form></div>';
	}

	private function editor_page( $form_id ) {
		$form = Plugin::instance()->repository->form( $form_id );
		if ( ! $form ) { wp_die( esc_html__( 'Form not found.', 'nyforms' ) ); }
		echo '<div class="wrap nyforms-builder-wrap"><h1>' . esc_html__( 'Edit form', 'nyforms' ) . ': ' . esc_html( $form['title'] ) . '</h1>';
		echo '<p><a href="' . esc_url( admin_url( 'admin.php?page=nyforms' ) ) . '">' . esc_html__( '← All forms', 'nyforms' ) . '</a></p>';
		echo '<div id="nyforms-builder" data-form="' . esc_attr( wp_json_encode( $form ) ) . '"></div></div>';
	}

	public function entries_page() {
		if ( ! current_user_can( 'nyforms_view_entries' ) ) { wp_die( esc_html__( 'You are not allowed to view entries.', 'nyforms' ) ); }
		$form_id = absint( $_GET['form'] ?? 0 );
		if ( ! $form_id ) { echo '<div class="wrap"><h1>' . esc_html__( 'NYforms entries', 'nyforms' ) . '</h1><p>' . esc_html__( 'Choose a form from the Forms screen.', 'nyforms' ) . '</p></div>'; return; }
		$status = sanitize_key( $_GET['status'] ?? 'active' ); if ( ! in_array( $status, array( 'active', 'spam', 'trashed' ), true ) ) { $status = 'active'; }
		$entries = Plugin::instance()->repository->entries( $form_id, $status, sanitize_text_field( wp_unslash( $_GET['s'] ?? '' ) ) );
		$export = wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=export&form=' . $form_id ), 'nyforms_admin' );
		echo '<div class="wrap"><h1 class="wp-heading-inline">' . esc_html__( 'Entries', 'nyforms' ) . '</h1><a class="page-title-action" href="' . esc_url( $export ) . '">' . esc_html__( 'Export CSV', 'nyforms' ) . '</a><hr class="wp-header-end"><ul class="subsubsub">'; foreach ( array( 'active' => __( 'Active', 'nyforms' ), 'spam' => __( 'Spam', 'nyforms' ), 'trashed' => __( 'Trash', 'nyforms' ) ) as $slug => $label ) { echo '<li><a href="' . esc_url( add_query_arg( array( 'page' => 'nyforms-entries', 'form' => $form_id, 'status' => $slug ), admin_url( 'admin.php' ) ) ) . '"' . ( $slug === $status ? ' class="current"' : '' ) . '>' . esc_html( $label ) . '</a> | </li>'; } echo '</ul><table class="widefat striped"><thead><tr><th>' . esc_html__( 'ID', 'nyforms' ) . '</th><th>' . esc_html__( 'Submitted', 'nyforms' ) . '</th><th>' . esc_html__( 'Status', 'nyforms' ) . '</th><th>' . esc_html__( 'Values', 'nyforms' ) . '</th></tr></thead><tbody>';
		foreach ( $entries as $entry ) { $detail = Plugin::instance()->repository->entry( $entry['id'] ); $values = array(); foreach ( $detail['values'] as $key => $value ) { $values[] = $key . ': ' . ( is_array( $value ) ? implode( ', ', $value ) : $value ); } foreach ( Plugin::instance()->repository->files_for_entry( $entry['id'] ) as $file ) { $values[] = '<a href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=download&file=' . $file['id'] ), 'nyforms_admin' ) ) . '">' . esc_html( $file['original_name'] ) . '</a>'; } $actions = array(); $operations = 'trashed' === $entry['status'] ? array( 'restore_entry' => __( 'Restore', 'nyforms' ), 'delete_entry' => __( 'Delete permanently', 'nyforms' ) ) : array( 'read' => $entry['is_read'] ? __( 'Mark unread', 'nyforms' ) : __( 'Mark read', 'nyforms' ), 'spam' => __( 'Mark spam', 'nyforms' ), 'trash_entry' => __( 'Trash', 'nyforms' ) ); foreach ( $operations as $operation => $label ) { $actions[] = '<a href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=' . $operation . '&entry=' . $entry['id'] . '&form=' . $form_id ), 'nyforms_admin' ) ) . '">' . esc_html( $label ) . '</a>'; } echo '<tr><td>' . absint( $entry['id'] ) . '</td><td>' . esc_html( $entry['submitted_at'] ) . '</td><td>' . esc_html( $entry['status'] ) . '<div class="row-actions">' . implode( ' | ', $actions ) . '</div></td><td>' . wp_kses_post( implode( ' | ', $values ) ) . '</td></tr>'; }
		echo '</tbody></table></div>';
	}

	public function new_form_page() {
		$this->require_manage();
		echo '<div class="wrap nyforms-admin"><div class="nyforms-hero"><span class="nyforms-mark" aria-hidden="true">N</span><div><p class="nyforms-eyebrow">' . esc_html__( 'FORM WORKSPACE', 'nyforms' ) . '</p><h1>' . esc_html__( 'New Form', 'nyforms' ) . '</h1><p>' . esc_html__( 'Start with a blank form, then shape it in the visual builder.', 'nyforms' ) . '</p></div></div><div class="nyforms-card"><h2>' . esc_html__( 'Blank form', 'nyforms' ) . '</h2><p>' . esc_html__( 'Create an empty form and add only the fields your workflow needs.', 'nyforms' ) . '</p><a class="button button-primary" href="' . esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nyforms_admin&operation=new' ), 'nyforms_admin' ) ) . '">' . esc_html__( 'Create blank form', 'nyforms' ) . '</a></div></div>';
	}

	public function settings_page() {
		$this->require_manage(); $settings = wp_parse_args( get_option( 'nyforms_settings', array() ), array( 'rate_limit' => 10, 'retention_days' => 0, 'delete_data_on_uninstall' => false ) );
		echo '<div class="wrap nyforms-admin"><div class="nyforms-hero"><span class="nyforms-mark" aria-hidden="true">N</span><div><p class="nyforms-eyebrow">' . esc_html__( 'CONFIGURATION', 'nyforms' ) . '</p><h1>' . esc_html__( 'Settings', 'nyforms' ) . '</h1><p>' . esc_html__( 'Set baseline protection and data-retention behavior for NYforms.', 'nyforms' ) . '</p></div></div><form class="nyforms-card nyforms-settings" method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="nyforms_admin"><input type="hidden" name="operation" value="save_settings">' . wp_nonce_field( 'nyforms_admin', '_wpnonce', true, false ) . '<p><label>' . esc_html__( 'Submissions per IP each hour', 'nyforms' ) . '<input type="number" min="1" max="1000" name="rate_limit" value="' . esc_attr( $settings['rate_limit'] ) . '"></label></p><p><label>' . esc_html__( 'Move entries to trash after (days)', 'nyforms' ) . '<input type="number" min="0" name="retention_days" value="' . esc_attr( $settings['retention_days'] ) . '"></label></p><p><label><input type="checkbox" name="delete_data_on_uninstall" value="1"' . checked( ! empty( $settings['delete_data_on_uninstall'] ), true, false ) . '> ' . esc_html__( 'Delete NYforms data when the plugin is uninstalled', 'nyforms' ) . '</label></p><p><button class="button button-primary" type="submit">' . esc_html__( 'Save settings', 'nyforms' ) . '</button></p></form></div>';
	}

	public function import_export_page() {
		$this->require_manage();
		echo '<div class="wrap nyforms-admin"><div class="nyforms-hero"><span class="nyforms-mark" aria-hidden="true">N</span><div><p class="nyforms-eyebrow">' . esc_html__( 'PORTABILITY', 'nyforms' ) . '</p><h1>' . esc_html__( 'Import/Export', 'nyforms' ) . '</h1><p>' . esc_html__( 'Move versioned NYforms definitions safely between WordPress sites.', 'nyforms' ) . '</p></div></div><div class="nyforms-card"><h2>' . esc_html__( 'Import a form', 'nyforms' ) . '</h2><form method="post" enctype="multipart/form-data" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="nyforms_admin"><input type="hidden" name="operation" value="import">' . wp_nonce_field( 'nyforms_admin', '_wpnonce', true, false ) . '<input type="file" name="nyforms_import" accept="application/json,.json" required> <button type="submit" class="button">' . esc_html__( 'Import JSON', 'nyforms' ) . '</button></form><p class="description">' . esc_html__( 'Exports are available from each form’s row actions.', 'nyforms' ) . '</p></div></div>';
	}

	public function addons_page() { $this->info_page( __( 'Add-Ons', 'nyforms' ), __( 'Extend NYforms', 'nyforms' ), __( 'NYforms keeps integrations opt-in. Registered field, notification, and anti-spam providers appear here when installed by a site owner.', 'nyforms' ) ); }
	public function system_status_page() { $this->info_page( __( 'System Status', 'nyforms' ), __( 'Environment check', 'nyforms' ), sprintf( __( 'WordPress %1$s · PHP %2$s · NYforms %3$s', 'nyforms' ), get_bloginfo( 'version' ), PHP_VERSION, NYFORMS_VERSION ) ); }
	public function help_page() { $this->info_page( __( 'Help', 'nyforms' ), __( 'NYforms help', 'nyforms' ), __( 'Create a form, add fields in the builder, then embed it with the NYforms block, shortcode, or template helper.', 'nyforms' ) ); }

	private function info_page( $title, $heading, $content ) { $this->require_manage(); echo '<div class="wrap nyforms-admin"><div class="nyforms-hero"><span class="nyforms-mark" aria-hidden="true">N</span><div><p class="nyforms-eyebrow">' . esc_html( $title ) . '</p><h1>' . esc_html( $heading ) . '</h1><p>' . esc_html( $content ) . '</p></div></div></div>'; }

	public function action() {
		$this->require_manage(); check_admin_referer( 'nyforms_admin' ); $repo = Plugin::instance()->repository; $operation = sanitize_key( wp_unslash( $_REQUEST['operation'] ?? '' ) );
		if ( 'save_settings' === $operation ) { update_option( 'nyforms_settings', array( 'rate_limit' => min( 1000, max( 1, absint( $_POST['rate_limit'] ?? 10 ) ) ), 'retention_days' => absint( $_POST['retention_days'] ?? 0 ), 'delete_data_on_uninstall' => ! empty( $_POST['delete_data_on_uninstall'] ) ) ); wp_safe_redirect( admin_url( 'admin.php?page=nyforms-settings&updated=1' ) ); exit; }
		if ( 'bulk_forms' === $operation ) { $this->bulk_forms(); }
		if ( 'export' === $operation ) { $this->export_csv( absint( $_GET['form'] ?? 0 ) ); }
		if ( 'export_form' === $operation ) { $this->export_form( absint( $_GET['id'] ?? 0 ) ); }
		if ( 'import' === $operation ) { $this->import_form(); }
		if ( 'download' === $operation ) { $this->download_file( absint( $_GET['file'] ?? 0 ) ); }
		if ( in_array( $operation, array( 'read', 'spam', 'trash_entry', 'restore_entry', 'delete_entry' ), true ) ) { $this->entry_action( absint( $_GET['entry'] ?? 0 ), $operation ); }
		if ( in_array( $operation, array( 'activate', 'deactivate', 'trash', 'restore', 'delete' ), true ) ) { $this->form_action( absint( $_GET['id'] ?? 0 ), $operation ); }
		$id = 'new' === $operation ? $repo->create_form( array( 'title' => __( 'Untitled form', 'nyforms' ), 'fields' => array() ) ) : $repo->duplicate( absint( $_GET['id'] ?? 0 ) );
		wp_safe_redirect( is_wp_error( $id ) ? admin_url( 'admin.php?page=nyforms' ) : add_query_arg( array( 'page' => 'nyforms', 'form' => $id ), admin_url( 'admin.php' ) ) ); exit;
	}

	private function export_csv( $form_id ) {
		if ( ! current_user_can( 'nyforms_export_entries' ) ) { wp_die( esc_html__( 'You are not allowed to export entries.', 'nyforms' ) ); }
		$form = Plugin::instance()->repository->form( $form_id );
		if ( ! $form ) { wp_die( esc_html__( 'Form not found.', 'nyforms' ) ); }
		$headers = array( 'entry_id', 'submitted_at', 'status' ); foreach ( $form['definition']['fields'] as $field ) { if ( ! in_array( $field['type'], array( 'html', 'section', 'page' ), true ) ) { $headers[] = $field['key']; } }
		nocache_headers(); header( 'Content-Type: text/csv; charset=utf-8' ); header( 'Content-Disposition: attachment; filename="nyforms-' . absint( $form_id ) . '-entries.csv"' ); $output = fopen( 'php://output', 'w' ); fputcsv( $output, $headers );
		foreach ( Plugin::instance()->repository->entries( $form_id, 'active', '', 1000 ) as $entry ) { $detail = Plugin::instance()->repository->entry( $entry['id'] ); $row = array( $entry['id'], $entry['submitted_at'], $entry['status'] ); foreach ( array_slice( $headers, 3 ) as $key ) { $value = $detail['values'][ $key ] ?? ''; $row[] = is_array( $value ) ? implode( ', ', $value ) : $value; } fputcsv( $output, $row ); } fclose( $output ); exit;
	}

	private function export_form( $form_id ) {
		$form = Plugin::instance()->repository->form( $form_id ); if ( ! $form ) { wp_die( esc_html__( 'Form not found.', 'nyforms' ) ); }
		nocache_headers(); header( 'Content-Type: application/json; charset=utf-8' ); header( 'Content-Disposition: attachment; filename="nyforms-form-' . absint( $form_id ) . '.json"' ); echo wp_json_encode( array( 'nyforms_format' => 1, 'exported_at' => gmdate( 'c' ), 'form' => $form['definition'] ), JSON_PRETTY_PRINT ); exit;
	}

	private function import_form() {
		$file = $_FILES['nyforms_import'] ?? array(); if ( empty( $file['tmp_name'] ) || UPLOAD_ERR_OK !== (int) $file['error'] || (int) $file['size'] > 2 * MB_IN_BYTES ) { wp_die( esc_html__( 'Choose a JSON export smaller than 2 MB.', 'nyforms' ) ); }
		$payload = json_decode( file_get_contents( $file['tmp_name'] ), true ); if ( ! is_array( $payload ) || 1 !== absint( $payload['nyforms_format'] ?? 0 ) || ! is_array( $payload['form'] ?? null ) ) { wp_die( esc_html__( 'This is not a valid NYforms export.', 'nyforms' ) ); }
		$id = Plugin::instance()->repository->create_form( $payload['form'] ); if ( is_wp_error( $id ) ) { wp_die( esc_html( $id->get_error_message() ) ); }
		wp_safe_redirect( add_query_arg( array( 'page' => 'nyforms', 'form' => $id ), admin_url( 'admin.php' ) ) ); exit;
	}

	private function entry_action( $entry_id, $operation ) {
		if ( ! current_user_can( 'nyforms_manage_entries' ) ) { wp_die( esc_html__( 'You are not allowed to manage entries.', 'nyforms' ) ); }
		$repo = Plugin::instance()->repository; $entry = $repo->entry( $entry_id ); if ( ! $entry ) { wp_die( esc_html__( 'Entry not found.', 'nyforms' ) ); }
		if ( 'read' === $operation ) { $repo->update_entry_status( $entry_id, $entry['status'], ! $entry['is_read'] ); } elseif ( 'spam' === $operation ) { $repo->update_entry_status( $entry_id, 'spam', true ); } elseif ( 'restore_entry' === $operation ) { $repo->update_entry_status( $entry_id, 'active', false ); } elseif ( 'delete_entry' === $operation ) { $repo->delete_entry( $entry_id ); } else { $repo->update_entry_status( $entry_id, 'trashed', true ); }
		wp_safe_redirect( add_query_arg( array( 'page' => 'nyforms-entries', 'form' => $entry['form_id'] ), admin_url( 'admin.php' ) ) ); exit;
	}

	private function download_file( $file_id ) {
		if ( ! current_user_can( 'nyforms_view_entries' ) ) { wp_die( esc_html__( 'You are not allowed to download uploads.', 'nyforms' ) ); }
		$file = Plugin::instance()->repository->file( $file_id ); $path = $file ? get_attached_file( absint( $file['attachment_id'] ) ) : false;
		if ( ! $file || ! $path || ! file_exists( $path ) ) { wp_die( esc_html__( 'Upload not found.', 'nyforms' ) ); }
		nocache_headers(); header( 'Content-Type: ' . sanitize_mime_type( $file['mime_type'] ) ); header( 'Content-Disposition: attachment; filename="' . sanitize_file_name( $file['original_name'] ) . '"' ); header( 'Content-Length: ' . filesize( $path ) ); readfile( $path ); exit;
	}

	private function form_action( $form_id, $operation ) {
		$repo = Plugin::instance()->repository;
		if ( 'delete' === $operation ) { $repo->delete_form( $form_id ); } else { $status = array( 'activate' => 'active', 'deactivate' => 'inactive', 'trash' => 'trash', 'restore' => 'inactive' ); $repo->set_form_status( $form_id, $status[ $operation ] ); }
		wp_safe_redirect( admin_url( 'admin.php?page=nyforms' ) ); exit;
	}

	private function bulk_forms() {
		$action = sanitize_key( wp_unslash( $_POST['bulk_action'] ?? '' ) ); $ids = array_map( 'absint', (array) ( $_POST['form_ids'] ?? array() ) );
		if ( $ids && in_array( $action, array( 'activate', 'draft', 'inactive', 'trash' ), true ) ) { foreach ( $ids as $id ) { Plugin::instance()->repository->set_form_status( $id, $action ); } }
		wp_safe_redirect( admin_url( 'admin.php?page=nyforms' ) ); exit;
	}

	private function require_manage() { if ( ! current_user_can( 'nyforms_manage_forms' ) ) { wp_die( esc_html__( 'You are not allowed to manage forms.', 'nyforms' ) ); } }
}
