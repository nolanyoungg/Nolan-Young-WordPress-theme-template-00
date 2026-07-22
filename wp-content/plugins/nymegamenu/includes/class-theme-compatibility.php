<?php
/**
 * Theme compatibility bridge for NY Mega Menu.
 *
 * @package NYMegaMenu
 */

namespace NYMegaMenu;

defined( 'ABSPATH' ) || exit;

/**
 * Reuse an installed theme's public mega-panel API without altering the theme.
 */
class Theme_Compatibility {
	/**
	 * Register theme-bridge filters.
	 *
	 * @return void
	 */
	public function hooks() {
		add_filter( 'nymegamenu_menu_item_has_panel', array( $this, 'has_theme_panel' ), 10, 3 );
		add_filter( 'nymegamenu_menu_item_panel_markup', array( $this, 'render_theme_panel' ), 10, 4 );
	}

	/**
	 * Report whether an item has a supported theme panel.
	 *
	 * @param bool        $has_panel Built-in panel state.
	 * @param array       $settings  Item settings.
	 * @param object|null $menu_item Menu item.
	 * @return bool
	 */
	public function has_theme_panel( $has_panel, $settings, $menu_item ) {
		unset( $settings );

		return $has_panel || '' !== $this->nolan_young_panel_key( $menu_item );
	}

	/**
	 * Render a supported theme panel as a NY Mega Menu controlled panel.
	 *
	 * @param string      $panel      Existing panel markup.
	 * @param array       $settings   Item settings.
	 * @param string      $trigger_id Trigger element ID.
	 * @param object|null $menu_item  Menu item.
	 * @return string
	 */
	public function render_theme_panel( $panel, $settings, $trigger_id, $menu_item ) {
		unset( $settings );

		if ( '' !== $panel ) {
			return $panel;
		}

		$panel_key = $this->nolan_young_panel_key( $menu_item );
		if ( '' === $panel_key ) {
			return $panel;
		}

		$panel = nytt01_get_mega_menu_markup( $panel_key, $trigger_id . '-panel', $trigger_id, $menu_item );
		if ( '' === $panel ) {
			return '';
		}

		$panel_id = $trigger_id . '-panel';

		return preg_replace( '/(<div\s+id="' . preg_quote( $panel_id, '/' ) . '")/', '$1 data-nymega-panel', $panel, 1 );
	}

	/**
	 * Return the compatible theme's panel key for an item.
	 *
	 * This runs at render time, after the active theme has loaded its public
	 * navigation helpers. Other themes continue through NY Mega Menu's normal
	 * item settings and filters without any special behaviour.
	 *
	 * @param object|null $menu_item Menu item.
	 * @return string
	 */
	private function nolan_young_panel_key( $menu_item ) {
		if (
			! is_object( $menu_item ) ||
			'nolan-young-theme-template-01' !== get_template() ||
			! function_exists( 'nytt01_get_mega_menu_key' ) ||
			! function_exists( 'nytt01_get_mega_menu_markup' )
		) {
			return '';
		}

		$panel_key = nytt01_get_mega_menu_key( $menu_item );

		return is_string( $panel_key ) ? $panel_key : '';
	}
}
