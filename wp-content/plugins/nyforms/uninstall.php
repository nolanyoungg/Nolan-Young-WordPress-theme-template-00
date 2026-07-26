<?php
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;
$nyforms_settings = get_option( 'nyforms_settings', array() );
if ( empty( $nyforms_settings['delete_data_on_uninstall'] ) ) {
	return; }
global $wpdb;
foreach ( $wpdb->get_col( $wpdb->prepare( 'SELECT attachment_id FROM %i', $wpdb->prefix . 'nyforms_entry_files' ) ) as $nyforms_attachment_id ) {
	$nyforms_private_path = (string) get_post_meta( absint( $nyforms_attachment_id ), '_nyforms_private_path', true );
	if ( $nyforms_private_path && file_exists( $nyforms_private_path ) ) {
		wp_delete_file( $nyforms_private_path );
	}
	wp_delete_attachment( absint( $nyforms_attachment_id ), true );
}
foreach ( array( 'nyforms_entry_files', 'nyforms_entry_values', 'nyforms_entries', 'nyforms_events', 'nyforms_forms' ) as $nyforms_table ) {
	$wpdb->query( $wpdb->prepare( 'DROP TABLE IF EXISTS %i', $wpdb->prefix . $nyforms_table ) ); }
delete_option( 'nyforms_db_version' );
delete_option( 'nyforms_settings' );
wp_clear_scheduled_hook( 'nyforms_purge_expired_entries' );

foreach ( wp_roles()->roles as $nyforms_role_name => $nyforms_role_data ) {
	$nyforms_role = get_role( $nyforms_role_name );
	if ( ! $nyforms_role ) {
		continue;
	}
	foreach ( array( 'nyforms_manage_forms', 'nyforms_view_entries', 'nyforms_manage_entries', 'nyforms_export_entries' ) as $nyforms_capability ) {
		$nyforms_role->remove_cap( $nyforms_capability );
	}
}
