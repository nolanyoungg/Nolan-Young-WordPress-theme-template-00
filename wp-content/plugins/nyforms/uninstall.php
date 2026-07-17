<?php
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;
$settings = get_option( 'nyforms_settings', array() );
if ( empty( $settings['delete_data_on_uninstall'] ) ) { return; }
global $wpdb;
foreach ( array( 'nyforms_entry_files', 'nyforms_entry_values', 'nyforms_entries', 'nyforms_events', 'nyforms_forms' ) as $table ) { $wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . $table ); }
delete_option( 'nyforms_db_version' ); delete_option( 'nyforms_settings' );
