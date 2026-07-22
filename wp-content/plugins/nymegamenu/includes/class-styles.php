<?php
/**
 * Scoped frontend style generation.
 *
 * @package NYMegaMenu
 */

namespace NYMegaMenu;

defined( 'ABSPATH' ) || exit;

/**
 * Generates CSS for one enabled location at a time.
 */
class Styles {
	/**
	 * Get the selector unique to a location/theme pairing.
	 *
	 * @param string $location  Menu location.
	 * @param string $theme_key Theme key.
	 * @return string
	 */
	public static function selector( $location, $theme_key ) {
		return '.nymegamenu--location-' . sanitize_html_class( $location ) . '.nymegamenu--theme-' . sanitize_html_class( $theme_key );
	}

	/**
	 * Join a four-sided box setting.
	 *
	 * @param array  $styles Setting group.
	 * @param string $prefix Setting prefix.
	 * @return string
	 */
	private static function box( $styles, $prefix ) {
		if ( isset( $styles[ $prefix . '_top' ] ) ) {
			return $styles[ $prefix . '_top' ] . ' ' . $styles[ $prefix . '_right' ] . ' ' . $styles[ $prefix . '_bottom' ] . ' ' . $styles[ $prefix . '_left' ];
		}

		return $styles[ $prefix . '_top_left' ] . ' ' . $styles[ $prefix . '_top_right' ] . ' ' . $styles[ $prefix . '_bottom_right' ] . ' ' . $styles[ $prefix . '_bottom_left' ];
	}

	/**
	 * Create the second- or third-level mega-menu item declarations.
	 *
	 * @param array  $mega   Mega settings.
	 * @param string $prefix Level prefix.
	 * @return string
	 */
	private static function level_css( $mega, $prefix ) {
		return 'background:transparent;border-color:' . $mega[ $prefix . '_border_color' ] . ';border-style:solid;border-width:' . self::box( $mega, $prefix . '_border' ) . ';color:' . $mega[ $prefix . '_color' ] . ';font-family:' . $mega[ $prefix . '_family' ] . ';font-size:' . $mega[ $prefix . '_size' ] . ';font-weight:' . $mega[ $prefix . '_weight' ] . ';margin:' . self::box( $mega, $prefix . '_margin' ) . ';padding:' . self::box( $mega, $prefix . '_padding' ) . ';text-align:' . $mega[ $prefix . '_align' ] . ';text-decoration:' . $mega[ $prefix . '_decoration' ] . ';text-transform:' . $mega[ $prefix . '_transform' ] . ';';
	}

	/**
	 * Create the hover declarations for a mega-menu item level.
	 *
	 * @param array  $mega   Mega settings.
	 * @param string $prefix Level prefix.
	 * @return string
	 */
	private static function level_hover_css( $mega, $prefix ) {
		return 'background:linear-gradient(90deg,' . $mega[ $prefix . '_hover_background_from' ] . ',' . $mega[ $prefix . '_hover_background_to' ] . ');border-color:' . $mega[ $prefix . '_hover_border_color' ] . ';color:' . $mega[ $prefix . '_hover_color' ] . ';font-weight:' . $mega[ $prefix . '_hover_weight' ] . ';text-decoration:' . $mega[ $prefix . '_hover_decoration' ] . ';';
	}

	/**
	 * Generate one location's styles.
	 *
	 * The responsive class is maintained by frontend.js from the location-level
	 * breakpoint. Rules therefore target .is-compact rather than a competing
	 * theme-wide media query.
	 *
	 * @param string $location  Menu location.
	 * @param string $theme_key Theme key.
	 * @param array  $theme     Theme settings.
	 * @param array  $profile   Location settings.
	 * @return string
	 */
	public static function css( $location, $theme_key, $theme, $profile ) {
		$theme          = Settings::normalize_theme( $theme );
		$selector       = self::selector( $location, $theme_key );
		$bar            = $theme['menu_bar'];
		$mega           = $theme['mega'];
		$flyout         = $theme['flyout'];
		$badges         = $theme['badges'];
		$mobile         = $theme['mobile'];
		$general        = $theme['general'];
		$compact        = $selector . '.nymegamenu.is-compact';
		$links          = $selector . ' .nymegamenu__link,' . $selector . ' .nymegamenu__trigger';
		$hover          = $selector . ' .nymegamenu__item:hover>.nymegamenu__link,' . $selector . ' .nymegamenu__item:hover>.nymegamenu__trigger,' . $selector . ' .nymegamenu__item.is-open>.nymegamenu__trigger';
		$current        = $selector . ' .current-menu-item>.nymegamenu__link,' . $selector . ' .current-menu-item>.nymegamenu__trigger';
		$panel          = $selector . ' .nymegamenu__panel';
		$child_mega     = $selector . ' .nymegamenu__item--mega>.nymegamenu__submenu';
		$grid           = $panel . ' .nymegamenu__grid';
		$widget         = $grid . '>.nymegamenu__widget,' . $grid . '>.nymegamenu__item';
		$title          = $panel . ' .widget-title,' . $panel . ' .nymegamenu__widget h1,' . $panel . ' .nymegamenu__widget h2,' . $panel . ' .nymegamenu__widget h3';
		$panel_width    = 'body' === $mega['outer_width'] ? '100vw' : $mega['outer_width'];
		$panel_position = 'body' === $mega['outer_width'] ? 'left:calc(50% - 50vw)' : 'left:0';
		$sticky_height  = $bar['sticky_transition'] ? $bar['sticky_height'] : $bar['height'];
		$breakpoint     = min( 1600, max( 480, absint( $profile['breakpoint'] ?? 900 ) ) );
		$icons          = array(
			'chevron' => '⌄',
			'caret'   => '▾',
			'arrow'   => '↓',
			'plus'    => '+',
		);
		$arrow          = $icons[ $general['arrow_icon'] ] ?? '';
		$shadow         = $general['shadow_enabled'] ? 'box-shadow:' . $general['shadow_horizontal'] . ' ' . $general['shadow_vertical'] . ' ' . $general['shadow_blur'] . ' ' . $general['shadow_spread'] . ' ' . $general['shadow_color'] . ';' : 'box-shadow:none;';
		$transition     = $general['hover_transitions'] ? 'transition:all ' . absint( $general['transition_ms'] ) . 'ms ease;' : 'transition:none;';
		$mobile_align   = array(
			'left'   => 'flex-start',
			'center' => 'center',
			'right'  => 'flex-end',
		);
		$mobile_justify = $mobile_align[ $mobile['item_align'] ] ?? 'center';
		$css            = '';

		$css .= $selector . '{--nymega-bg:' . $theme['background'] . ';--nymega-text:' . $theme['text'] . ';--nymega-accent:' . $theme['accent'] . ';--nymega-gap:' . absint( $theme['spacing'] ) . 'px;--nymega-radius:' . absint( $theme['radius'] ) . 'px;background:linear-gradient(90deg,' . $bar['background_from'] . ',' . $bar['background_to'] . ');border-radius:' . self::box( $bar, 'radius' ) . ';font-family:' . $general['font_family'] . ';line-height:' . $general['line_height'] . ';padding:' . self::box( $bar, 'padding' ) . ';z-index:' . absint( $general['z_index'] ) . ';}';
		$css .= $selector . ' .nymegamenu__list{gap:' . $bar['item_spacing'] . ';justify-content:' . $bar['items_align'] . ';min-height:' . $bar['height'] . ';}';
		$css .= $links . '{background:linear-gradient(90deg,' . $bar['item_background_from'] . ',' . $bar['item_background_to'] . ');border-color:' . $bar['item_border_color'] . ';border-style:solid;border-width:' . self::box( $bar, 'item_border' ) . ';border-radius:' . self::box( $bar, 'item_radius' ) . ';color:' . $bar['item_color'] . ';font-family:' . $bar['item_font_family'] . ';font-size:' . $bar['item_font_size'] . ';font-weight:' . $bar['item_font_weight'] . ';padding:' . self::box( $bar, 'item_padding' ) . ';text-align:' . $bar['item_text_align'] . ';text-decoration:' . $bar['item_text_decoration'] . ';text-transform:' . $bar['item_text_transform'] . ';' . $transition . '}';
		$css .= $hover . '{background:linear-gradient(90deg,' . $bar['item_hover_background_from'] . ',' . $bar['item_hover_background_to'] . ');border-color:' . $bar['item_hover_border_color'] . ';color:' . $bar['item_hover_color'] . ';font-weight:' . $bar['item_hover_font_weight'] . ';text-decoration:' . $bar['item_hover_text_decoration'] . ';}';
		$css .= $current . '{color:' . ( $bar['current_item'] ? $bar['item_hover_color'] : $bar['item_color'] ) . ';}';
		$css .= $selector . '.nymegamenu--sticky.is-stuck .nymegamenu__list{min-height:' . $sticky_height . ';}';
		$css .= $selector . ' .nymegamenu__panel,' . $selector . ' .nymegamenu__submenu{' . $shadow . 'z-index:' . absint( $general['z_index'] ) . ';}';
		$css .= $selector . ' .nymegamenu__link:focus-visible,' . $selector . ' .nymegamenu__trigger:focus-visible,' . $selector . ' .nymegamenu__toggle:focus-visible{outline:' . $general['focus_width'] . ' solid ' . $general['focus_color'] . ';outline-offset:' . $general['focus_offset'] . ';}';
		$css .= $selector . ' .nymegamenu__arrow{border:0;height:auto;transform:none;width:auto;}' . $selector . ' .nymegamenu__arrow:before{content:"' . $arrow . '";}' . ( 'disabled' === $general['arrow_icon'] ? $selector . ' .nymegamenu__arrow{display:none;}' : '' ) . ( $general['arrow_rotate'] ? $selector . ' .nymegamenu__item.is-open>.nymegamenu__trigger .nymegamenu__arrow{transform:rotate(180deg);}' : '' );
		$css .= $selector . ' .nymegamenu__overlay{background:' . $general['overlay_color'] . ';z-index:' . max( 1, absint( $general['z_index'] ) - 2 ) . ';}';
		$css .= $general['reset_widgets'] ? $selector . ' .nymegamenu__widget>*:first-child{margin-top:0;}' . $selector . ' .nymegamenu__widget>*:last-child{margin-bottom:0;}' : '';

		if ( $bar['divider'] ) {
			$css .= $selector . ' .nymegamenu__list>.nymegamenu__item+.nymegamenu__item:before{background:' . $bar['divider_color'] . ';box-shadow:0 0 6px ' . $bar['divider_color'] . ';content:"";inset-block:20%;inset-inline-start:calc(' . $bar['item_spacing'] . ' / -2);opacity:' . $bar['divider_glow_opacity'] . ';position:absolute;width:1px;}';
		}

		$mega_surface_css = $panel_position . ';background:linear-gradient(90deg,' . $mega['background_from'] . ',' . $mega['background_to'] . ');border-color:' . $mega['border_color'] . ';border-style:solid;border-width:' . self::box( $mega, 'border' ) . ';border-radius:' . self::box( $mega, 'radius' ) . ';padding:' . self::box( $mega, 'padding' ) . ';width:' . $panel_width . ';max-width:100vw;';
		$css             .= $panel . '{' . $mega_surface_css . '}';
		$css             .= $panel . ' .nymegamenu__panel-inner{margin-inline:auto;max-width:' . ( '.row' === $mega['inner_width'] ? '100%' : $mega['inner_width'] ) . ';}' . $grid . '{gap:' . $mega['columns_gap'] . ';}' . $widget . '{padding:' . self::box( $mega, 'column_padding' ) . ';}';
		$css             .= $title . '{border-color:' . $mega['widget_title_border_color'] . ';border-style:solid;border-width:' . self::box( $mega, 'widget_title_border' ) . ';color:' . $mega['widget_title_color'] . ';font-family:' . $mega['widget_title_family'] . ';font-size:' . $mega['widget_title_size'] . ';font-weight:' . $mega['widget_title_weight'] . ';margin:' . self::box( $mega, 'widget_title_margin' ) . ';padding:' . self::box( $mega, 'widget_title_padding' ) . ';text-align:' . $mega['widget_title_align'] . ';text-decoration:' . $mega['widget_title_decoration'] . ';text-transform:' . $mega['widget_title_transform'] . ';}' . $panel . ' .nymegamenu__widget:hover .widget-title,' . $panel . ' .nymegamenu__widget:hover h1,' . $panel . ' .nymegamenu__widget:hover h2,' . $panel . ' .nymegamenu__widget:hover h3{border-color:' . $mega['widget_title_hover_border_color'] . ';}' . $panel . ' .nymegamenu__widget{color:' . $mega['content_color'] . ';font-family:' . $mega['content_family'] . ';font-size:' . $mega['content_size'] . ';}';
		$css             .= $panel . ' .nymegamenu__grid>.nymegamenu__item>.nymegamenu__link,' . $panel . ' .nymegamenu__grid>.nymegamenu__item>.nymegamenu__trigger{' . self::level_css( $mega, 'second' ) . '}' . $panel . ' .nymegamenu__grid>.nymegamenu__item:hover>.nymegamenu__link,' . $panel . ' .nymegamenu__grid>.nymegamenu__item:hover>.nymegamenu__trigger{' . self::level_hover_css( $mega, 'second' ) . '}' . $panel . ' .nymegamenu__submenu .nymegamenu__link,' . $panel . ' .nymegamenu__submenu .nymegamenu__trigger{' . self::level_css( $mega, 'third' ) . '}' . $panel . ' .nymegamenu__submenu .nymegamenu__item:hover>.nymegamenu__link,' . $panel . ' .nymegamenu__submenu .nymegamenu__item:hover>.nymegamenu__trigger{' . self::level_hover_css( $mega, 'third' ) . '}';

		$fly       = $selector . ' .nymegamenu__submenu';
		$fly_links = $fly . ' .nymegamenu__link,' . $fly . ' .nymegamenu__trigger';
		$fly_hover = $fly . ' .nymegamenu__item:hover>.nymegamenu__link,' . $fly . ' .nymegamenu__item:hover>.nymegamenu__trigger';
		$css      .= $fly . '{background:linear-gradient(90deg,' . $flyout['background_from'] . ',' . $flyout['background_to'] . ');border-color:' . $flyout['border_color'] . ';border-style:solid;border-width:' . self::box( $flyout, 'border' ) . ';border-radius:' . self::box( $flyout, 'radius' ) . ';padding:' . self::box( $flyout, 'padding' ) . ';min-width:' . $flyout['width'] . ';}' . $fly_links . '{background:linear-gradient(90deg,' . $flyout['item_background_from'] . ',' . $flyout['item_background_to'] . ');color:' . $flyout['item_color'] . ';font-family:' . $flyout['item_family'] . ';font-size:' . $flyout['item_size'] . ';font-weight:' . $flyout['item_weight'] . ';min-height:' . $flyout['item_height'] . ';padding:' . self::box( $flyout, 'item_padding' ) . ';text-decoration:' . $flyout['item_decoration'] . ';text-transform:' . $flyout['item_transform'] . ';}' . $fly_hover . '{background:linear-gradient(90deg,' . $flyout['item_hover_background_from'] . ',' . $flyout['item_hover_background_to'] . ');color:' . $flyout['item_hover_color'] . ';font-weight:' . $flyout['item_hover_weight'] . ';text-decoration:' . $flyout['item_hover_decoration'] . ';}' . ( $flyout['item_divider'] ? $fly . ' .nymegamenu__item+.nymegamenu__item{border-top:1px solid ' . $flyout['item_divider_color'] . ';}' : '' );
		$css      .= $child_mega . '{' . $mega_surface_css . '}' . $child_mega . '>.nymegamenu__item>.nymegamenu__link,' . $child_mega . '>.nymegamenu__item>.nymegamenu__trigger{' . self::level_css( $mega, 'second' ) . '}' . $child_mega . '>.nymegamenu__item:hover>.nymegamenu__link,' . $child_mega . '>.nymegamenu__item:hover>.nymegamenu__trigger{' . self::level_hover_css( $mega, 'second' ) . '}' . $child_mega . ' .nymegamenu__submenu .nymegamenu__link,' . $child_mega . ' .nymegamenu__submenu .nymegamenu__trigger{' . self::level_css( $mega, 'third' ) . '}' . $child_mega . ' .nymegamenu__submenu .nymegamenu__item:hover>.nymegamenu__link,' . $child_mega . ' .nymegamenu__submenu .nymegamenu__item:hover>.nymegamenu__trigger{' . self::level_hover_css( $mega, 'third' ) . '}';

		$css .= $selector . ' .nymegamenu__badge{border-radius:' . self::box( $badges, 'radius' ) . ';font-family:' . $badges['font_family'] . ';font-size:' . $badges['font_size'] . ';font-weight:' . $badges['font_weight'] . ';padding:' . self::box( $badges, 'padding' ) . ';position:relative;top:' . $badges['vertical_offset'] . ';text-decoration:' . $badges['font_decoration'] . ';text-transform:' . $badges['font_transform'] . ';}';
		foreach ( array( 1, 2, 3, 4 ) as $style ) {
			$css .= $selector . ' .nymegamenu__badge--style-' . $style . '{background:linear-gradient(90deg,' . $badges[ 'style_' . $style . '_background_from' ] . ',' . $badges[ 'style_' . $style . '_background_to' ] . ');color:' . $badges[ 'style_' . $style . '_color' ] . ';}';
		}

		$css .= $compact . '{background:linear-gradient(90deg,' . $mobile['drawer_background_from'] . ',' . $mobile['drawer_background_to'] . ');}' . $compact . ' .nymegamenu__toggle{background:linear-gradient(90deg,' . $mobile['toggle_background_from'] . ',' . $mobile['toggle_background_to'] . ');border-radius:' . self::box( $mobile, 'toggle_radius' ) . ';color:' . $mobile['toggle_text'] . ';min-height:' . $mobile['toggle_height'] . ';}' . $compact . ' .nymegamenu__drawer{background:linear-gradient(90deg,' . $mobile['drawer_background_from'] . ',' . $mobile['drawer_background_to'] . ');padding:' . self::box( $mobile, 'drawer_padding' ) . ';}' . $compact . ' .nymegamenu__list>.nymegamenu__item>.nymegamenu__link,' . $compact . ' .nymegamenu__list>.nymegamenu__item>.nymegamenu__trigger{color:' . $mobile['item_color'] . ';font-size:' . $mobile['item_size'] . ';justify-content:' . $mobile_justify . ';text-align:' . $mobile['item_align'] . ';}' . $compact . ' .nymegamenu__grid{grid-template-columns:repeat(' . absint( $mobile['mega_columns'] ) . ',minmax(0,1fr));}' . $compact . ' .nymegamenu__item.is-open>.nymegamenu__trigger{background:linear-gradient(90deg,' . $mobile['active_background_from'] . ',' . $mobile['active_background_to'] . ');color:' . $mobile['item_active_color'] . ';}';
		$css .= $compact . ':not([data-nymega-mobile-type="offcanvas"]) .nymegamenu__drawer{position:' . ( $mobile['overlay_content'] ? 'absolute' : 'static' ) . ';}' . $compact . '[data-nymega-mobile-type="offcanvas"] .nymegamenu__drawer{max-width:' . ( $mobile['force_full_width'] ? '100vw' : '90vw' ) . ';width:' . ( $mobile['force_full_width'] ? '100vw' : $mobile['offcanvas_width'] ) . ';}';

		$custom = trim( $theme['custom_css'] );
		if ( $custom ) {
			$css .= self::custom_css( $custom, $selector, $breakpoint );
		}

		return $css;
	}

	/**
	 * Expand the documented selector tokens in custom CSS.
	 *
	 * @param string $css        Custom CSS.
	 * @param string $selector   Location selector.
	 * @param int    $breakpoint Location breakpoint.
	 * @return string
	 */
	private static function custom_css( $css, $selector, $breakpoint ) {
		$css = str_replace( array( '#{$wrap}', '#{$menu}', '{{wrapper}}', '{{menu}}' ), array( $selector, '.nymegamenu__list', $selector, '.nymegamenu__list' ), $css );
		return self::expand_mixins( $css, $breakpoint );
	}

	/**
	 * Expand simple mobile/desktop custom-CSS mixins.
	 *
	 * @param string $css        Custom CSS.
	 * @param int    $breakpoint Location breakpoint.
	 * @return string
	 */
	private static function expand_mixins( $css, $breakpoint ) {
		$offset = 0;
		while ( preg_match( '/@include\\s+(mobile|desktop)\\s*\\{/i', $css, $match, PREG_OFFSET_CAPTURE, $offset ) ) {
			$type  = strtolower( $match[1][0] );
			$start = $match[0][1];
			$open  = $start + strlen( $match[0][0] ) - 1;
			$close = self::closing_brace( $css, $open );
			if ( false === $close ) {
				break;
			}

			$inner       = substr( $css, $open + 1, $close - $open - 1 );
			$query       = 'mobile' === $type ? 'max-width:' . $breakpoint . 'px' : 'min-width:' . ( $breakpoint + 1 ) . 'px';
			$replacement = '@media (' . $query . '){' . self::expand_mixins( $inner, $breakpoint ) . '}';
			$css         = substr_replace( $css, $replacement, $start, $close - $start + 1 );
			$offset      = $start + strlen( $replacement );
		}

		return $css;
	}

	/**
	 * Find the closing brace paired to an opening brace.
	 *
	 * @param string $css  CSS string.
	 * @param int    $open Opening brace offset.
	 * @return int|false
	 */
	private static function closing_brace( $css, $open ) {
		$depth  = 0;
		$quote  = '';
		$length = strlen( $css );
		for ( $index = $open; $index < $length; $index++ ) {
			$character = $css[ $index ];
			if ( $quote ) {
				if ( $character === $quote && ( 0 === $index || '\\' !== $css[ $index - 1 ] ) ) {
					$quote = '';
				}
				continue;
			}

			if ( '"' === $character || "'" === $character ) {
				$quote = $character;
				continue;
			}
			if ( '{' === $character ) {
				++$depth;
			}
			if ( '}' === $character && 0 === --$depth ) {
				return $index;
			}
		}

		return false;
	}

	/**
	 * Generate CSS for every enabled location.
	 *
	 * @return string
	 */
	public static function all_css() {
		$settings = Settings::all();
		$css      = '';
		foreach ( $settings['locations'] as $location => $profile ) {
			$theme_key = $profile['theme'] ?? 'default';
			if ( ! empty( $profile['enabled'] ) ) {
				$theme = $settings['themes'][ $theme_key ] ?? Settings::theme_defaults();
				$css  .= self::css( $location, $theme_key, $theme, $profile );
			}
		}

		return $css;
	}
}
