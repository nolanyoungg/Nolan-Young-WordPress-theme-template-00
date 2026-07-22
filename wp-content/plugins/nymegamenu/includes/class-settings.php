<?php
namespace NYMegaMenu;

defined( 'ABSPATH' ) || exit;

class Settings {
	const OPTION = 'nymegamenu_settings';

	public static function theme_defaults() {
		return array(
			'name'       => __( 'NY Classic', 'nymegamenu' ),
			'background' => '#ffffff',
			'text'       => '#172033',
			'accent'     => '#1769e0',
			'spacing'    => 18,
			'radius'     => 12,
			'general'    => array(
				'font_family'       => 'inherit',
				'line_height'       => '1.5',
				'transition_ms'     => 180,
				'arrow_icon'        => 'chevron',
				'arrow_rotate'      => 1,
				'z_index'           => 9999,
				'shadow_enabled'    => 0,
				'shadow_horizontal' => '0px',
				'shadow_vertical'   => '0px',
				'shadow_blur'       => '0px',
				'shadow_spread'     => '0px',
				'shadow_color'      => 'transparent',
				'focus_color'       => '#109ce0',
				'focus_width'       => '3px',
				'focus_offset'      => '-3px',
				'overlay_color'     => 'rgba(0,0,0,0.3)',
				'hover_transitions' => 1,
				'reset_widgets'     => 0,
			),
			'menu_bar'   => array(
				'height'                     => '1em',
				'sticky_height'              => '3em',
				'sticky_transition'          => 0,
				'background_from'            => 'transparent',
				'background_to'              => 'transparent',
				'padding_top'                => '0px',
				'padding_right'              => '0px',
				'padding_bottom'             => '0px',
				'padding_left'               => '0px',
				'radius_top_left'            => '0px',
				'radius_top_right'           => '0px',
				'radius_bottom_right'        => '0px',
				'radius_bottom_left'         => '0px',
				'items_align'                => 'left',
				'item_color'                 => '#063b31',
				'item_font_size'             => '1.1rem',
				'item_font_family'           => 'inherit',
				'item_text_transform'        => 'none',
				'item_font_weight'           => 'normal',
				'item_text_decoration'       => 'none',
				'item_text_align'            => 'left',
				'item_hover_color'           => '#063b31',
				'item_hover_font_weight'     => 'normal',
				'item_hover_text_decoration' => 'underline',
				'item_background_from'       => 'transparent',
				'item_background_to'         => 'transparent',
				'item_hover_background_from' => 'transparent',
				'item_hover_background_to'   => 'transparent',
				'item_spacing'               => '0px',
				'item_padding_top'           => '0px',
				'item_padding_right'         => '0px',
				'item_padding_bottom'        => '0px',
				'item_padding_left'          => '0px',
				'item_border_color'          => 'transparent',
				'item_hover_border_color'    => 'transparent',
				'item_border_top'            => '0px',
				'item_border_right'          => '0px',
				'item_border_bottom'         => '0px',
				'item_border_left'           => '0px',
				'item_radius_top_left'       => '0px',
				'item_radius_top_right'      => '0px',
				'item_radius_bottom_right'   => '0px',
				'item_radius_bottom_left'    => '0px',
				'divider'                    => 0,
				'divider_color'              => '#00796b',
				'divider_glow_opacity'       => '0',
				'current_item'               => 0,
			),
			'mega'       => array(
				'outer_width'                     => 'body',
				'inner_width'                     => '.row',
				'background_from'                 => '#f9fff0',
				'background_to'                   => '#f9fff0',
				'padding_top'                     => '1em',
				'padding_right'                   => '0',
				'padding_bottom'                  => '1.5em',
				'padding_left'                    => '0',
				'border_color'                    => 'transparent',
				'border_top'                      => '0',
				'border_right'                    => '0',
				'border_bottom'                   => '0',
				'border_left'                     => '0',
				'radius_top_left'                 => '0',
				'radius_top_right'                => '0',
				'radius_bottom_right'             => '0',
				'radius_bottom_left'              => '0',
				'column_padding_top'              => '0',
				'column_padding_right'            => '1.5em',
				'column_padding_bottom'           => '0',
				'column_padding_left'             => '0',
				'columns_gap'                     => '0',
				'widget_title_color'              => '#222222',
				'widget_title_size'               => '1.125rem',
				'widget_title_family'             => 'inherit',
				'widget_title_transform'          => 'none',
				'widget_title_weight'             => 'normal',
				'widget_title_decoration'         => 'none',
				'widget_title_align'              => 'left',
				'widget_title_padding_top'        => '.5em',
				'widget_title_padding_right'      => '0',
				'widget_title_padding_bottom'     => '.25em',
				'widget_title_padding_left'       => '0',
				'widget_title_margin_top'         => '0',
				'widget_title_margin_right'       => '0',
				'widget_title_margin_bottom'      => '.25em',
				'widget_title_margin_left'        => '0',
				'widget_title_border_color'       => 'transparent',
				'widget_title_hover_border_color' => 'transparent',
				'widget_title_border_top'         => '0',
				'widget_title_border_right'       => '0',
				'widget_title_border_bottom'      => '0',
				'widget_title_border_left'        => '0',
				'content_color'                   => '#444444',
				'content_size'                    => '1rem',
				'content_family'                  => 'inherit',
				'second_color'                    => '#2468d5',
				'second_size'                     => '1rem',
				'second_family'                   => 'inherit',
				'second_transform'                => 'none',
				'second_weight'                   => 'normal',
				'second_decoration'               => 'none',
				'second_align'                    => 'left',
				'second_hover_color'              => '#0056b3',
				'second_hover_weight'             => 'normal',
				'second_hover_decoration'         => 'none',
				'second_hover_background_from'    => 'transparent',
				'second_hover_background_to'      => 'transparent',
				'second_padding_top'              => '.75em',
				'second_padding_right'            => '0',
				'second_padding_bottom'           => '.25em',
				'second_padding_left'             => '0',
				'second_margin_top'               => '0',
				'second_margin_right'             => '0',
				'second_margin_bottom'            => '.25em',
				'second_margin_left'              => '0',
				'second_border_color'             => '#0056b3',
				'second_hover_border_color'       => 'transparent',
				'second_border_top'               => '0',
				'second_border_right'             => '0',
				'second_border_bottom'            => '.125em',
				'second_border_left'              => '0',
				'third_color'                     => '#2468d5',
				'third_size'                      => '1rem',
				'third_family'                    => 'inherit',
				'third_transform'                 => 'none',
				'third_weight'                    => 'normal',
				'third_decoration'                => 'none',
				'third_align'                     => 'left',
				'third_hover_color'               => '#0056b3',
				'third_hover_weight'              => 'normal',
				'third_hover_decoration'          => 'none',
				'third_hover_background_from'     => 'transparent',
				'third_hover_background_to'       => 'transparent',
				'third_padding_top'               => '.125em',
				'third_padding_right'             => '0',
				'third_padding_bottom'            => '0',
				'third_padding_left'              => '0',
				'third_margin_top'                => '0',
				'third_margin_right'              => '0',
				'third_margin_bottom'             => '0',
				'third_margin_left'               => '0',
				'third_border_color'              => 'transparent',
				'third_hover_border_color'        => 'transparent',
				'third_border_top'                => '0',
				'third_border_right'              => '0',
				'third_border_bottom'             => '0',
				'third_border_left'               => '0',
			),
			'flyout'     => array(
				'width'                      => 'auto',
				'background_from'            => '#f9fff0',
				'background_to'              => '#f9fff0',
				'padding_top'                => '0',
				'padding_right'              => '0',
				'padding_bottom'             => '0',
				'padding_left'               => '0',
				'border_color'               => '#ffffff',
				'border_top'                 => '0',
				'border_right'               => '0',
				'border_bottom'              => '0',
				'border_left'                => '0',
				'radius_top_left'            => '0',
				'radius_top_right'           => '0',
				'radius_bottom_right'        => '0',
				'radius_bottom_left'         => '0',
				'item_background_from'       => '#f9fff0',
				'item_background_to'         => '#f9fff0',
				'item_hover_background_from' => '#063b31',
				'item_hover_background_to'   => '#063b31',
				'item_height'                => '1.5em',
				'item_padding_top'           => '.5em',
				'item_padding_right'         => '.75em',
				'item_padding_bottom'        => '.5em',
				'item_padding_left'          => '.75em',
				'item_color'                 => '#184b40',
				'item_size'                  => '1.125rem',
				'item_family'                => 'inherit',
				'item_transform'             => 'none',
				'item_weight'                => 'normal',
				'item_decoration'            => 'none',
				'item_hover_color'           => '#ffffff',
				'item_hover_weight'          => 'normal',
				'item_hover_decoration'      => 'none',
				'item_divider'               => 0,
				'item_divider_color'         => '#0056b3',
			),
			'badges'     => array(
				'radius_top_left'         => '2px',
				'radius_top_right'        => '2px',
				'radius_bottom_right'     => '2px',
				'radius_bottom_left'      => '2px',
				'padding_top'             => '1px',
				'padding_right'           => '4px',
				'padding_bottom'          => '1px',
				'padding_left'            => '4px',
				'vertical_offset'         => '-7px',
				'style_1_background_from' => '#d32f2f',
				'style_1_background_to'   => '#d32f2f',
				'style_1_color'           => '#ffffff',
				'style_2_background_from' => '#00796b',
				'style_2_background_to'   => '#00796b',
				'style_2_color'           => '#ffffff',
				'style_3_background_from' => '#ffc107',
				'style_3_background_to'   => '#ffc107',
				'style_3_color'           => '#ffffff',
				'style_4_background_from' => '#303f9f',
				'style_4_background_to'   => '#303f9f',
				'style_4_color'           => '#ffffff',
				'font_size'               => '10px',
				'font_family'             => 'inherit',
				'font_transform'          => 'none',
				'font_weight'             => 'normal',
				'font_decoration'         => 'none',
			),
			'mobile'     => array(
				'toggle_label'               => __( 'Menu', 'nymegamenu' ),
				'toggle_background_from'     => '#ffffff',
				'toggle_background_to'       => '#ffffff',
				'toggle_background'          => '#ffffff',
				'toggle_text'                => '#172033',
				'toggle_height'              => '40px',
				'toggle_radius_top_left'     => '0',
				'toggle_radius_top_right'    => '0',
				'toggle_radius_bottom_right' => '0',
				'toggle_radius_bottom_left'  => '0',
				'drawer_background_from'     => '#ffffff',
				'drawer_background_to'       => '#ffffff',
				'drawer_background'          => '#ffffff',
				'drawer_padding_top'         => '0',
				'drawer_padding_right'       => '0',
				'drawer_padding_bottom'      => '0',
				'drawer_padding_left'        => '0',
				'drawer_padding'             => '0',
				'active_background_from'     => '#f9fff0',
				'active_background_to'       => '#f9fff0',
				'item_color'                 => '#063b31',
				'item_active_color'          => '#063b31',
				'item_size'                  => '1.125rem',
				'item_align'                 => 'center',
				'overlay_content'            => 1,
				'force_full_width'           => 1,
				'offcanvas_width'            => '300px',
				'mega_columns'               => 1,
			),
			'custom_css' => '',
		);
	}

	public static function defaults() {
		return array(
			'locations' => array(),
			'themes'    => array( 'default' => self::theme_defaults() ),
			'general'   => array( 'css_output' => 'inline' ),
		);
	}

	public static function location_defaults() {
		return array(
			'enabled'              => 0,
			'theme'                => 'default',
			'trigger'              => 'click',
			'layout'               => 'horizontal',
			'breakpoint'           => 900,
			'desktop_effect'       => 'fade',
			'desktop_speed'        => 'fast',
			'mobile_type'          => 'show-hide',
			'mobile_speed'         => 'fast',
			'mobile_behavior'      => 'accordion',
			'mobile_default_state' => 'collapsed',
			'sticky'               => 0,
			'overlay_desktop'      => 0,
			'overlay_mobile'       => 0,
			'click_behavior'       => 'toggle-follow',
			'offcanvas'            => 0,
			'search'               => 0,
			'cart'                 => 0,
		);
	}

	public static function all() {
		$settings           = wp_parse_args( get_option( self::OPTION, array() ), self::defaults() );
		$settings['themes'] = is_array( $settings['themes'] ) ? $settings['themes'] : array();
		foreach ( $settings['themes'] as $key => $theme ) {
			$settings['themes'][ $key ] = self::normalize_theme( (array) $theme ); }
		if ( empty( $settings['themes'] ) ) {
			$settings['themes']['default'] = self::theme_defaults(); }
		$settings['general']   = wp_parse_args( (array) $settings['general'], self::defaults()['general'] );
		$settings['locations'] = is_array( $settings['locations'] ) ? $settings['locations'] : array();
		foreach ( $settings['locations'] as $key => $location ) {
			$raw_location = (array) $location;
			$location     = wp_parse_args( $raw_location, self::location_defaults() );
			if ( ! isset( $raw_location['mobile_type'] ) || ! in_array( $location['mobile_type'], array( 'show-hide', 'slide-down', 'offcanvas' ), true ) ) {
				$location['mobile_type'] = ! empty( $location['offcanvas'] ) ? 'offcanvas' : 'show-hide'; }
			$settings['locations'][ $key ] = $location;
		}
		return $settings;
	}

	public static function normalize_theme( $theme ) {
		$defaults = self::theme_defaults();
		foreach ( array( 'general', 'menu_bar', 'mega', 'flyout', 'badges', 'mobile' ) as $group ) {
			$theme[ $group ] = wp_parse_args( (array) ( $theme[ $group ] ?? array() ), $defaults[ $group ] ); }
		return wp_parse_args( $theme, $defaults );
	}

	public static function location( $location ) {
		$settings = self::all();
		return isset( $settings['locations'][ $location ] ) && is_array( $settings['locations'][ $location ] ) ? $settings['locations'][ $location ] : self::location_defaults(); }
	public static function is_enabled( $location ) {
		return ! empty( self::location( $location )['enabled'] ); }

	private static function css_value( $value, $fallback ) {
		$value = sanitize_text_field( (string) $value );
		return preg_match( '/^[a-zA-Z0-9.%(),#\s+\-\/"\']+$/', $value ) ? $value : $fallback;
	}

	private static function color( $value, $fallback ) {
		$value = sanitize_text_field( (string) $value );
		if ( 'transparent' === strtolower( $value ) ) {
			return 'transparent';
		} if ( preg_match( '/^rgba?\\(\\s*(?:[01]?\\d?\\d|2[0-4]\\d|25[0-5])\\s*,\\s*(?:[01]?\\d?\\d|2[0-4]\\d|25[0-5])\\s*,\\s*(?:[01]?\\d?\\d|2[0-4]\\d|25[0-5])(?:\\s*,\\s*(?:0(?:\\.\\d+)?|1(?:\\.0+)?))?\\s*\\)$/i', $value ) ) {
			return $value;
		}
		$color = sanitize_hex_color( $value );
		return $color ? $color : $fallback;
	}

	public static function sanitize_theme( $theme ) {
		$defaults       = self::theme_defaults();
		$theme          = self::normalize_theme( (array) $theme );
		$output         = $defaults;
		$output['name'] = sanitize_text_field( $theme['name'] );
		foreach ( array( 'background', 'text', 'accent' ) as $key ) {
			$output[ $key ] = self::color( $theme[ $key ], $defaults[ $key ] ); }
		$output['spacing'] = min( 48, max( 4, absint( $theme['spacing'] ) ) );
		$output['radius']  = min( 40, max( 0, absint( $theme['radius'] ) ) );
		$output['general'] = array();
		foreach ( $defaults['general'] as $key => $fallback ) {
			if ( in_array( $key, array( 'arrow_rotate', 'shadow_enabled', 'hover_transitions', 'reset_widgets' ), true ) ) {
				$output['general'][ $key ] = empty( $theme['general'][ $key ] ) ? 0 : 1;
			} elseif ( 'transition_ms' === $key ) {
				$output['general'][ $key ] = min( 1000, absint( $theme['general'][ $key ] ) );
			} elseif ( 'z_index' === $key ) {
				$output['general'][ $key ] = min( 99999, absint( $theme['general'][ $key ] ) );
			} elseif ( 'arrow_icon' === $key ) {
				$output['general'][ $key ] = in_array( $theme['general'][ $key ], array( 'disabled', 'chevron', 'caret', 'arrow', 'plus' ), true ) ? $theme['general'][ $key ] : $fallback;
			} elseif ( false !== strpos( $key, 'color' ) ) {
				$output['general'][ $key ] = self::color( $theme['general'][ $key ], $fallback );
			} else {
				$output['general'][ $key ] = self::css_value( $theme['general'][ $key ], $fallback ); }
		}
		foreach ( array( 'menu_bar', 'mega', 'flyout' ) as $group ) {
			$output[ $group ] = array();
			foreach ( $defaults[ $group ] as $key => $fallback ) {
				if ( false !== strpos( $key, 'background' ) || false !== strpos( $key, 'color' ) ) {
					$output[ $group ][ $key ] = self::color( $theme[ $group ][ $key ], $fallback ); } elseif ( in_array( $key, array( 'sticky_transition', 'divider', 'current_item', 'item_divider' ), true ) ) {
					$output[ $group ][ $key ] = empty( $theme[ $group ][ $key ] ) ? 0 : 1; } elseif ( 'divider_glow_opacity' === $key ) {
							$output[ $group ][ $key ] = (string) min( 1, max( 0, (float) $theme[ $group ][ $key ] ) );
					} else {
						$output[ $group ][ $key ] = self::css_value( $theme[ $group ][ $key ], $fallback );
					}
			}
		}
		$output['badges'] = array();
		foreach ( $defaults['badges'] as $key => $fallback ) {
			$output['badges'][ $key ] = false !== strpos( $key, 'color' ) || false !== strpos( $key, 'background' ) ? self::color( $theme['badges'][ $key ], $fallback ) : self::css_value( $theme['badges'][ $key ], $fallback ); }
		$output['mobile'] = array();
		foreach ( $defaults['mobile'] as $key => $fallback ) {
			if ( 'mega_columns' === $key ) {
				$output['mobile'][ $key ] = min( 4, max( 1, absint( $theme['mobile'][ $key ] ) ) );
			} elseif ( 'item_align' === $key ) {
				$output['mobile'][ $key ] = in_array( $theme['mobile'][ $key ], array( 'left', 'center', 'right' ), true ) ? $theme['mobile'][ $key ] : $fallback;
			} elseif ( in_array( $key, array( 'overlay_content', 'force_full_width' ), true ) ) {
				$output['mobile'][ $key ] = empty( $theme['mobile'][ $key ] ) ? 0 : 1;
			} elseif ( false !== strpos( $key, 'background' ) || false !== strpos( $key, 'color' ) || 'toggle_text' === $key ) {
				$output['mobile'][ $key ] = self::color( $theme['mobile'][ $key ], $fallback );
			} else {
				$output['mobile'][ $key ] = self::css_value( $theme['mobile'][ $key ], $fallback ); }
		}
		$output['mobile']['toggle_background'] = $output['mobile']['toggle_background_from'];
		$output['mobile']['drawer_background'] = $output['mobile']['drawer_background_from'];
		$output['mobile']['drawer_padding']    = $output['mobile']['drawer_padding_top'] . ' ' . $output['mobile']['drawer_padding_right'] . ' ' . $output['mobile']['drawer_padding_bottom'] . ' ' . $output['mobile']['drawer_padding_left'];
		$output['custom_css']                  = self::custom_css( $theme['custom_css'] );
		return $output;
	}

	private static function custom_css( $value ) {
		$value = sanitize_textarea_field( (string) $value );
		$value = preg_replace( '#<\s*/?\s*style[^>]*>#i', '', $value );
		$value = preg_replace( '#@import\s+(?:url\()?[^;]+;#i', '', $value );
		$value = str_ireplace( array( 'expression(', 'javascript:' ), '', $value );
		return substr( $value, 0, 30000 );
	}

	public static function sanitize( $input ) {
		$current             = self::all();
		$output              = self::defaults();
		$output['locations'] = $current['locations'];
		$output['themes']    = $current['themes'];
		$output['general']   = $current['general'];
		$input               = is_array( $input ) ? $input : array();
		foreach ( (array) ( $input['locations'] ?? array() ) as $location => $profile ) {
			$key = sanitize_key( $location );
			if ( ! $key || ! is_array( $profile ) ) {
				continue; }
			$profile                     = wp_parse_args( $profile, self::location_defaults() );
			$mobile_type                 = in_array( $profile['mobile_type'], array( 'show-hide', 'slide-down', 'offcanvas' ), true ) ? $profile['mobile_type'] : 'show-hide';
			$output['locations'][ $key ] = array(
				'enabled'              => empty( $profile['enabled'] ) ? 0 : 1,
				'theme'                => sanitize_key( $profile['theme'] ),
				'trigger'              => in_array( $profile['trigger'], array( 'click', 'hover', 'hover-intent' ), true ) ? $profile['trigger'] : 'click',
				'layout'               => in_array( $profile['layout'], array( 'horizontal', 'vertical', 'accordion' ), true ) ? $profile['layout'] : 'horizontal',
				'breakpoint'           => min( 1600, max( 480, absint( $profile['breakpoint'] ) ) ),
				'desktop_effect'       => in_array( $profile['desktop_effect'], array( 'none', 'fade', 'slide' ), true ) ? $profile['desktop_effect'] : 'fade',
				'desktop_speed'        => in_array( $profile['desktop_speed'], array( 'fast', 'medium', 'slow' ), true ) ? $profile['desktop_speed'] : 'fast',
				'mobile_type'          => $mobile_type,
				'mobile_speed'         => in_array( $profile['mobile_speed'], array( 'fast', 'medium', 'slow' ), true ) ? $profile['mobile_speed'] : 'fast',
				'mobile_behavior'      => in_array( $profile['mobile_behavior'], array( 'accordion', 'multiple' ), true ) ? $profile['mobile_behavior'] : 'accordion',
				'mobile_default_state' => in_array( $profile['mobile_default_state'], array( 'collapsed', 'expanded' ), true ) ? $profile['mobile_default_state'] : 'collapsed',
				'click_behavior'       => in_array( $profile['click_behavior'], array( 'toggle-close', 'toggle-follow', 'follow' ), true ) ? $profile['click_behavior'] : 'toggle-follow',
				'sticky'               => empty( $profile['sticky'] ) ? 0 : 1,
				'overlay_desktop'      => empty( $profile['overlay_desktop'] ) ? 0 : 1,
				'overlay_mobile'       => empty( $profile['overlay_mobile'] ) ? 0 : 1,
				'offcanvas'            => 'offcanvas' === $mobile_type ? 1 : 0,
				'search'               => empty( $profile['search'] ) ? 0 : 1,
				'cart'                 => empty( $profile['cart'] ) ? 0 : 1,
			);
		}
		foreach ( (array) ( $input['themes'] ?? array() ) as $slug => $theme ) {
			$key = sanitize_key( $slug );
			if ( $key && is_array( $theme ) ) {
				$output['themes'][ $key ] = self::sanitize_theme( $theme ); }
		}
		if ( isset( $input['general'] ) ) {
			$general           = (array) $input['general'];
			$output['general'] = array( 'css_output' => in_array( $general['css_output'] ?? '', array( 'inline', 'none' ), true ) ? $general['css_output'] : 'inline' ); }
		return $output;
	}
}
