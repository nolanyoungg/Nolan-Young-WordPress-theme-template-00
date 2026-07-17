<?php
namespace NYMegaMenu;

defined( 'ABSPATH' ) || exit;

class Renderer {
	public static function render( $args = array() ) {
		$args = wp_parse_args( $args, array( 'theme_location' => '', 'menu' => '', 'echo' => false ) );
		$location = sanitize_key( $args['theme_location'] );
		if ( $location && ! Settings::is_enabled( $location ) ) { return ''; }
		$args['container'] = false;
		$args['menu_class'] = trim( (string) $args['menu_class'] . ' nymegamenu__list' );
		$args['walker'] = new Menu_Walker( $location );
		$args['fallback_cb'] = false;
		$output = wp_nav_menu( $args );
		return $args['echo'] ? '' : $output;
	}

	public static function item_settings( $item_id ) {
		$defaults = array( 'mode' => 'flyout', 'panel_id' => 0, 'icon' => '', 'badge' => '', 'hide_text' => 0, 'hide_arrow' => 0, 'disable_link' => 0, 'desktop' => 1, 'mobile' => 1, 'roles' => array(), 'tabbed' => 0 );
		return wp_parse_args( get_post_meta( $item_id, '_nymegamenu_item', true ), $defaults );
	}

	public static function visible( $settings ) {
		if ( ! is_user_logged_in() && in_array( 'logged_in', (array) $settings['roles'], true ) ) { return false; }
		$roles = array_filter( (array) $settings['roles'], static function( $role ) { return 'logged_in' !== $role; } );
		if ( $roles ) {
			$user = wp_get_current_user();
			if ( ! array_intersect( $roles, (array) $user->roles ) ) { return false; }
		}
		return true;
	}

	public static function panel( $panel_id, $mode, $trigger_id ) {
		if ( ! $panel_id || 'mega' !== $mode ) { return ''; }
		$panel = get_post( $panel_id );
		if ( ! $panel || 'nymega_panel' !== $panel->post_type ) { return ''; }
		return '<section id="' . esc_attr( $trigger_id . '-panel' ) . '" class="nymegamenu__panel" aria-labelledby="' . esc_attr( $trigger_id ) . '" hidden>' . do_blocks( $panel->post_content ) . '</section>';
	}
}

class Menu_Walker extends \Walker_Nav_Menu {
	private $location;
	public function __construct( $location = '' ) { $this->location = $location; }
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$settings = Renderer::item_settings( $item->ID );
		if ( ! Renderer::visible( $settings ) ) { return; }
		$classes = array_filter( (array) $item->classes );
		$classes[] = 'nymegamenu__item';
		$classes[] = 'nymegamenu__item--' . sanitize_html_class( $settings['mode'] );
		$output .= '<li class="' . esc_attr( implode( ' ', $classes ) ) . '" data-nymega-item data-nymega-desktop="' . esc_attr( (string) $settings['desktop'] ) . '" data-nymega-mobile="' . esc_attr( (string) $settings['mobile'] ) . '">';
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$title = '<span class="nymegamenu__label' . ( $settings['hide_text'] ? ' screen-reader-text' : '' ) . '">' . esc_html( wp_strip_all_tags( $title ) ) . '</span>';
		$icon = $settings['icon'] ? '<span class="nymegamenu__icon dashicons ' . esc_attr( sanitize_html_class( $settings['icon'] ) ) . '" aria-hidden="true"></span>' : '';
		$badge = $settings['badge'] ? '<span class="nymegamenu__badge">' . esc_html( $settings['badge'] ) . '</span>' : '';
		$has_panel = 'mega' === $settings['mode'] && $settings['panel_id'];
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$trigger_id = 'nymega-trigger-' . (int) $item->ID;
		if ( $has_panel || $has_children ) {
			$output .= '<button id="' . esc_attr( $trigger_id ) . '" class="nymegamenu__trigger" type="button" aria-expanded="false" aria-controls="' . esc_attr( $trigger_id . '-panel' ) . '" data-nymega-trigger>' . $icon . $title . $badge . ( $settings['hide_arrow'] ? '' : '<span class="nymegamenu__arrow" aria-hidden="true"></span>' ) . '</button>';
		} elseif ( $settings['disable_link'] ) {
			$output .= '<span class="nymegamenu__link nymegamenu__link--disabled">' . $icon . $title . $badge . '</span>';
		} else {
			$output .= '<a class="nymegamenu__link" href="' . esc_url( $item->url ) . '">' . $icon . $title . $badge . '</a>';
		}
		$output .= Renderer::panel( absint( $settings['panel_id'] ), $settings['mode'], $trigger_id );
	}
	public function start_lvl( &$output, $depth = 0, $args = null ) { $output .= '<ul class="nymegamenu__submenu">'; }
	public function end_lvl( &$output, $depth = 0, $args = null ) { $output .= '</ul>'; }
}
