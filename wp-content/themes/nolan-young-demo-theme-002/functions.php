<?php
/**
 * Theme bootstrap.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

$nydemo002_includes = array(
	'/inc/setup.php',
	'/inc/helpers.php',
	'/inc/enqueue.php',
	'/inc/template-tags.php',
	'/inc/customizer.php',
	'/inc/navigation.php',
);

foreach ( $nydemo002_includes as $nydemo002_include ) {
	require_once get_theme_file_path( $nydemo002_include );
}

unset( $nydemo002_include, $nydemo002_includes );
