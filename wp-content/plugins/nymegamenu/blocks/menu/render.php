<?php
defined( 'ABSPATH' ) || exit;
echo do_shortcode( '[nymegamenu location="' . esc_attr( $attributes['location'] ?? '' ) . '"]' );
