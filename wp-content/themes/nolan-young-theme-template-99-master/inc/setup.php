<?php
/**
 * Theme registration and WordPress supports.
 *
 * @package NolanYoungThemeTemplate99Master
 */

defined( 'ABSPATH' ) || exit;

function nytt99_setup() {
	load_theme_textdomain( 'nolan-young-theme-template-99-master', get_template_directory() . '/languages' );
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
			'primary' => __( 'Primary navigation', 'nolan-young-theme-template-99-master' ),
			'footer'  => __( 'Footer navigation', 'nolan-young-theme-template-99-master' ),
		)
	);
}
add_action( 'after_setup_theme', 'nytt99_setup' );

function nytt99_register_sidebar() {
	register_sidebar(
		array(
			'name'          => __( 'Blog sidebar', 'nolan-young-theme-template-99-master' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<section class="widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'nytt99_register_sidebar' );
