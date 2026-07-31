<?php
defined( 'ABSPATH' ) || exit;
function nytt99_asset( $path ) { return esc_url( get_theme_file_uri( '/dist/' . ltrim( $path, '/' ) ) ); }
function nytt99_part( $slug ) { get_template_part( 'template-parts/content', $slug ); }
function nytt99_cta( $label = 'Start a project' ) { printf( '<a class="button" href="%s">%s <span aria-hidden="true">↗</span></a>', esc_url( home_url( '/contact-us/' ) ), esc_html( $label ) ); }
