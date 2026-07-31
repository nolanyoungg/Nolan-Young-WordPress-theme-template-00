<?php
/**
 * Template Name: Work
 *
 * @package NolanYoungDemoTheme001
 */

get_header();
?>
<main id="content">
	<?php get_template_part( 'template-parts/content', 'work-hero' ); ?>
	<?php get_template_part( 'template-parts/content', 'work-sect01' ); ?>
	<?php get_template_part( 'template-parts/content', 'work-sect02' ); ?>
	<?php get_template_part( 'template-parts/content', 'work-sect03' ); ?>
	<?php get_template_part( 'template-parts/content', 'work-sect04' ); ?>
	<?php get_template_part( 'template-parts/content', 'work-sect05' ); ?>
	<?php get_template_part( 'template-parts/content', 'work-cta' ); ?>
</main>
<?php get_footer();
