<?php
/**
 * Template Name: Privacy Policy
 * @package NYTT99
 */
get_header(); ?><main id="content" class="page-content">while ( have_posts() ) : the_post(); the_content(); endwhile;</main><?php get_footer();
