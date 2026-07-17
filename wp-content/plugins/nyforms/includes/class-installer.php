<?php
namespace NYforms;

defined( 'ABSPATH' ) || exit;

class Installer {
	public static function maybe_upgrade() { if ( get_option( 'nyforms_db_version' ) !== NYFORMS_DB_VERSION ) { self::activate(); } self::upgrade_entries_table(); }
	public static function activate() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$charset = $wpdb->get_charset_collate();
		$forms = $wpdb->prefix . 'nyforms_forms';
		$entries = $wpdb->prefix . 'nyforms_entries';
		$values = $wpdb->prefix . 'nyforms_entry_values';
		$files = $wpdb->prefix . 'nyforms_entry_files';
		$events = $wpdb->prefix . 'nyforms_events';
		dbDelta( "CREATE TABLE $forms (id bigint(20) unsigned NOT NULL AUTO_INCREMENT, title varchar(191) NOT NULL, status varchar(20) NOT NULL DEFAULT 'active', definition longtext NOT NULL, revision bigint(20) unsigned NOT NULL DEFAULT 1, created_by bigint(20) unsigned NOT NULL DEFAULT 0, created_at datetime NOT NULL, updated_at datetime NOT NULL, PRIMARY KEY  (id), KEY status (status), KEY updated_at (updated_at)) $charset;" );
		dbDelta( "CREATE TABLE $entries (id bigint(20) unsigned NOT NULL AUTO_INCREMENT, form_id bigint(20) unsigned NOT NULL, form_revision bigint(20) unsigned NOT NULL, status varchar(20) NOT NULL DEFAULT 'active', is_read tinyint(1) NOT NULL DEFAULT 0, is_starred tinyint(1) NOT NULL DEFAULT 0, submitted_by bigint(20) unsigned NOT NULL DEFAULT 0, source_url text NOT NULL, request_hash char(64) NOT NULL DEFAULT '', submitted_at datetime NOT NULL, updated_at datetime NOT NULL, PRIMARY KEY  (id), KEY form_status (form_id,status), KEY form_starred (form_id,is_starred), KEY submitted_at (submitted_at), KEY request_hash (request_hash)) $charset;" );
		dbDelta( "CREATE TABLE $values (id bigint(20) unsigned NOT NULL AUTO_INCREMENT, entry_id bigint(20) unsigned NOT NULL, field_key varchar(100) NOT NULL, value longtext NOT NULL, PRIMARY KEY  (id), UNIQUE KEY entry_field (entry_id,field_key), KEY field_key (field_key)) $charset;" );
		dbDelta( "CREATE TABLE $files (id bigint(20) unsigned NOT NULL AUTO_INCREMENT, entry_id bigint(20) unsigned NOT NULL, field_key varchar(100) NOT NULL, attachment_id bigint(20) unsigned NOT NULL, original_name text NOT NULL, mime_type varchar(100) NOT NULL, PRIMARY KEY  (id), KEY entry_id (entry_id)) $charset;" );
		dbDelta( "CREATE TABLE $events (id bigint(20) unsigned NOT NULL AUTO_INCREMENT, form_id bigint(20) unsigned NOT NULL DEFAULT 0, entry_id bigint(20) unsigned NOT NULL DEFAULT 0, event_type varchar(100) NOT NULL, context longtext NOT NULL, created_at datetime NOT NULL, PRIMARY KEY  (id), KEY form_id (form_id), KEY entry_id (entry_id), KEY event_type (event_type)) $charset;" );
		update_option( 'nyforms_db_version', NYFORMS_DB_VERSION );
		add_option( 'nyforms_settings', array( 'retention_days' => 0, 'delete_data_on_uninstall' => false, 'rate_limit' => 10, 'data_collection' => false, 'recaptcha_enabled' => false, 'recaptcha_site_key' => '', 'recaptcha_secret_key' => '', 'recaptcha_type' => 'checkbox', 'rest_api_enabled' => false ) );
		self::add_capabilities();
	}

	public static function deactivate() {
		wp_clear_scheduled_hook( 'nyforms_purge_expired_entries' );
	}

	private static function upgrade_entries_table() { global $wpdb; $table = $wpdb->prefix . 'nyforms_entries'; $columns = $wpdb->get_col( "SHOW COLUMNS FROM $table", 0 ); if ( in_array( 'is_starred', (array) $columns, true ) ) { return; } $wpdb->query( "ALTER TABLE $table ADD COLUMN is_starred tinyint(1) NOT NULL DEFAULT 0 AFTER is_read, ADD KEY form_starred (form_id,is_starred)" ); }

	private static function add_capabilities() {
		$role = get_role( 'administrator' );
		if ( ! $role ) { return; }
		foreach ( array( 'nyforms_manage_forms', 'nyforms_view_entries', 'nyforms_manage_entries', 'nyforms_export_entries' ) as $cap ) { $role->add_cap( $cap ); }
	}
}
