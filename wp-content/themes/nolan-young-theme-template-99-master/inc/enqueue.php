<?php
defined( 'ABSPATH' ) || exit;
function nytt99_assets() {
	$css = get_theme_file_path( '/dist/css/bundle.css' ); $js = get_theme_file_path( '/dist/js/bundle.js' );
	wp_enqueue_style( 'nytt99-style', nytt99_asset( 'css/bundle.css' ), array(), file_exists( $css ) ? (string) filemtime( $css ) : '1.0.0' );
	wp_enqueue_script( 'nytt99-script', nytt99_asset( 'js/bundle.js' ), array(), file_exists( $js ) ? (string) filemtime( $js ) : '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'nytt99_assets' );
