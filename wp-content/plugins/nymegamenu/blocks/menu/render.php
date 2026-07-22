<?php
/**
 * Server-side render callback for the NY Mega Menu block.
 *
 * @package NYMegaMenu
 */

defined( 'ABSPATH' ) || exit;
echo do_shortcode( '[nymegamenu location="' . esc_attr( $attributes['location'] ?? '' ) . '"]' );
