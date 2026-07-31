<?php
/**
 * Theme bootstrap.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;

$nydemo001_includes = array(
	'/inc/setup.php',
	'/inc/helpers.php',
	'/inc/enqueue.php',
	'/inc/template-tags.php',
	'/inc/customizer.php',
	'/inc/navigation.php',
);

foreach ( $nydemo001_includes as $nydemo001_include ) {
	require_once get_theme_file_path( $nydemo001_include );
}

unset( $nydemo001_include, $nydemo001_includes );
