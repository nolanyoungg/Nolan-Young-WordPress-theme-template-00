<?php
/** Theme bootstrap. @package NYTT99 */
defined( 'ABSPATH' ) || exit;
$nytt99_modules = array( '/inc/setup.php', '/inc/helpers.php', '/inc/enqueue.php', '/inc/template-tags.php', '/inc/customizer.php' );
foreach ( $nytt99_modules as $nytt99_module ) {
	require_once get_theme_file_path( $nytt99_module );
}
unset( $nytt99_module, $nytt99_modules );
