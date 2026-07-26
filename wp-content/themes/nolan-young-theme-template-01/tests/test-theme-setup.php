<?php
/**
 * Theme setup tests.
 *
 * @package NolanYoungThemeTemplate01
 */

/**
 * Theme setup test case.
 *
 * @package NolanYoungThemeTemplate01
 */
class NYTT01_Theme_Setup_Test extends WP_UnitTestCase {
	/**
	 * Confirm required theme supports are registered.
	 *
	 * @return void
	 */
	public function test_required_theme_supports_are_registered() {
		$this->assertTrue( current_theme_supports( 'title-tag' ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
	}

	/**
	 * Confirm navigation locations are registered.
	 *
	 * @return void
	 */
	public function test_navigation_locations_are_registered() {
		$locations = get_registered_nav_menus();
		$this->assertArrayHasKey( 'primary', $locations );
		$this->assertArrayHasKey( 'footer', $locations );
	}
}
