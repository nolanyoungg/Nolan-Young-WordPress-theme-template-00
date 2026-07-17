<?php
namespace NYMegaMenu;

defined( 'ABSPATH' ) || exit;

class Settings {
	const OPTION = 'nymegamenu_settings';

	public static function defaults() {
		return array(
			'locations' => array(),
			'themes'    => array(
				'default' => array(
					'name' => __( 'NY Classic', 'nymegamenu' ), 'background' => '#ffffff', 'text' => '#172033', 'accent' => '#1769e0', 'spacing' => '18', 'radius' => '12',
				),
			),
		);
	}

	public static function all() {
		return wp_parse_args( get_option( self::OPTION, array() ), self::defaults() );
	}

	public static function location( $location ) {
		$settings = self::all();
		return isset( $settings['locations'][ $location ] ) && is_array( $settings['locations'][ $location ] ) ? $settings['locations'][ $location ] : array();
	}

	public static function is_enabled( $location ) {
		$profile = self::location( $location );
		return ! empty( $profile['enabled'] );
	}

	public static function sanitize( $input ) {
		$output = self::defaults();
		$input  = is_array( $input ) ? $input : array();
		foreach ( (array) ( $input['locations'] ?? array() ) as $location => $profile ) {
			$key = sanitize_key( $location );
			if ( ! $key || ! is_array( $profile ) ) { continue; }
			$output['locations'][ $key ] = array(
				'enabled' => empty( $profile['enabled'] ) ? 0 : 1,
				'theme' => sanitize_key( $profile['theme'] ?? 'default' ),
				'trigger' => in_array( $profile['trigger'] ?? '', array( 'click', 'hover', 'hover-intent' ), true ) ? $profile['trigger'] : 'click',
				'layout' => in_array( $profile['layout'] ?? '', array( 'horizontal', 'vertical', 'accordion' ), true ) ? $profile['layout'] : 'horizontal',
				'breakpoint' => min( 1600, max( 480, absint( $profile['breakpoint'] ?? 900 ) ) ),
				'sticky' => empty( $profile['sticky'] ) ? 0 : 1,
				'offcanvas' => empty( $profile['offcanvas'] ) ? 0 : 1,
				'search' => empty( $profile['search'] ) ? 0 : 1,
				'cart' => empty( $profile['cart'] ) ? 0 : 1,
			);
		}
		foreach ( (array) ( $input['themes'] ?? array() ) as $slug => $theme ) {
			$key = sanitize_key( $slug );
			if ( ! $key || ! is_array( $theme ) ) { continue; }
			$output['themes'][ $key ] = array(
				'name' => sanitize_text_field( $theme['name'] ?? $key ), 'background' => sanitize_hex_color( $theme['background'] ?? '' ) ?: '#ffffff', 'text' => sanitize_hex_color( $theme['text'] ?? '' ) ?: '#172033', 'accent' => sanitize_hex_color( $theme['accent'] ?? '' ) ?: '#1769e0', 'spacing' => min( 48, max( 4, absint( $theme['spacing'] ?? 18 ) ) ), 'radius' => min( 40, max( 0, absint( $theme['radius'] ?? 12 ) ) ),
			);
		}
		return $output;
	}
}
