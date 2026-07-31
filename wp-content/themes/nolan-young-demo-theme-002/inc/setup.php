<?php
/**
 * Theme registration and WordPress supports.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

function nydemo002_setup() {
	load_theme_textdomain( 'nolan-young-demo-theme-002', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus(
		array(
			'primary' => __( 'Primary navigation', 'nolan-young-demo-theme-002' ),
			'footer'  => __( 'Footer navigation', 'nolan-young-demo-theme-002' ),
		)
	);
}
add_action( 'after_setup_theme', 'nydemo002_setup' );

function nydemo002_register_sidebar() {
	register_sidebar(
		array(
			'name'          => __( 'Blog sidebar', 'nolan-young-demo-theme-002' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<section class="widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'nydemo002_register_sidebar' );
