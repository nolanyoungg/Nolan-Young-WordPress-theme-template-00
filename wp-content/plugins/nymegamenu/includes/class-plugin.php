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
		( new Admin() )->hooks();
		add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		add_filter( 'wp_nav_menu_args', array( $this, 'integrate' ) );
		add_shortcode( 'nymegamenu', array( $this, 'shortcode' ) );
		add_action( 'init', array( $this, 'block' ) );
		add_action( 'widgets_init', array( $this, 'widget' ) );
	}
	public function panel_type() { register_post_type( 'nymega_panel', array( 'labels' => array( 'name' => __( 'Mega Panels', 'nymegamenu' ), 'singular_name' => __( 'Mega Panel', 'nymegamenu' ) ), 'public' => false, 'show_ui' => true, 'show_in_menu' => 'nymegamenu', 'show_in_rest' => true, 'supports' => array( 'title', 'editor', 'revisions' ), 'capability_type' => 'post', 'map_meta_cap' => true ) ); }
	public function assets() { wp_register_style( 'nymegamenu', NYMEGAMENU_URL . 'assets/frontend.css', array( 'dashicons' ), NYMEGAMENU_VERSION ); wp_register_script( 'nymegamenu', NYMEGAMENU_URL . 'assets/frontend.js', array(), NYMEGAMENU_VERSION, true ); }
	public function integrate( $args ) { if ( ! empty( $args['theme_location'] ) && Settings::is_enabled( $args['theme_location'] ) ) { $profile = Settings::location( $args['theme_location'] ); $themes = Settings::all()['themes']; $theme = $themes[ $profile['theme'] ?? 'default' ] ?? $themes['default']; $style = '--nymega-bg:' . $theme['background'] . ';--nymega-text:' . $theme['text'] . ';--nymega-accent:' . $theme['accent'] . ';--nymega-gap:' . absint( $theme['spacing'] ) . 'px;--nymega-radius:' . absint( $theme['radius'] ) . 'px'; $args['walker'] = new Menu_Walker( $args['theme_location'] ); $args['menu_class'] = trim( (string) ( $args['menu_class'] ?? '' ) . ' nymegamenu__list' ); $args['items_wrap'] = '<div class="nymegamenu nymegamenu--' . esc_attr( $profile['layout'] ?? 'horizontal' ) . '" data-nymega-menu data-nymega-trigger="' . esc_attr( $profile['trigger'] ?? 'click' ) . '" style="' . esc_attr( $style ) . '"><ul id="%1$s" class="%2$s">%3$s</ul></div>'; wp_enqueue_style( 'nymegamenu' ); wp_enqueue_script( 'nymegamenu' ); } return $args; }
	public function shortcode( $atts ) { $atts = shortcode_atts( array( 'location' => '', 'menu' => '' ), $atts, 'nymegamenu' ); wp_enqueue_style( 'nymegamenu' ); wp_enqueue_script( 'nymegamenu' ); return '<nav class="nymegamenu" data-nymega-menu>' . Renderer::render( array( 'theme_location' => sanitize_key( $atts['location'] ), 'menu' => $atts['menu'], 'echo' => false ) ) . '</nav>'; }
	public function block() { register_block_type( NYMEGAMENU_DIR . 'blocks/menu' ); }
	public function widget() { register_widget( 'NYMegaMenu\\Menu_Widget' ); }
}

class Menu_Widget extends \WP_Widget {
	public function __construct() { parent::__construct( 'nymegamenu', __( 'NY Mega Menu', 'nymegamenu' ), array( 'description' => __( 'Display an enabled NY Mega Menu location.', 'nymegamenu' ) ) ); }
	public function widget( $args, $instance ) { echo $args['before_widget']; echo do_shortcode( '[nymegamenu location="' . esc_attr( $instance['location'] ?? '' ) . '"]' ); echo $args['after_widget']; }
	public function form( $instance ) { ?><p><label><?php esc_html_e( 'Menu location', 'nymegamenu' ); ?><input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'location' ) ); ?>" value="<?php echo esc_attr( $instance['location'] ?? '' ); ?>"></label></p><?php }
	public function update( $new, $old ) { return array( 'location' => sanitize_key( $new['location'] ?? '' ) ); }
}
