<?php
/**
 * Plugin Name: NY Mega Menu
 * Description: A branded, accessible navigation and mega-menu system by Nolan Young.
 * Version: 1.0.0
 * Requires at least: 7.0
 * Requires PHP: 7.4
 * Author: Nolan Young
 * License: GPL-2.0-or-later
 * Text Domain: nymegamenu
 * Domain Path: /languages
 *
 * @package NYMegaMenu
 */

defined( 'ABSPATH' ) || exit;

define( 'NYMEGAMENU_VERSION', '1.0.0' );
define( 'NYMEGAMENU_FILE', __FILE__ );
define( 'NYMEGAMENU_DIR', plugin_dir_path( __FILE__ ) );
define( 'NYMEGAMENU_URL', plugin_dir_url( __FILE__ ) );

foreach ( array( 'class-settings.php', 'class-renderer.php', 'class-admin.php', 'class-plugin.php' ) as $file ) {
	require_once NYMEGAMENU_DIR . 'includes/' . $file;
}

function nymegamenu() {
	return \NYMegaMenu\Plugin::instance();
}

function nymegamenu_is_enabled( $location ) {
	return \NYMegaMenu\Settings::is_enabled( $location );
}

function nymegamenu_render_menu( $args = array() ) {
	return \NYMegaMenu\Renderer::render( $args );
}

nymegamenu();
