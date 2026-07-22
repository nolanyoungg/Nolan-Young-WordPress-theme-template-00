<?php
/**
 * Integration coverage for public rendering APIs.
 *
 * @package NYMegaMenu
 */

class NYMegaMenu_Rendering_Test extends WP_UnitTestCase {
	private $location = 'nymega-test';

	public function set_up() {
		parent::set_up();
		register_nav_menu( $this->location, 'NY Mega Menu Test' );
	}

	public function tear_down() {
		unregister_nav_menu( $this->location );
		delete_option( 'nymegamenu_settings' );
		parent::tear_down();
	}

	public function test_public_helper_wraps_the_menu_preserves_link_filters_and_enqueues_assets() {
		$menu_id = wp_create_nav_menu( 'NY Mega Menu Test' );
		$parent  = wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'  => 'Parent',
				'menu-item-url'    => 'https://example.org/parent',
				'menu-item-type'   => 'custom',
				'menu-item-status' => 'publish',
				'menu-item-target' => '_blank',
			)
		);
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => 'Child',
				'menu-item-url'       => 'https://example.org/child',
				'menu-item-type'      => 'custom',
				'menu-item-status'    => 'publish',
				'menu-item-parent-id' => $parent,
			)
		);
		set_theme_mod( 'nav_menu_locations', array( $this->location => $menu_id ) );
		update_option(
			'nymegamenu_settings',
			array(
				'locations' => array(
					$this->location => array(
						'enabled'         => 1,
						'breakpoint'      => 720,
						'click_behavior'  => 'follow',
						'desktop_effect'  => 'slide',
						'mobile_type'     => 'offcanvas',
						'overlay_desktop' => 1,
						'overlay_mobile'  => 1,
					),
				),
			)
		);
		$filter = static function ( $attributes ) {
			$attributes['data-nymega-test'] = 'preserved';
			return $attributes;
		};
		$submenu_class_filter = static function ( $classes ) {
			$classes[] = 'nymega-submenu-filter';
			return $classes;
		};
		$submenu_attribute_filter = static function ( $attributes ) {
			$attributes['data-nymega-submenu-test'] = 'preserved';
			return $attributes;
		};
		add_filter( 'nav_menu_link_attributes', $filter );
		add_filter( 'nav_menu_submenu_css_class', $submenu_class_filter );
		add_filter( 'nav_menu_submenu_attributes', $submenu_attribute_filter );

		$output = nymegamenu_render_menu( array( 'theme_location' => $this->location ) );

		remove_filter( 'nav_menu_link_attributes', $filter );
		remove_filter( 'nav_menu_submenu_css_class', $submenu_class_filter );
		remove_filter( 'nav_menu_submenu_attributes', $submenu_attribute_filter );
		$this->assertStringContainsString( 'data-nymega-menu', $output );
		$this->assertStringContainsString( 'data-nymega-breakpoint="720"', $output );
		$this->assertStringContainsString( 'data-nymega-click-behavior="follow"', $output );
		$this->assertStringContainsString( 'data-nymega-mobile-type="offcanvas"', $output );
		$this->assertStringContainsString( 'href="https://example.org/parent"', $output );
		$this->assertStringContainsString( 'target="_blank"', $output );
		$this->assertStringContainsString( 'data-nymega-test="preserved"', $output );
		$this->assertStringContainsString( 'nymega-submenu-filter', $output );
		$this->assertStringContainsString( 'data-nymega-submenu-test="preserved"', $output );
		$this->assertStringContainsString( 'data-nymega-trigger', $output );
		$this->assertTrue( wp_style_is( 'nymegamenu', 'enqueued' ) );
		$this->assertTrue( wp_script_is( 'nymegamenu', 'enqueued' ) );
	}

	public function test_generated_css_uses_the_location_breakpoint_and_mobile_theme_values() {
		$theme                                     = \NYMegaMenu\Settings::theme_defaults();
		$theme['mobile']['item_color']             = '#123456';
		$theme['mobile']['item_size']              = '21px';
		$theme['mobile']['item_align']             = 'right';
		$theme['mobile']['offcanvas_width']        = '26rem';
		$theme['mobile']['force_full_width']       = 0;
		$theme['menu_bar']['divider']              = 1;
		$theme['menu_bar']['divider_glow_opacity'] = '0.4';
		$theme['custom_css']                       = '@include mobile { #{$wrap}{outline:0;} }';

		$css = \NYMegaMenu\Styles::css( $this->location, 'default', $theme, array( 'breakpoint' => 740 ) );

		$this->assertStringContainsString( 'color:#123456', $css );
		$this->assertStringContainsString( 'font-size:21px', $css );
		$this->assertStringContainsString( 'text-align:right', $css );
		$this->assertStringContainsString( 'width:26rem', $css );
		$this->assertStringContainsString( 'opacity:0.4', $css );
		$this->assertStringContainsString( 'justify-content:flex-end', $css );
		$this->assertStringContainsString( 'nymegamenu__widget:hover .widget-title', $css );
		$this->assertStringContainsString( '@media (max-width:740px)', $css );
		$this->assertStringContainsString( '.nymegamenu__item--mega>.nymegamenu__submenu', $css );
		$this->assertStringNotContainsString( 'nymegamenu__item--tabbed', $css );
	}

	public function test_enabled_location_with_a_removed_theme_uses_safe_default_styles() {
		update_option(
			'nymegamenu_settings',
			array(
				'locations' => array(
					$this->location => array(
						'enabled'    => 1,
						'theme'      => 'removed-theme',
						'breakpoint' => 730,
					),
				),
			)
		);

		$css = \NYMegaMenu\Styles::all_css();

		$this->assertStringContainsString( '.nymegamenu--location-nymega-test.nymegamenu--theme-removed-theme', $css );
		$this->assertStringContainsString( '--nymega-bg:', $css );
	}

	public function test_theme_can_supply_a_complete_menu_item_panel() {
		$item     = (object) array( 'ID' => 123 );
		$settings = \NYMegaMenu\Renderer::item_settings( 123 );
		$has      = static function ( $has_panel, $item_settings, $menu_item ) use ( $item ) {
			return $has_panel || $item === $menu_item && 'flyout' === $item_settings['mode'];
		};
		$panel    = static function ( $markup, $item_settings, $trigger_id, $menu_item ) use ( $item ) {
			if ( $item === $menu_item && 'flyout' === $item_settings['mode'] ) {
				return '<section data-nymega-panel id="' . esc_attr( $trigger_id . '-panel' ) . '" hidden>Theme panel</section>';
			}

			return $markup;
		};
		add_filter( 'nymegamenu_menu_item_has_panel', $has, 10, 3 );
		add_filter( 'nymegamenu_menu_item_panel_markup', $panel, 10, 4 );

		$this->assertTrue( \NYMegaMenu\Renderer::has_panel( $settings, $item ) );
		$this->assertSame( '<section data-nymega-panel id="nymega-trigger-123-panel" hidden>Theme panel</section>', \NYMegaMenu\Renderer::panel( $settings, 'nymega-trigger-123', $item ) );

		remove_filter( 'nymegamenu_menu_item_has_panel', $has, 10 );
		remove_filter( 'nymegamenu_menu_item_panel_markup', $panel, 10 );
	}

	public function test_unregistered_widget_class_cannot_create_a_mega_panel() {
		$settings                   = \NYMegaMenu\Renderer::item_settings( 123 );
		$settings['mode']           = 'mega';
		$settings['content_source'] = 'widget';
		$settings['widget_class']   = 'stdClass';

		$this->assertFalse( \NYMegaMenu\Renderer::has_panel( $settings ) );
	}
}
