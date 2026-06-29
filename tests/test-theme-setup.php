<?php
/**
 * Theme setup tests.
 *
 * @package NolanYoungThemeTemplate01
 */

class NYTT01_Theme_Setup_Test extends WP_UnitTestCase {
	/**
	 * Restore the theme setup state cleared between WordPress unit tests.
	 *
	 * @return void
	 */
	public function set_up() {
		parent::set_up();
		$this->setExpectedIncorrectUsage( 'add_theme_support' );
		nytt01_setup();
	}

	/** @return void */
	public function test_required_theme_supports_are_registered() {
		$this->assertTrue( current_theme_supports( 'title-tag' ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		$this->assertTrue( current_theme_supports( 'html5' ) );
	}

	/** @return void */
	public function test_navigation_locations_are_registered() {
		$locations = get_registered_nav_menus();
		$this->assertArrayHasKey( 'primary', $locations );
		$this->assertArrayHasKey( 'footer', $locations );
	}
}
