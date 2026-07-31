<?php
/**
 * Theme bootstrap.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

$nydemo003_includes = array(
	'/inc/setup.php',
	'/inc/helpers.php',
	'/inc/enqueue.php',
	'/inc/template-tags.php',
	'/inc/customizer.php',
	'/inc/navigation.php',
);

foreach ( $nydemo003_includes as $nydemo003_include ) {
	require_once get_theme_file_path( $nydemo003_include );
}

unset( $nydemo003_include, $nydemo003_includes );
