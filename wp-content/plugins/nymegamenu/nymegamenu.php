<?php
/**
 * Plugin Name: NY Mega Menu
 * Description: A branded, accessible navigation and mega-menu system by Nolan Young.
 * Version: 1.2.0
 * Requires at least: 7.0
 * Requires PHP: 7.4
 * Author: Nolan Young
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: nymegamenu
 *
 * @package NYMegaMenu
 */

defined( 'ABSPATH' ) || exit;

define( 'NYMEGAMENU_VERSION', '1.2.0' );
define( 'NYMEGAMENU_FILE', __FILE__ );
define( 'NYMEGAMENU_DIR', plugin_dir_path( __FILE__ ) );
define( 'NYMEGAMENU_URL', plugin_dir_url( __FILE__ ) );

foreach ( array( 'class-settings.php', 'class-styles.php', 'class-renderer.php', 'class-theme-compatibility.php', 'class-admin.php', 'class-plugin.php' ) as $file ) {
	require_once NYMEGAMENU_DIR . 'includes/' . $file;
}

/**
 * Get the NY Mega Menu controller.
 *
 * @return \NYMegaMenu\Plugin
 */
function nymegamenu() {
	return \NYMegaMenu\Plugin::instance();
}

/**
 * Determine whether a location is enabled.
 *
 * @param string $location Location slug.
 * @return bool
 */
function nymegamenu_is_enabled( $location ) {
	return \NYMegaMenu\Settings::is_enabled( $location );
}

/**
 * Render an enabled menu location through the canonical public path.
 *
 * @param array $args wp_nav_menu() arguments.
 * @return string
 */
function nymegamenu_render_menu( $args = array() ) {
	return \NYMegaMenu\Plugin::instance()->render_menu( $args );
}

nymegamenu();
