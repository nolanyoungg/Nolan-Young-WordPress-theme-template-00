<?php
namespace NYMegaMenu;

defined( 'ABSPATH' ) || exit;

class Plugin {
	private static $instance;
	public static function instance() { if ( ! self::$instance ) { self::$instance = new self(); } return self::$instance; }
	private function __construct() { add_action( 'plugins_loaded', array( $this, 'boot' ) ); }
	public function boot() {
		load_plugin_textdomain( 'nymegamenu', false, dirname( plugin_basename( NYMEGAMENU_FILE ) ) . '/languages' );
		add_action( 'init', array( $this, 'panel_type' ) );
		add_action( 'init', array( $this, 'migrate_legacy_panels' ), 20 );
		$admin = new Admin();
		$admin->hooks();
		add_action( 'admin_menu', array( $admin, 'replace_locations_page_callback' ), 99 );
		add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		add_filter( 'wp_nav_menu_args', array( $this, 'integrate' ) );
		add_shortcode( 'nymegamenu', array( $this, 'shortcode' ) );
		add_action( 'init', array( $this, 'block' ) );
		add_action( 'widgets_init', array( $this, 'widget' ) );
	}
	public function panel_type() { register_post_type( 'nymega_panel', array( 'labels' => array( 'name' => __( 'Legacy Mega Content', 'nymegamenu' ), 'singular_name' => __( 'Legacy Mega Content', 'nymegamenu' ) ), 'public' => false, 'show_ui' => false, 'show_in_menu' => false, 'show_in_rest' => false, 'supports' => array( 'title', 'editor', 'revisions' ), 'capability_type' => 'post', 'map_meta_cap' => true ) ); }
	public function migrate_legacy_panels() {
		if ( get_option( 'nymegamenu_legacy_panel_migration', false ) ) { return; }
		$items = get_posts( array( 'post_type' => 'nav_menu_item', 'posts_per_page' => -1, 'fields' => 'ids', 'meta_key' => '_nymegamenu_item' ) );
		foreach ( $items as $item_id ) { $settings = Renderer::item_settings( $item_id ); if ( empty( $settings['panel_id'] ) || ! empty( $settings['custom_content'] ) ) { continue; } $panel = get_post( absint( $settings['panel_id'] ) ); if ( $panel && 'nymega_panel' === $panel->post_type ) { $settings['custom_content'] = $panel->post_content; $settings['content_source'] = 'custom'; $settings['legacy_panel_migrated'] = 1; update_post_meta( $item_id, '_nymegamenu_item', $settings ); } }
		update_option( 'nymegamenu_legacy_panel_migration', time(), false );
	}
	public function assets() {
		wp_register_style( 'nymegamenu', NYMEGAMENU_URL . 'assets/frontend.css', array( 'dashicons' ), NYMEGAMENU_VERSION );
		wp_register_script( 'nymegamenu', NYMEGAMENU_URL . 'assets/frontend.js', array(), NYMEGAMENU_VERSION, true );
		$settings = Settings::all();
		foreach ( $settings['locations'] as $profile ) {
			if ( ! empty( $profile['enabled'] ) ) {
				wp_enqueue_style( 'nymegamenu' );
				wp_enqueue_script( 'nymegamenu' );
				$this->generated_styles( $settings );
				break;
			}
		}
	}
	private function generated_styles( $settings ) {
		if ( 'none' === $settings['general']['css_output'] ) { return; }
		$css = Styles::all_css(); if ( ! $css ) { return; }
		if ( 'file' === $settings['general']['css_output'] ) { $uploads = wp_upload_dir(); $directory = trailingslashit( $uploads['basedir'] ) . 'nymegamenu'; if ( wp_mkdir_p( $directory ) && wp_is_writable( $directory ) ) { $filename = 'generated-' . md5( $css ) . '.css'; $path = trailingslashit( $directory ) . $filename; if ( ! file_exists( $path ) ) { file_put_contents( $path, $css, LOCK_EX ); } if ( file_exists( $path ) ) { wp_enqueue_style( 'nymegamenu-generated', trailingslashit( $uploads['baseurl'] ) . 'nymegamenu/' . $filename, array( 'nymegamenu' ), md5( $css ) ); return; } } }
		wp_add_inline_style( 'nymegamenu', $css );
	}
	private function wrapper( $location, $profile, $content ) {
		$themes = Settings::all()['themes'];
		$theme_key = sanitize_key( $profile['theme'] ?? 'default' ); $theme = $themes[ $theme_key ] ?? $themes['default'];
		$classes = array( 'nymegamenu', 'nymegamenu--' . sanitize_html_class( $profile['layout'] ?? 'horizontal' ), 'nymegamenu--location-' . sanitize_html_class( $location ), 'nymegamenu--theme-' . sanitize_html_class( $theme_key ) );
		if ( ! empty( $profile['sticky'] ) ) { $classes[] = 'nymegamenu--sticky'; }
		$extras = '';
		if ( ! empty( $profile['search'] ) ) { $extras .= get_search_form( false ); }
		if ( ! empty( $profile['cart'] ) ) { $extras .= '<a class="nymegamenu__cart" href="' . esc_url( apply_filters( 'nymegamenu_cart_url', home_url( '/cart/' ) ) ) . '">' . esc_html__( 'Cart', 'nymegamenu' ) . '</a>'; }
		$mobile_type = $profile['mobile_type'] ?? ( ! empty( $profile['offcanvas'] ) ? 'offcanvas' : 'show-hide' );
		$toggle = '<button class="nymegamenu__toggle" type="button" aria-expanded="false" data-nymega-toggle>' . esc_html( $theme['mobile']['toggle_label'] ) . '</button>';
		return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" data-nymega-menu data-nymega-trigger="' . esc_attr( $profile['trigger'] ?? 'click' ) . '" data-nymega-breakpoint="' . absint( $theme['mobile']['breakpoint'] ?? $profile['breakpoint'] ?? 900 ) . '" data-nymega-mobile-behavior="' . esc_attr( $profile['mobile_behavior'] ?? $theme['mobile']['submenu_behavior'] ?? 'accordion' ) . '" data-nymega-mobile-default="' . esc_attr( $profile['mobile_default_state'] ?? 'collapsed' ) . '" data-nymega-effect="' . esc_attr( $profile['desktop_effect'] ?? 'fade' ) . '" data-nymega-speed="' . esc_attr( $profile['desktop_speed'] ?? 'fast' ) . '" data-nymega-click-behavior="' . esc_attr( $profile['click_behavior'] ?? 'toggle-follow' ) . '"' . ( 'offcanvas' === $mobile_type ? ' data-nymega-offcanvas' : '' ) . '>' . $toggle . $extras . '<div class="nymegamenu__drawer" data-nymega-drawer>' . $content . '</div></div>';
	}
	public function integrate( $args ) {
		if ( empty( $args['theme_location'] ) || ! Settings::is_enabled( $args['theme_location'] ) ) { return $args; }
		$profile = Settings::location( $args['theme_location'] );
		$args['walker'] = new Menu_Walker( $args['theme_location'] );
		$args['menu_class'] = trim( (string) ( $args['menu_class'] ?? '' ) . ' nymegamenu__list' );
		$args['items_wrap'] = $this->wrapper( $args['theme_location'], $profile, '<ul id="%1$s" class="%2$s">%3$s</ul>' );
		wp_enqueue_style( 'nymegamenu' ); wp_enqueue_script( 'nymegamenu' );
		return $args;
	}
	public function shortcode( $atts ) { $atts = shortcode_atts( array( 'location' => '', 'menu' => '' ), $atts, 'nymegamenu' ); $location = sanitize_key( $atts['location'] ); if ( $location && ! Settings::is_enabled( $location ) ) { return ''; } wp_enqueue_style( 'nymegamenu' ); wp_enqueue_script( 'nymegamenu' ); $content = Renderer::render( array( 'theme_location' => $location, 'menu' => $atts['menu'], 'echo' => false ) ); return $this->wrapper( $location, Settings::location( $location ), $content ); }
	public function block() { register_block_type( NYMEGAMENU_DIR . 'blocks/menu' ); }
	public function widget() { register_widget( 'NYMegaMenu\\Menu_Widget' ); }
}

class Menu_Widget extends \WP_Widget {
	public function __construct() { parent::__construct( 'nymegamenu', __( 'NY Mega Menu', 'nymegamenu' ), array( 'description' => __( 'Display an enabled NY Mega Menu location.', 'nymegamenu' ) ) ); }
	public function widget( $args, $instance ) { echo $args['before_widget']; echo do_shortcode( '[nymegamenu location="' . esc_attr( $instance['location'] ?? '' ) . '"]' ); echo $args['after_widget']; }
	public function form( $instance ) { ?><p><label><?php esc_html_e( 'Menu location', 'nymegamenu' ); ?><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'location' ) ); ?>" value="<?php echo esc_attr( $instance['location'] ?? '' ); ?>"></label></p><?php }
	public function update( $new, $old ) { return array( 'location' => sanitize_key( $new['location'] ?? '' ) ); }
}
