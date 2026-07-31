<?php
defined( 'ABSPATH' ) || exit;
function nytt99_post_meta() { printf( '<p class="post-meta">%s · %s</p>', esc_html( get_the_date() ), esc_html( get_the_author() ) ); }
function nytt99_pagination() { the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => __( 'Previous', 'nolan-young-theme-template-99-master' ), 'next_text' => __( 'Next', 'nolan-young-theme-template-99-master' ) ) ); }
