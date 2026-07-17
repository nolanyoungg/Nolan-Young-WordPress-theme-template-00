<?php
namespace NYforms;
defined( 'ABSPATH' ) || exit;
class Plugin {
	private static $instance;
	public $repository;
	public $renderer;
	public $notifications;
	private function __construct() { $this->repository = new Repository(); $this->renderer = new Renderer(); $this->notifications = new Notifications(); add_action( 'plugins_loaded', array( $this, 'boot' ) ); }
	public static function instance() { if ( ! self::$instance ) { self::$instance = new self(); } return self::$instance; }
	public function boot() { load_plugin_textdomain( 'nyforms', false, dirname( plugin_basename( NYFORMS_FILE ) ) . '/languages' ); ( new Admin() )->hooks(); ( new Rest() )->hooks(); ( new Privacy() )->hooks(); add_action( 'template_redirect', array( new Submissions(), 'handle' ) ); add_shortcode( 'nyforms', array( $this, 'shortcode' ) ); add_action( 'init', array( $this, 'block' ) ); add_action( 'wp_enqueue_scripts', array( $this, 'frontend_assets' ) ); add_action( 'nyforms_purge_expired_entries', array( $this, 'purge' ) ); if ( ! wp_next_scheduled( 'nyforms_purge_expired_entries' ) ) { wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', 'nyforms_purge_expired_entries' ); } }
	public function shortcode( $atts ) { $atts = shortcode_atts( array( 'id' => 0, 'class' => '' ), $atts, 'nyforms' ); return '<div class="nyforms-embed ' . esc_attr( sanitize_html_class( $atts['class'] ) ) . '">' . $this->renderer->render( absint( $atts['id'] ) ) . '</div>'; }
	public function block() { register_block_type( NYFORMS_DIR . 'blocks/form' ); }
	public function frontend_assets() { wp_register_style( 'nyforms-frontend', NYFORMS_URL . 'assets/frontend.css', array(), NYFORMS_VERSION ); wp_register_script( 'nyforms-frontend', NYFORMS_URL . 'assets/frontend.js', array(), NYFORMS_VERSION, true ); }
	public function purge() { global $wpdb; $settings = get_option( 'nyforms_settings', array() ); $days = absint( $settings['retention_days'] ?? 0 ); if ( $days ) { $wpdb->query( $wpdb->prepare( 'UPDATE ' . $wpdb->prefix . 'nyforms_entries SET status = "trashed" WHERE submitted_at < %s AND status = "active"', gmdate( 'Y-m-d H:i:s', time() - DAY_IN_SECONDS * $days ) ) ); } }
}
function nyforms_render_form( $form_id, $args = array() ) { return Plugin::instance()->renderer->render( $form_id, $args ); }
