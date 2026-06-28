<?php
/**
 * WordPress PHPUnit bootstrap.
 *
 * @package NolanYoungThemeTemplate01
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	fwrite( STDERR, "WordPress test library not found. Set WP_TESTS_DIR.\n" );
	exit( 1 );
}

$nytt01_theme_root = dirname( __DIR__ );
$nytt01_theme_slug = basename( $nytt01_theme_root );

if ( ! defined( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH' ) ) {
	define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', $nytt01_theme_root . '/vendor/yoast/phpunit-polyfills' );
}

require_once $nytt01_theme_root . '/vendor/autoload.php';
require_once $_tests_dir . '/includes/functions.php';

tests_add_filter(
	'muplugins_loaded',
	static function () use ( $nytt01_theme_root, $nytt01_theme_slug ) {
		register_theme_directory( dirname( $nytt01_theme_root ) );
		switch_theme( $nytt01_theme_slug );
	}
);

require $_tests_dir . '/includes/bootstrap.php';
