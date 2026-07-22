<?php
/**
 * Settings sanitization coverage.
 *
 * @package NYMegaMenu
 */

class NYMegaMenu_Settings_Test extends WP_UnitTestCase {
	public function tear_down() {
		delete_option( 'nymegamenu_settings' );
		parent::tear_down();
	}

	public function test_location_requires_explicit_enablement() {
		update_option( 'nymegamenu_settings', array( 'locations' => array( 'primary' => array( 'enabled' => 1 ) ) ) );

		$this->assertTrue( nymegamenu_is_enabled( 'primary' ) );
		$this->assertFalse( nymegamenu_is_enabled( 'footer' ) );
	}

	public function test_location_sanitizer_preserves_the_authoritative_breakpoint_and_runtime_options() {
		$settings = \NYMegaMenu\Settings::sanitize(
			array(
				'locations' => array(
					'primary' => array(
						'enabled'              => 1,
						'breakpoint'           => 9999,
						'trigger'              => 'hover-intent',
						'desktop_effect'       => 'slide',
						'desktop_speed'        => 'slow',
						'mobile_type'          => 'offcanvas',
						'mobile_speed'         => 'medium',
						'mobile_behavior'      => 'multiple',
						'mobile_default_state' => 'expanded',
						'click_behavior'       => 'follow',
						'overlay_desktop'      => 1,
						'overlay_mobile'       => 1,
					),
				),
			)
		);

		$profile = $settings['locations']['primary'];
		$this->assertSame( 1600, $profile['breakpoint'] );
		$this->assertSame( 'hover-intent', $profile['trigger'] );
		$this->assertSame( 'slide', $profile['desktop_effect'] );
		$this->assertSame( 'slow', $profile['desktop_speed'] );
		$this->assertSame( 'offcanvas', $profile['mobile_type'] );
		$this->assertSame( 'medium', $profile['mobile_speed'] );
		$this->assertSame( 'multiple', $profile['mobile_behavior'] );
		$this->assertSame( 'expanded', $profile['mobile_default_state'] );
		$this->assertSame( 'follow', $profile['click_behavior'] );
		$this->assertSame( 1, $profile['overlay_desktop'] );
		$this->assertSame( 1, $profile['overlay_mobile'] );
	}

	public function test_theme_sanitizer_accepts_the_quoted_font_offered_by_the_editor() {
		$theme                                     = \NYMegaMenu\Settings::theme_defaults();
		$theme['general']['font_family']           = '"Trebuchet MS", sans-serif';
		$theme['menu_bar']['divider']              = 1;
		$theme['menu_bar']['divider_glow_opacity'] = '4';

		$sanitized = \NYMegaMenu\Settings::sanitize_theme( $theme );

		$this->assertSame( '"Trebuchet MS", sans-serif', $sanitized['general']['font_family'] );
		$this->assertSame( '1', $sanitized['menu_bar']['divider_glow_opacity'] );
		$this->assertArrayNotHasKey( 'breakpoint', $sanitized['mobile'] );
	}
}
