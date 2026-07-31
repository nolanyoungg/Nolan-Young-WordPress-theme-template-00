<?php
/**
 * Template Name: About Us
 *
 * @package NolanYoungDemoTheme001
 */

get_header();
?>
<main id="content">
	<?php get_template_part( 'template-parts/content', 'about-us-hero' ); ?>
	<?php get_template_part( 'template-parts/content', 'about-us-sect01' ); ?>
	<?php get_template_part( 'template-parts/content', 'about-us-sect02' ); ?>
	<?php get_template_part( 'template-parts/content', 'about-us-sect03' ); ?>
	<?php get_template_part( 'template-parts/content', 'about-us-sect04' ); ?>
	<?php get_template_part( 'template-parts/content', 'about-us-sect05' ); ?>
	<?php get_template_part( 'template-parts/content', 'about-us-cta' ); ?>
</main>
<?php get_footer();
