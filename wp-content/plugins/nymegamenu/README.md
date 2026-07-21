# NY Mega Menu

NY Mega Menu is an original Nolan Young navigation plugin for WordPress 7.0+ and PHP 7.4+.

## Setup

1. Activate the plugin and select **NY Mega Menu → Menu Locations**.
2. Enable a registered location and choose its theme, interaction, sticky, off-canvas, search, cart, and responsive-breakpoint settings.
3. In **Appearance → Menus**, select a menu item and choose a flyout or a Mega Panel. Configure role visibility or tabbed-panel behavior when needed.
4. Create Mega Panels from **NY Mega Menu → Mega Panels**. Panels use the block editor, so they can contain columns, navigation, patterns, and Legacy Widget blocks.

Embed an enabled location with `[nymegamenu location="primary"]`, the NY Mega Menu block, the NY Mega Menu widget, or `nymegamenu_render_menu( array( 'theme_location' => 'primary' ) )`.

Role visibility only controls whether a navigation item is displayed. It does not restrict the linked content.

The Cart link defaults to `/cart/`; sites can override it with the `nymegamenu_cart_url` filter.
