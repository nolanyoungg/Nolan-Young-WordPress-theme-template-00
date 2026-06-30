<?php
/**
 * Theme setup tests.
 *
 * @package NolanYoungThemeTemplate01
 */

class NYTT01_Theme_Setup_Test extends WP_UnitTestCase {
	/**
	 * Restore theme setup under the lifecycle state used by WordPress.
	 *
	 * @return void
	 */
	public function set_up() {
		parent::set_up();

		global $wp_actions;

		$wp_loaded_count = isset( $wp_actions['wp_loaded'] ) ? $wp_actions['wp_loaded'] : null;
		unset( $wp_actions['wp_loaded'] );

		nytt01_setup();

		if ( null !== $wp_loaded_count ) {
			$wp_actions['wp_loaded'] = $wp_loaded_count;
		}
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
