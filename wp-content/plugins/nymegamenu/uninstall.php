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

$nymegamenu_uploads   = wp_upload_dir();
$nymegamenu_directory = trailingslashit( $nymegamenu_uploads['basedir'] ) . 'nymegamenu';
if ( is_dir( $nymegamenu_directory ) ) {
	$nymegamenu_files = glob( trailingslashit( $nymegamenu_directory ) . 'generated-*.css' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_glob -- Targets only plugin-generated legacy CSS.
	if ( false === $nymegamenu_files ) {
		$nymegamenu_files = array();
	}
	foreach ( $nymegamenu_files as $nymegamenu_file ) {
		wp_delete_file( $nymegamenu_file );
	}
}
