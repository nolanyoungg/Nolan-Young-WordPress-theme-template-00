<?php
/**
 * Menu rendering and the NY Mega Menu navigation walker.
 *
 * @package NYMegaMenu
 */

namespace NYMegaMenu;

defined( 'ABSPATH' ) || exit;

/**
 * Renders NY Mega Menu navigation markup.
 */
class Renderer {
	/**
	 * Render a menu without the outer NY Mega Menu wrapper.
	 *
	 * The public helper, shortcode, widget, and block all use Plugin::render_menu()
	 * for the complete wrapper and assets.
	 *
	 * @param array $args wp_nav_menu() arguments.
	 * @return string Menu markup.
	 */
	public static function render( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'theme_location' => '',
				'menu'           => '',
				'echo'           => false,
			)
		);

		$location = sanitize_key( $args['theme_location'] );
		if ( $location && ! Settings::is_enabled( $location ) ) {
			return '';
		}

		$args['container']   = false;
		$args['menu_class']  = trim( (string) ( $args['menu_class'] ?? '' ) . ' nymegamenu__list' );
		$args['walker']      = new Menu_Walker();
		$args['fallback_cb'] = false;
		$args['echo']        = false;

		return (string) wp_nav_menu( $args );
	}

	/**
	 * Get one menu item's stored NY Mega Menu settings.
	 *
	 * @param int $item_id Menu-item post ID.
	 * @return array<string, mixed>
	 */
	public static function item_settings( $item_id ) {
		$defaults = array(
			'mode'           => 'flyout',
			'icon'           => '',
			'badge'          => '',
			'badge_style'    => 1,
			'hide_text'      => 0,
			'hide_arrow'     => 0,
			'disable_link'   => 0,
			'desktop'        => 1,
			'mobile'         => 1,
			'grid_columns'   => 3,
			'content_source' => 'children',
			'custom_content' => '',
			'widget_class'   => '',
		);
		$stored   = get_post_meta( $item_id, '_nymegamenu_item', true );

		return wp_parse_args( is_array( $stored ) ? $stored : array(), $defaults );
	}

	/**
	 * Whether the item has a self-contained mega panel.
	 *
	 * @param array<string, mixed> $settings Item settings.
	 * @param object|null          $item     Menu item object.
	 * @return bool
	 */
	public static function has_panel( $settings, $item = null ) {
		$has_panel = false;
		if ( 'mega' === $settings['mode'] && 'children' !== $settings['content_source'] ) {
			if ( 'custom' === $settings['content_source'] ) {
				$has_panel = ! empty( $settings['custom_content'] );
			} elseif ( 'widget' === $settings['content_source'] ) {
				$has_panel = self::is_registered_widget( $settings['widget_class'] ?? '' );
			}
		}

		/**
		 * Allow themes and extensions to provide a complete panel for a menu item.
		 *
		 * The matching nymegamenu_menu_item_panel_markup filter must return the
		 * panel element, including its ID, hidden state, and data-nymega-panel
		 * attribute.
		 *
		 * @param bool        $has_panel Whether the item has a built-in panel.
		 * @param array       $settings  Saved NY Mega Menu item settings.
		 * @param object|null $item      Menu item object.
		 */
		return (bool) apply_filters( 'nymegamenu_menu_item_has_panel', $has_panel, $settings, $item );
	}

	/**
	 * Check that a saved widget class is a registered WordPress widget.
	 *
	 * @param string $widget_class Widget class name.
	 * @return bool
	 */
	public static function is_registered_widget( $widget_class ) {
		if ( ! is_string( $widget_class ) || ! class_exists( $widget_class ) || ! is_a( $widget_class, '\\WP_Widget', true ) ) {
			return false;
		}

		$widgets = isset( $GLOBALS['wp_widget_factory']->widgets ) ? $GLOBALS['wp_widget_factory']->widgets : array();

		return isset( $widgets[ $widget_class ] );
	}

	/**
	 * Render a custom or widget mega panel.
	 *
	 * @param array<string, mixed> $settings   Item settings.
	 * @param string               $trigger_id Trigger element ID.
	 * @param object|null          $item       Menu item object.
	 * @return string
	 */
	public static function panel( $settings, $trigger_id, $item = null ) {
		/**
		 * Filter the complete panel markup for a menu item.
		 *
		 * Returning non-empty markup replaces the built-in custom-block or widget
		 * panel. Callers are responsible for escaping their generated markup.
		 *
		 * @param string      $panel      Complete panel markup.
		 * @param array       $settings   Saved NY Mega Menu item settings.
		 * @param string      $trigger_id Trigger element ID.
		 * @param object|null $item       Menu item object.
		 */
		$filtered_panel = apply_filters( 'nymegamenu_menu_item_panel_markup', '', $settings, $trigger_id, $item );
		if ( is_string( $filtered_panel ) && '' !== $filtered_panel ) {
			return $filtered_panel;
		}

		if ( ! self::has_panel( $settings, $item ) ) {
			return '';
		}

		$content = '';
		if ( 'custom' === $settings['content_source'] ) {
			$content = do_blocks( $settings['custom_content'] );
		} elseif ( 'widget' === $settings['content_source'] ) {
			ob_start();
			the_widget(
				$settings['widget_class'],
				array(),
				array(
					'before_widget' => '<div class="nymegamenu__widget">',
					'after_widget'  => '</div>',
				)
			);
			$content = ob_get_clean();
		}

		if ( ! $content ) {
			return '';
		}

		return sprintf(
			'<section id="%1$s" class="nymegamenu__panel" aria-labelledby="%2$s" hidden><div class="nymegamenu__panel-inner"><div class="nymegamenu__grid" style="--nymega-grid-columns:%3$d">%4$s</div></div></section>',
			esc_attr( $trigger_id . '-panel' ),
			esc_attr( $trigger_id ),
			absint( $settings['grid_columns'] ),
			$content
		);
	}
}

/**
 * WordPress-compatible walker that adds NY Mega Menu controls.
 */
class Menu_Walker extends \Walker_Nav_Menu {
	/**
	 * Submenu IDs keyed by the parent depth.
	 *
	 * @var array<int, string>
	 */
	private $submenu_ids = array();

	/**
	 * Do not render child items when their parent provides a custom panel.
	 *
	 * @param object $element           Current menu item.
	 * @param array  $children_elements Child elements indexed by parent ID.
	 * @param int    $max_depth         Maximum depth.
	 * @param int    $depth             Current depth.
	 * @param array  $args              Walker arguments.
	 * @param string $output            Markup output.
	 * @return void
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( $element && isset( $element->ID ) && Renderer::has_panel( Renderer::item_settings( $element->ID ), $element ) ) {
			$children_elements[ $element->ID ] = array();
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Start a menu item.
	 *
	 * @param string      $output Output markup.
	 * @param object      $item   Menu item data object.
	 * @param int         $depth  Depth of menu item.
	 * @param object|null $args   Menu arguments.
	 * @param int         $id     Current item ID.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$args = is_object( $args ) ? $args : new \stdClass();
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native menu extension point.
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		$settings  = Renderer::item_settings( $item->ID );
		$classes   = array_filter( (array) $item->classes );
		$classes[] = 'nymegamenu__item';
		$classes[] = 'nymegamenu__item--' . sanitize_html_class( $settings['mode'] );
		if ( 'mega' === $settings['mode'] ) {
			$classes[] = 'nymegamenu__item--grid-' . absint( $settings['grid_columns'] );
		}

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native menu extension point.
		$classes = apply_filters( 'nav_menu_css_class', $classes, $item, $args, $depth );
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native menu extension point.
		$item_id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native menu extension point.
		$li_atts = apply_filters(
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native menu extension point.
			'nav_menu_item_attributes',
			array(
				'id'    => $item_id,
				'class' => implode( ' ', $classes ),
			),
			$item,
			$args,
			$depth
		);

		$has_panel    = Renderer::has_panel( $settings, $item );
		$has_children = ! empty( $args->has_children ) || in_array( 'menu-item-has-children', $classes, true );
		$trigger_id   = 'nymega-trigger-' . (int) $item->ID;
		if ( $has_children && ! $has_panel ) {
			$this->submenu_ids[ $depth ] = $trigger_id . '-submenu';
		}

		$output .= sprintf(
			'<li%1$s data-nymega-item data-nymega-desktop="%2$s" data-nymega-mobile="%3$s">',
			$this->build_attributes( $li_atts ),
			esc_attr( (string) ! empty( $settings['desktop'] ) ),
			esc_attr( (string) ! empty( $settings['mobile'] ) )
		);

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native title filter.
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native menu extension point.
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
		$link  = $this->link_markup( $item, $args, $depth, $title, $settings );

		$item_output = (string) ( $args->before ?? '' ) . $link;
		if ( $has_panel || $has_children ) {
			$controls     = $has_panel ? $trigger_id . '-panel' : $this->submenu_ids[ $depth ];
			$item_output .= sprintf(
				'<button id="%1$s" class="nymegamenu__trigger" type="button" aria-expanded="false" aria-controls="%2$s" data-nymega-trigger><span class="screen-reader-text">%3$s</span>%4$s</button>',
				esc_attr( $trigger_id ),
				esc_attr( $controls ),
				esc_html__( 'Toggle submenu', 'nymegamenu' ),
				! empty( $settings['hide_arrow'] ) ? '' : '<span class="nymegamenu__arrow" aria-hidden="true"></span>'
			);
		}
		$item_output .= Renderer::panel( $settings, $trigger_id, $item ) . (string) ( $args->after ?? '' );

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native menu extension point.
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Start a submenu list.
	 *
	 * @param string      $output Output markup.
	 * @param int         $depth  Depth of menu item.
	 * @param object|null $args   Menu arguments.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$args       = is_object( $args ) ? $args : new \stdClass();
		$submenu_id = $this->submenu_ids[ $depth ] ?? '';
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native submenu extension point.
		$classes    = apply_filters( 'nav_menu_submenu_css_class', array( 'sub-menu', 'nymegamenu__submenu' ), $args, $depth );
		$attributes = array(
			'class' => implode( ' ', array_filter( (array) $classes ) ),
		);
		if ( $submenu_id ) {
			$attributes['id'] = $submenu_id;
		}
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native submenu extension point.
		$attributes = apply_filters( 'nav_menu_submenu_attributes', $attributes, $args, $depth );
		$output    .= sprintf(
			'<ul%1$s hidden>',
			$this->build_attributes( $attributes )
		);
	}

	/**
	 * End a submenu list.
	 *
	 * @param string      $output Output markup.
	 * @param int         $depth  Depth of menu item.
	 * @param object|null $args   Menu arguments.
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		unset( $this->submenu_ids[ $depth ] );
		$output .= '</ul>';
	}

	/**
	 * Build the primary link or a disabled non-link label.
	 *
	 * @param object               $item     Menu item.
	 * @param object               $args     Menu arguments.
	 * @param int                  $depth    Menu depth.
	 * @param string               $title    Filtered title.
	 * @param array<string, mixed> $settings Item settings.
	 * @return string
	 */
	private function link_markup( $item, $args, $depth, $title, $settings ) {
		$content = $this->item_content( $title, $settings );
		if ( ! empty( $settings['disable_link'] ) ) {
			return sprintf( '<span class="nymegamenu__link nymegamenu__link--disabled">%s</span>', $content );
		}

		$link_atts = array(
			'target'       => $item->target,
			'rel'          => $item->xfn,
			'href'         => $item->url,
			'aria-current' => $item->current ? 'page' : '',
		);
		if ( ! empty( $item->attr_title ) ) {
			$link_atts['title'] = $item->attr_title;
		}

		$privacy_policy_url = get_privacy_policy_url();
		if ( $privacy_policy_url && $privacy_policy_url === $item->url ) {
			$link_atts['rel'] = trim( (string) $link_atts['rel'] . ' privacy-policy' );
		}

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Preserve WordPress's native menu extension point.
		$link_atts = apply_filters( 'nav_menu_link_attributes', $link_atts, $item, $args, $depth );

		return sprintf(
			'<a class="nymegamenu__link"%1$s>%2$s%3$s%4$s</a>',
			$this->build_attributes( $link_atts ),
			(string) ( $args->link_before ?? '' ),
			$content,
			(string) ( $args->link_after ?? '' )
		);
	}

	/**
	 * Build the visible menu label, icon, and badge.
	 *
	 * @param string               $title    Filtered title.
	 * @param array<string, mixed> $settings Item settings.
	 * @return string
	 */
	private function item_content( $title, $settings ) {
		$icon        = ! empty( $settings['icon'] )
			? '<span class="nymegamenu__icon dashicons ' . esc_attr( sanitize_html_class( $settings['icon'] ) ) . '" aria-hidden="true"></span>'
			: '';
		$label       = sprintf(
			'<span class="nymegamenu__label%1$s">%2$s</span>',
			! empty( $settings['hide_text'] ) ? ' screen-reader-text' : '',
			wp_kses_post( $title )
		);
		$badge_style = min( 4, max( 1, absint( $settings['badge_style'] ) ) );
		$badge       = ! empty( $settings['badge'] )
			? '<span class="nymegamenu__badge nymegamenu__badge--style-' . esc_attr( (string) $badge_style ) . '">' . esc_html( $settings['badge'] ) . '</span>'
			: '';

		return $icon . $label . $badge;
	}

	/**
	 * Convert a filtered attribute array to safe HTML attributes.
	 *
	 * @param array<string, mixed> $attributes Attributes.
	 * @return string
	 */
	private function build_attributes( $attributes ) {
		$output = '';
		foreach ( $attributes as $name => $value ) {
			if ( false === $value || '' === $value || ! is_scalar( $value ) ) {
				continue;
			}

			$output .= sprintf(
				' %1$s="%2$s"',
				esc_attr( $name ),
				'href' === $name ? esc_url( $value ) : esc_attr( $value )
			);
		}

		return $output;
	}
}
