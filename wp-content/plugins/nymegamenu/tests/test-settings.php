<?php
class NYMegaMenu_Settings_Test extends WP_UnitTestCase {
	public function test_location_requires_explicit_enablement() { update_option( 'nymegamenu_settings', array( 'locations' => array( 'primary' => array( 'enabled' => 1 ) ) ) ); $this->assertTrue( nymegamenu_is_enabled( 'primary' ) ); $this->assertFalse( nymegamenu_is_enabled( 'footer' ) ); }
	public function test_sanitizer_limits_breakpoint() { $settings = \NYMegaMenu\Settings::sanitize( array( 'locations' => array( 'primary' => array( 'enabled' => 1, 'breakpoint' => 9999, 'trigger' => 'invalid' ) ) ) ); $this->assertSame( 1600, $settings['locations']['primary']['breakpoint'] ); $this->assertSame( 'click', $settings['locations']['primary']['trigger'] ); }
}
