<?php
/**
 * Plugin Name: NYforms
 * Description: An original, privacy-minded WordPress form builder and submission manager.
 * Version: 1.0.3
 * Requires at least: 7.0
 * Requires PHP: 7.4
 * Author: Nolan Young
 * License: GPL-2.0-or-later
 * Text Domain: nyforms
 * Domain Path: /languages
 *
 * @package NYforms
 */

defined( 'ABSPATH' ) || exit;

define( 'NYFORMS_VERSION', '1.0.3' );
define( 'NYFORMS_DB_VERSION', '1.0.2' );
define( 'NYFORMS_FILE', __FILE__ );
define( 'NYFORMS_DIR', plugin_dir_path( __FILE__ ) );
define( 'NYFORMS_URL', plugin_dir_url( __FILE__ ) );

$nyforms_files = array(
	'includes/class-installer.php',
	'includes/class-schema.php',
	'includes/class-conditions.php',
	'includes/class-extensions.php',
	'includes/class-fields.php',
	'includes/class-storage.php',
	'includes/class-repository.php',
	'includes/class-renderer.php',
	'includes/class-submissions.php',
	'includes/class-notifications.php',
	'includes/class-admin.php',
	'includes/class-rest.php',
	'includes/class-privacy.php',
	'includes/class-plugin.php',
);

foreach ( $nyforms_files as $nyforms_file ) {
	require_once NYFORMS_DIR . $nyforms_file;
}

register_activation_hook( NYFORMS_FILE, array( '\\NYforms\\Installer', 'activate' ) );
register_deactivation_hook( NYFORMS_FILE, array( '\\NYforms\\Installer', 'deactivate' ) );
add_action( 'plugins_loaded', array( '\\NYforms\\Installer', 'maybe_upgrade' ) );
add_action( 'admin_init', array( '\\NYforms\\Installer', 'maybe_upgrade' ) );

function nyforms() {
	return \NYforms\Plugin::instance();
}

/**
 * Render a form from a theme or another plugin.
 *
 * @param int   $form_id Form ID.
 * @param array $args    Optional renderer arguments.
 * @return string
 */
function nyforms_render_form( $form_id, $args = array() ) {
	return \NYforms\Plugin::instance()->renderer->render( $form_id, $args );
}

nyforms();
