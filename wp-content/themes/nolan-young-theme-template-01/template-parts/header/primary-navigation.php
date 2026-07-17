<?php
/**
 * Primary navigation.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

if ( function_exists( 'nymegamenu_is_enabled' ) && nymegamenu_is_enabled( 'primary' ) ) :
	?>
	<nav id="site-navigation" class="nytt01-primary-navigation nymegamenu" data-nymega-menu aria-label="<?php esc_attr_e( 'Primary navigation', 'nolan-young-theme-template-01' ); ?>">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => 'nytt01_primary_menu_fallback' ) ); ?>
	</nav>
	<?php
	return;
endif;
?>
<nav id="site-navigation" class="nytt01-primary-navigation" data-nytt01-navigation aria-label="<?php esc_attr_e( 'Primary navigation', 'nolan-young-theme-template-01' ); ?>">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
			'menu_class'     => 'nytt01-menu',
			'container'      => false,
			'fallback_cb'    => 'nytt01_primary_menu_fallback',
			'depth'          => 1,
			'walker'         => new NYTT01_Primary_Nav_Walker(),
		)
	);
	?>
</nav>
