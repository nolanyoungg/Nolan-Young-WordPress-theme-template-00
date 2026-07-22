<?php
/**
 * Remove NY Mega Menu data on explicit plugin deletion.
 *
 * @package NYMegaMenu
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

global $wpdb;

delete_option( 'nymegamenu_settings' );
// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Uninstall must remove all plugin-owned per-item metadata in one operation.
$wpdb->delete( $wpdb->postmeta, array( 'meta_key' => '_nymegamenu_item' ) );

$uploads   = wp_upload_dir();
$directory = trailingslashit( $uploads['basedir'] ) . 'nymegamenu';
if ( is_dir( $directory ) ) {
	$files = glob( trailingslashit( $directory ) . 'generated-*.css' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_glob -- Targets only plugin-generated legacy CSS.
	if ( false === $files ) {
		$files = array();
	}
	foreach ( $files as $file ) {
		wp_delete_file( $file );
	}
}
