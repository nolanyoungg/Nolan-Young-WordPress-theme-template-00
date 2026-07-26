<?php
/**
 * Native mobile-navigation control.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

// NY Mega Menu renders and controls its own responsive navigation toggle.
if ( function_exists( 'nymegamenu_is_enabled' ) && nymegamenu_is_enabled( 'primary' ) ) {
	return;
}
?>
<button class="nytt01-menu-toggle" type="button" data-nytt01-menu-toggle aria-controls="site-navigation" aria-expanded="false">
	<span class="nytt01-menu-toggle__label"><?php esc_html_e( 'Menu', 'nolan-young-theme-template-01' ); ?></span>
	<span class="nytt01-menu-toggle__icon" aria-hidden="true"></span>
</button>
