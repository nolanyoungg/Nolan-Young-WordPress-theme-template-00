<?php
/**
 * Front-end asset loading.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

function nydemo003_enqueue_assets() {
	$css_path = get_theme_file_path( '/dist/css/bundle.css' );
	$js_path  = get_theme_file_path( '/dist/js/bundle.js' );

	wp_enqueue_style( 'nydemo003-styles', nydemo003_asset_url( 'css/bundle.css' ), array(), file_exists( $css_path ) ? (string) filemtime( $css_path ) : '1.0.0' );
	wp_enqueue_script( 'nydemo003-scripts', nydemo003_asset_url( 'js/bundle.js' ), array(), file_exists( $js_path ) ? (string) filemtime( $js_path ) : '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'nydemo003_enqueue_assets' );
