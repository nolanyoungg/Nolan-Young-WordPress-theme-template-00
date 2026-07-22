=== NY Mega Menu ===
Contributors: nolanyoungg
Tags: mega menu, navigation, responsive menu, accessibility, menus
Requires at least: 7.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Build accessible, responsive WordPress navigation menus with optional mega-menu panels, location-specific behavior, and scoped styling.

== Description ==

NY Mega Menu enhances registered WordPress menu locations without replacing the normal menu workflow. Configure each enabled location from **NY Mega Menu -> Menu Locations**, then manage the menu itself from **Appearance -> Menus**.

Features include:

* Separate parent links and submenu controls, so parent destinations remain usable.
* Click, hover, and hover-intent desktop interactions with configurable overlays and effects.
* Responsive show/hide, slide-down, and off-canvas drawer modes.
* Keyboard support, Escape handling, focus restoration, off-canvas focus containment, and optional overlay close behavior.
* Menu-item flyouts, child-menu mega grids, custom block markup, WordPress widgets, and four badge styles.
* Location-scoped styling, a shortcode, a block, a widget, and a PHP rendering helper.

The plugin does not make external service calls, collect telemetry, or write generated CSS files to uploads.

== Installation ==

1. Upload the `nymegamenu` directory to `/wp-content/plugins/`, or install it through the WordPress Plugins screen.
2. Activate NY Mega Menu.
3. Open **NY Mega Menu -> Menu Locations**, enable a registered menu location, and configure its behavior and breakpoint.
4. Assign a WordPress menu to that location under **Appearance -> Menus**.
5. For a mega panel, open a menu item in **Appearance -> Menus** and choose its content mode.

You can also render an enabled location with `[nymegamenu location="primary"]`, the NY Mega Menu block, the NY Mega Menu widget, or:

`nymegamenu_render_menu( array( 'theme_location' => 'primary' ) );`

== Frequently Asked Questions ==

= Does deactivation delete my menu configuration? =

No. Deactivation preserves settings and menu-item data. Deleting the plugin removes that data. The Tools page also has an explicit, confirmed delete-data action.

= Can I keep a parent menu item linked to its page? =

Yes. Parent links remain anchors. A separate button controls the submenu, and the selected desktop click behavior determines whether the first parent-link click opens the submenu or follows the destination.

= Does the plugin require WooCommerce? =

No. The optional Cart link defaults to `/cart/`; developers can override it with the `nymegamenu_cart_url` filter.

== Changelog ==

= 1.2.0 =
* Restored canonical rendering for the PHP helper, block, widget, shortcode, and native menu integration.
* Preserved native WordPress menu attributes and filters while adding separate submenu controls.
* Completed responsive mode, overlay, accessibility, lifecycle, import-validation, and scoped-style behavior.
* Removed unsupported legacy panel, role, and tab configuration paths.

== Upgrade Notice ==

= 1.2.0 =
This release completes the supported configuration contract and retires unsupported legacy panel, role, and tab metadata.
