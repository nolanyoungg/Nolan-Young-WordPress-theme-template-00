# NY Mega Menu

NY Mega Menu is an original Nolan Young navigation plugin for WordPress 7.0+ and PHP 7.4+.

## Setup

1. Activate the plugin and select **NY Mega Menu → Menu Locations**.
2. Enable a registered location and choose its theme, trigger, parent-link behavior, sticky, overlay, mobile mode, and responsive breakpoint. The breakpoint is configured per location.
3. In **Appearance → Menus**, select a menu item and choose a flyout or a Mega Menu grid. Mega Menu content can use child menu items, custom block markup, or a registered WordPress widget. Badges support four selectable theme styles.

Embed an enabled location with `[nymegamenu location="primary"]`, the NY Mega Menu block, the NY Mega Menu widget, or `nymegamenu_render_menu( array( 'theme_location' => 'primary' ) )`.

Parent menu links remain available alongside their submenu toggle. The selected click behavior controls whether a desktop parent link first opens its submenu or follows its destination.

## Accessibility and lifecycle

The compact off-canvas drawer supports a visible close control, Escape to close, focus restoration, focus containment, and optional click-to-close page overlays. The mobile submenu toggle is separate from the parent link.

Deactivation preserves settings and menu-item data. Deleting the plugin removes that data. **NY Mega Menu → Tools** also provides an explicit, confirmed delete-data action and removal for legacy generated CSS files; current versions output scoped styles inline and do not write CSS files to uploads.

The Cart link defaults to `/cart/`; sites can override it with the `nymegamenu_cart_url` filter.
