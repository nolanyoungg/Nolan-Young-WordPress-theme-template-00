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
		add_filter( 'nav_menu_link_attributes', $filter );

		$output = nymegamenu_render_menu( array( 'theme_location' => $this->location ) );

		remove_filter( 'nav_menu_link_attributes', $filter );
		$this->assertStringContainsString( 'data-nymega-menu', $output );
		$this->assertStringContainsString( 'data-nymega-breakpoint="720"', $output );
		$this->assertStringContainsString( 'data-nymega-click-behavior="follow"', $output );
		$this->assertStringContainsString( 'data-nymega-mobile-type="offcanvas"', $output );
		$this->assertStringContainsString( 'href="https://example.org/parent"', $output );
		$this->assertStringContainsString( 'target="_blank"', $output );
		$this->assertStringContainsString( 'data-nymega-test="preserved"', $output );
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
		$theme['menu_bar']['divider']              = 1;
		$theme['menu_bar']['divider_glow_opacity'] = '0.4';
		$theme['custom_css']                       = '@include mobile { #{$wrap}{outline:0;} }';

		$css = \NYMegaMenu\Styles::css( $this->location, 'default', $theme, array( 'breakpoint' => 740 ) );

		$this->assertStringContainsString( 'color:#123456', $css );
		$this->assertStringContainsString( 'font-size:21px', $css );
		$this->assertStringContainsString( 'text-align:right', $css );
		$this->assertStringContainsString( 'width:26rem', $css );
		$this->assertStringContainsString( 'opacity:0.4', $css );
		$this->assertStringContainsString( '@media (max-width:740px)', $css );
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
}
