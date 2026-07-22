<?php
/**
 * Database installation and upgrade routines.
 *
 * @package NYforms
 */

namespace NYforms;

defined( 'ABSPATH' ) || exit;

/**
 * Manages NYForms database installation and schema upgrades.
 *
 * @package NYforms
 */
class Installer {
	/**
	 * Upgrade the plugin database schema when required.
	 *
	 * @return void
	 */
	public static function maybe_upgrade() {
		if ( get_option( 'nyforms_db_version' ) !== NYFORMS_DB_VERSION ) {
			self::activate();
		}

		self::upgrade_entries_table();
	}

	/**
	 * Create or upgrade the plugin database tables.
	 *
	 * @return void
	 */
	public static function activate() {
		global $wpdb;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		foreach ( self::get_schema_queries( $wpdb->prefix, $wpdb->get_charset_collate() ) as $query ) {
			dbDelta( $query );
		}

		if ( self::tables_exist() ) {
			update_option( 'nyforms_db_version', NYFORMS_DB_VERSION );
		}

		add_option(
			'nyforms_settings',
			array(
				'retention_days'           => 0,
				'delete_data_on_uninstall' => false,
				'rate_limit'               => 10,
				'data_collection'          => false,
				'recaptcha_enabled'        => false,
				'recaptcha_site_key'       => '',
				'recaptcha_secret_key'     => '',
				'recaptcha_type'           => 'checkbox',
				'rest_api_enabled'         => false,
			)
		);

		self::add_capabilities();
	}

	/**
	 * Return dbDelta-compatible table definitions.
	 *
	 * The dbDelta function parses each field and key from its own line. Keep these statements
	 * in WordPress's canonical format; changing them to one-line SQL can cause
	 * dbDelta to generate invalid ALTER TABLE statements.
	 *
	 * @param string $prefix Database table prefix.
	 * @param string $charset_collate Character set and collation clause.
	 * @return array<int, string>
	 */
	private static function get_schema_queries( $prefix, $charset_collate ) {
		$forms   = $prefix . 'nyforms_forms';
		$entries = $prefix . 'nyforms_entries';
		$values  = $prefix . 'nyforms_entry_values';
		$files   = $prefix . 'nyforms_entry_files';
		$events  = $prefix . 'nyforms_events';

		return array(
			"CREATE TABLE $forms (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			title varchar(191) NOT NULL,
			status varchar(20) NOT NULL DEFAULT 'active',
			definition longtext NOT NULL,
			revision bigint(20) unsigned NOT NULL DEFAULT 1,
			created_by bigint(20) unsigned NOT NULL DEFAULT 0,
			created_at datetime NOT NULL,
			updated_at datetime NOT NULL,
			PRIMARY KEY  (id),
			KEY status (status),
			KEY updated_at (updated_at)
			) $charset_collate;",
			"CREATE TABLE $entries (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			form_id bigint(20) unsigned NOT NULL,
			form_revision bigint(20) unsigned NOT NULL,
			status varchar(20) NOT NULL DEFAULT 'active',
			is_read tinyint(1) NOT NULL DEFAULT 0,
			is_starred tinyint(1) NOT NULL DEFAULT 0,
			submitted_by bigint(20) unsigned NOT NULL DEFAULT 0,
			source_url text NOT NULL,
			request_hash char(64) NOT NULL DEFAULT '',
			submitted_at datetime NOT NULL,
			updated_at datetime NOT NULL,
			PRIMARY KEY  (id),
			KEY form_status (form_id,status),
			KEY form_starred (form_id,is_starred),
			KEY submitted_at (submitted_at),
			KEY request_hash (request_hash)
			) $charset_collate;",
			"CREATE TABLE $values (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			entry_id bigint(20) unsigned NOT NULL,
			field_key varchar(100) NOT NULL,
			value longtext NOT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY entry_field (entry_id,field_key),
			KEY field_key (field_key)
			) $charset_collate;",
			"CREATE TABLE $files (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			entry_id bigint(20) unsigned NOT NULL,
			field_key varchar(100) NOT NULL,
			attachment_id bigint(20) unsigned NOT NULL,
			original_name text NOT NULL,
			mime_type varchar(100) NOT NULL,
			PRIMARY KEY  (id),
			KEY entry_id (entry_id)
			) $charset_collate;",
			"CREATE TABLE $events (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			form_id bigint(20) unsigned NOT NULL DEFAULT 0,
			entry_id bigint(20) unsigned NOT NULL DEFAULT 0,
			event_type varchar(100) NOT NULL,
			context longtext NOT NULL,
			created_at datetime NOT NULL,
			PRIMARY KEY  (id),
			KEY form_id (form_id),
			KEY entry_id (entry_id),
			KEY event_type (event_type)
			) $charset_collate;",
		);
	}

	/**
	 * Confirm that dbDelta created every required table before recording upgrade success.
	 *
	 * @return bool
	 */
	private static function tables_exist() {
		global $wpdb;

		foreach ( array( 'nyforms_forms', 'nyforms_entries', 'nyforms_entry_values', 'nyforms_entry_files', 'nyforms_events' ) as $suffix ) {
			$table = $wpdb->prefix . $suffix;
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Schema verification requires current table metadata immediately after dbDelta.
			$found = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table ) ) );

			if ( $table !== $found ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Deactivate scheduled tasks.
	 *
	 * @return void
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook( 'nyforms_purge_expired_entries' );
	}

	/**
	 * Add the starred-entry column for installations upgraded from earlier releases.
	 *
	 * @return void
	 */
	private static function upgrade_entries_table() {
		global $wpdb;

		$table = $wpdb->prefix . 'nyforms_entries';
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Schema upgrade requires current column metadata.
		$columns = $wpdb->get_col( $wpdb->prepare( 'SHOW COLUMNS FROM %i', $table ), 0 );

		if ( in_array( 'is_starred', (array) $columns, true ) ) {
			return;
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange -- This is the versioned schema migration for existing installations.
		$wpdb->query( $wpdb->prepare( 'ALTER TABLE %i ADD COLUMN is_starred tinyint(1) NOT NULL DEFAULT 0 AFTER is_read, ADD KEY form_starred (form_id,is_starred)', $table ) );
	}

	/**
	 * Add plugin capabilities to administrators.
	 *
	 * @return void
	 */
	private static function add_capabilities() {
		$role = get_role( 'administrator' );

		if ( ! $role ) {
			return;
		}

		foreach ( array( 'nyforms_manage_forms', 'nyforms_view_entries', 'nyforms_manage_entries', 'nyforms_export_entries' ) as $capability ) {
			$role->add_cap( $capability );
		}
	}
}
