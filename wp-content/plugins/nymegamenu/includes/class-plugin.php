<?php
/**
 * Plugin bootstrap and public rendering entry points.
 *
 * @package NYMegaMenu
 */

namespace NYMegaMenu;

defined( 'ABSPATH' ) || exit;

/**
 * Main plugin controller.
 */
class Plugin {
	/** @var Plugin|null */
	private static $instance;

	/**
	 * Get the singleton plugin instance.
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register the delayed bootstrap hook.
	 */
	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'boot' ) );
	}

	/**
	 * Register plugin hooks.
	 *
	 * @return void
	 */
	public function boot() {
		$admin = new Admin();
		$admin->hooks();

		$theme_compatibility = new Theme_Compatibility();
		$theme_compatibility->hooks();

		add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
		add_filter( 'wp_nav_menu_args', array( $this, 'integrate' ) );
		add_shortcode( 'nymegamenu', array( $this, 'shortcode' ) );
		add_action( 'init', array( $this, 'block' ) );
		add_action( 'widgets_init', array( $this, 'widget' ) );
	}

	/**
	 * Enqueue public assets when at least one location is enabled.
	 *
	 * @return void
	 */
	public function assets() {
		$settings = Settings::all();
		foreach ( $settings['locations'] as $profile ) {
			if ( ! empty( $profile['enabled'] ) ) {
				$this->enqueue_assets( $settings );
				return;
			}
		}
	}

	/**
	 * Register and enqueue the public assets once.
	 *
	 * @param array|null $settings Settings already loaded by the caller.
	 * @return void
	 */
	private function enqueue_assets( $settings = null ) {
		wp_register_style( 'nymegamenu', NYMEGAMENU_URL . 'assets/frontend.css', array( 'dashicons' ), NYMEGAMENU_VERSION );
		wp_register_script( 'nymegamenu', NYMEGAMENU_URL . 'assets/frontend.js', array(), NYMEGAMENU_VERSION, true );
		wp_enqueue_style( 'nymegamenu' );
		wp_enqueue_script( 'nymegamenu' );
		$this->generated_styles( null === $settings ? Settings::all() : $settings );
	}

	/**
	 * Attach scoped, generated CSS as an inline stylesheet.
	 *
	 * File output was intentionally retired: direct filesystem writes are not
	 * portable across managed WordPress hosts and created stale upload files.
	 *
	 * @param array $settings Plugin settings.
	 * @return void
	 */
	private function generated_styles( $settings ) {
		if ( 'none' === $settings['general']['css_output'] ) {
			return;
		}

		$css = Styles::all_css();
		if ( $css ) {
			wp_add_inline_style( 'nymegamenu', $css );
		}
	}

	/**
	 * Remove generated CSS files from earlier plugin versions.
	 *
	 * @return void
	 */
	public function clear_generated_styles() {
		$uploads   = wp_upload_dir();
		$directory = trailingslashit( $uploads['basedir'] ) . 'nymegamenu';
		if ( ! is_dir( $directory ) ) {
			return;
		}

		$files = glob( trailingslashit( $directory ) . 'generated-*.css' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_glob -- Targets only plugin-generated legacy CSS.
		if ( false === $files ) {
			$files = array();
		}
		foreach ( $files as $file ) {
			wp_delete_file( $file );
		}
	}

	/**
	 * Build the complete NY Mega Menu wrapper.
	 *
	 * @param string $location Location slug.
	 * @param array  $profile  Location settings.
	 * @param string $content  Menu markup.
	 * @return string
	 */
	private function wrapper( $location, $profile, $content ) {
		$settings  = Settings::all();
		$themes    = $settings['themes'];
		$theme_key = sanitize_key( $profile['theme'] ?? 'default' );
		$theme     = $themes[ $theme_key ] ?? Settings::theme_defaults();
		$classes   = array(
			'nymegamenu',
			'nymegamenu--' . sanitize_html_class( $profile['layout'] ?? 'horizontal' ),
			'nymegamenu--location-' . sanitize_html_class( $location ),
			'nymegamenu--theme-' . sanitize_html_class( $theme_key ),
		);
		if ( ! empty( $profile['sticky'] ) ) {
			$classes[] = 'nymegamenu--sticky';
		}

		$mobile_type = $profile['mobile_type'] ?? 'show-hide';
		$drawer_id   = 'nymega-drawer-' . sanitize_html_class( $location );
		$toggle      = sprintf(
			'<button class="nymegamenu__toggle" type="button" aria-expanded="false" aria-controls="%1$s" data-nymega-toggle>%2$s</button>',
			esc_attr( $drawer_id ),
			esc_html( $theme['mobile']['toggle_label'] )
		);
		$overlay     = sprintf(
			'<button class="nymegamenu__overlay" type="button" data-nymega-overlay aria-label="%1$s" aria-hidden="true" tabindex="-1" hidden></button>',
			esc_attr__( 'Close menu', 'nymegamenu' )
		);
		$extras      = '';
		if ( ! empty( $profile['search'] ) ) {
			$extras .= get_search_form( false );
		}
		if ( ! empty( $profile['cart'] ) ) {
			$extras .= '<a class="nymegamenu__cart" href="' . esc_url( apply_filters( 'nymegamenu_cart_url', home_url( '/cart/' ) ) ) . '">' . esc_html__( 'Cart', 'nymegamenu' ) . '</a>';
		}

		return sprintf(
			'<div class="%1$s" data-nymega-menu data-nymega-trigger="%2$s" data-nymega-breakpoint="%3$d" data-nymega-mobile-behavior="%4$s" data-nymega-mobile-default="%5$s" data-nymega-effect="%6$s" data-nymega-speed="%7$s" data-nymega-mobile-speed="%8$s" data-nymega-click-behavior="%9$s" data-nymega-mobile-type="%10$s" data-nymega-overlay-desktop="%11$s" data-nymega-overlay-mobile="%12$s">%13$s%14$s%15$s<div id="%16$s" class="nymegamenu__drawer" data-nymega-drawer aria-hidden="true">%17$s</div></div>',
			esc_attr( implode( ' ', $classes ) ),
			esc_attr( $profile['trigger'] ?? 'click' ),
			absint( $profile['breakpoint'] ?? 900 ),
			esc_attr( $profile['mobile_behavior'] ?? 'accordion' ),
			esc_attr( $profile['mobile_default_state'] ?? 'collapsed' ),
			esc_attr( $profile['desktop_effect'] ?? 'fade' ),
			esc_attr( $profile['desktop_speed'] ?? 'fast' ),
			esc_attr( $profile['mobile_speed'] ?? 'fast' ),
			esc_attr( $profile['click_behavior'] ?? 'toggle-follow' ),
			esc_attr( $mobile_type ),
			esc_attr( ! empty( $profile['overlay_desktop'] ) ? '1' : '0' ),
			esc_attr( ! empty( $profile['overlay_mobile'] ) ? '1' : '0' ),
			$toggle,
			$overlay,
			$extras,
			esc_attr( $drawer_id ),
			$content
		);
	}

	/**
	 * Integrate the wrapper with native wp_nav_menu() calls for enabled locations.
	 *
	 * @param array $args Menu arguments.
	 * @return array
	 */
	public function integrate( $args ) {
		if ( ! empty( $args['nymegamenu_rendered'] ) || empty( $args['theme_location'] ) || ! Settings::is_enabled( $args['theme_location'] ) ) {
			return $args;
		}

		$profile            = Settings::location( $args['theme_location'] );
		$args['walker']     = new Menu_Walker();
		$args['menu_class'] = trim( (string) ( $args['menu_class'] ?? '' ) . ' nymegamenu__list' );
		$args['items_wrap'] = $this->wrapper( $args['theme_location'], $profile, '<ul id="%1$s" class="%2$s">%3$s</ul>' );
		$this->enqueue_assets();

		return $args;
	}

	/**
	 * Render the public helper, shortcode, block, and widget menu path.
	 *
	 * @param array $args Menu arguments.
	 * @return string
	 */
	public function render_menu( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'theme_location' => '',
				'menu'           => '',
				'echo'           => false,
			)
		);

		$echo     = ! empty( $args['echo'] );
		$location = sanitize_key( $args['theme_location'] );
		if ( ! $location || ! Settings::is_enabled( $location ) ) {
			return '';
		}

		$this->enqueue_assets();
		$args['nymegamenu_rendered'] = true;
		$content                     = Renderer::render( $args );
		$output                      = $this->wrapper( $location, Settings::location( $location ), $content );

		if ( $echo ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Fully escaped by wrapper and renderer.
			return '';
		}

		return $output;
	}

	/**
	 * Shortcode callback.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'location' => '',
				'menu'     => '',
			),
			$atts,
			'nymegamenu'
		);

		return $this->render_menu(
			array(
				'theme_location' => $atts['location'],
				'menu'           => $atts['menu'],
			)
		);
	}

	/** @return void */
	public function block() {
		register_block_type( NYMEGAMENU_DIR . 'blocks/menu' );
	}

	/** @return void */
	public function widget() {
		register_widget( 'NYMegaMenu\\Menu_Widget' );
	}
}

/**
 * Widget that renders an enabled location through the canonical render path.
 */
class Menu_Widget extends \WP_Widget {
	/** @return void */
	public function __construct() {
		parent::__construct(
			'nymegamenu',
			__( 'NY Mega Menu', 'nymegamenu' ),
			array( 'description' => __( 'Display an enabled NY Mega Menu location.', 'nymegamenu' ) )
		);
	}

	/**
	 * @param array $args     Widget display arguments.
	 * @param array $instance Widget settings.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Theme markup.
		echo Plugin::instance()->render_menu( array( 'theme_location' => $instance['location'] ?? '' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Fully escaped by render_menu().
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Theme markup.
	}

	/**
	 * @param array $instance Widget settings.
	 * @return void
	 */
	public function form( $instance ) {
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'location' ) ); ?>"><?php esc_html_e( 'Menu location', 'nymegamenu' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'location' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'location' ) ); ?>" value="<?php echo esc_attr( $instance['location'] ?? '' ); ?>">
		</p>
		<?php
	}

	/**
	 * @param array $new_instance New settings.
	 * @param array $old_instance Old settings.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return array( 'location' => sanitize_key( $new_instance['location'] ?? '' ) );
	}
}
