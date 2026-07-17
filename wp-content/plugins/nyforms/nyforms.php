<?php
/**
 * Plugin Name: NYforms
 * Description: An original, privacy-minded WordPress form builder and submission manager.
 * Version: 1.0.0
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

define( 'NYFORMS_VERSION', '1.0.0' );
define( 'NYFORMS_DB_VERSION', '1.0.0' );
define( 'NYFORMS_FILE', __FILE__ );
define( 'NYFORMS_DIR', plugin_dir_path( __FILE__ ) );
define( 'NYFORMS_URL', plugin_dir_url( __FILE__ ) );

$nyforms_files = array(
	'includes/class-installer.php',
	'includes/class-schema.php',
	'includes/class-conditions.php',
	'includes/class-extensions.php',
	'includes/class-fields.php',
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

function nyforms() {
	return \NYforms\Plugin::instance();
}

nyforms();
