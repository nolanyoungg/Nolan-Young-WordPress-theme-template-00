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
		$panel_id     = 'nytt01-mega-panel-' . $mega_key . '-' . (int) $menu_item->ID;
		$trigger_id   = 'nytt01-mega-trigger-' . $mega_key . '-' . (int) $menu_item->ID;
		$is_current   = ! empty( $menu_item->current ) || ! empty( $menu_item->current_item_ancestor ) || in_array( 'current-menu-item', $classes, true ) || in_array( 'current_page_item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) || in_array( 'current_page_ancestor', $classes, true );
		$filtered     = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );
		$filtered     = apply_filters( 'nav_menu_item_title', $filtered, $menu_item, $args, $depth );
		$button_label = wp_strip_all_tags( (string) $filtered );

		$output .= '<li id="menu-item-' . esc_attr( (string) $menu_item->ID ) . '" class="' . esc_attr( $class_names ) . '" data-nytt01-mega-item="' . esc_attr( $mega_key ) . '">';
		$output .= '<button id="' . esc_attr( $trigger_id ) . '" class="nytt01-menu__trigger" type="button" aria-expanded="false" aria-controls="' . esc_attr( $panel_id ) . '" data-nytt01-mega-trigger>';
		$output .= '<span class="nytt01-menu__trigger-label">' . esc_html( $button_label ) . '</span>';
		$output .= '<span class="nytt01-menu__trigger-icon" aria-hidden="true"></span>';

		if ( $is_current ) {
			$output .= '<span class="screen-reader-text">' . esc_html__( '(current section)', 'nolan-young-theme-template-01' ) . '</span>';
		}

		$output .= '</button>';
		$output .= nytt01_get_mega_menu_markup( $mega_key, $panel_id, $trigger_id, $menu_item );
	}
}
