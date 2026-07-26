<?php
/**
 * Primary navigation.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_navigation_classes = array( 'nytt01-primary-navigation' );
if ( function_exists( 'nymegamenu_is_enabled' ) && nymegamenu_is_enabled( 'primary' ) ) {
	$nytt01_navigation_classes[] = 'nytt01-primary-navigation--nymega';
}
?>
<nav id="site-navigation" class="<?php echo esc_attr( implode( ' ', $nytt01_navigation_classes ) ); ?>" data-nytt01-navigation aria-label="<?php esc_attr_e( 'Primary navigation', 'nolan-young-theme-template-01' ); ?>">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => 'primary-menu',
			'menu_class'     => 'nytt01-menu',
			'container'      => false,
			'fallback_cb'    => 'nytt01_primary_menu_fallback',
			'depth'          => 3,
			'walker'         => new NYTT01_Primary_Nav_Walker(),
		)
	);
	?>
</nav>
