<?php
/**
 * Primary navigation walker.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

/**
 * Custom primary navigation walker with accessible click-controlled mega menus.
 */
class NYTT01_Primary_Nav_Walker extends Walker_Nav_Menu {
	/**
	 * Render-instance prefix used to prevent duplicate DOM IDs.
	 *
	 * @var string
	 */
	private $instance_prefix;

	/**
	 * Create a walker with a unique render prefix.
	 */
	public function __construct() {
		static $instance = 0;

		++$instance;
		$this->instance_prefix = 'nytt01-nav-' . $instance;
	}

	/**
	 * Start a navigation menu item.
	 *
	 * @param string   $output Used to append additional content.
	 * @param WP_Post  $menu_item Menu item data object.
	 * @param int      $depth Depth of menu item.
	 * @param stdClass $args Menu arguments.
	 * @param int      $id Current item ID.
	 * @return void
	 */
	public function start_el( &$output, $menu_item, $depth = 0, $args = null, $id = 0 ) {
		$mega_key = 0 === $depth ? nytt01_get_mega_menu_key( $menu_item ) : '';

		if ( '' === $mega_key ) {
			parent::start_el( $output, $menu_item, $depth, $args, $id );
			return;
		}

		$classes      = array_filter( (array) $menu_item->classes );
		$classes[]    = 'menu-item-' . (int) $menu_item->ID;
		$classes[]    = 'nytt01-menu-item--mega';
		$classes[]    = 'nytt01-menu-item--' . $mega_key;
		$class_names  = implode( ' ', array_map( 'sanitize_html_class', array_unique( $classes ) ) );
		$panel_id     = $this->instance_prefix . '-mega-panel-' . $mega_key . '-' . (int) $menu_item->ID;
		$trigger_id   = $this->instance_prefix . '-mega-trigger-' . $mega_key . '-' . (int) $menu_item->ID;
		$is_current   = ! empty( $menu_item->current ) || ! empty( $menu_item->current_item_ancestor ) || in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) || in_array( 'current_page_ancestor', $classes, true );
		$filtered     = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );
		$filtered     = apply_filters( 'nav_menu_item_title', $filtered, $menu_item, $args, $depth );
		$button_label = wp_strip_all_tags( (string) $filtered );

		$output         .= '<li id="menu-item-' . esc_attr( (string) $menu_item->ID ) . '" class="' . esc_attr( $class_names ) . '" data-nytt01-mega-item="' . esc_attr( $mega_key ) . '">';
		$link_attributes = array(
			'class' => 'nytt01-menu__parent-link',
			'href'  => ! empty( $menu_item->url ) ? $menu_item->url : '',
		);

		if ( ! empty( $menu_item->target ) ) {
			$link_attributes['target'] = $menu_item->target;
		}
		if ( ! empty( $menu_item->xfn ) ) {
			$link_attributes['rel'] = $menu_item->xfn;
		}
		if ( $is_current ) {
			$link_attributes['aria-current'] = 'page';
		}

		$link_attributes = apply_filters( 'nav_menu_link_attributes', $link_attributes, $menu_item, $args, $depth );
		$output         .= '<a' . $this->build_atts( $link_attributes ) . '>' . esc_html( $button_label ) . '</a>';
		$output         .= '<button id="' . esc_attr( $trigger_id ) . '" class="nytt01-menu__trigger" type="button" aria-expanded="false" aria-controls="' . esc_attr( $panel_id ) . '" data-nytt01-mega-trigger>';
		$output         .= '<span class="screen-reader-text">' . sprintf(
			/* translators: %s: Menu item title. */
			esc_html__( 'Open %s menu', 'nolan-young-theme-template-01' ),
			esc_html( $button_label )
		) . '</span>';
		$output .= '<span class="nytt01-menu__trigger-icon" aria-hidden="true"></span>';
		$output .= '</button>';
		$output .= nytt01_get_mega_menu_markup( $mega_key, $panel_id, $trigger_id, $menu_item );
	}
}
