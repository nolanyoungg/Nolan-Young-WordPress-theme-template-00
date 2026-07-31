<?php
/**
 * Template Name: Services
 *
 * @package NolanYoungThemeTemplate99Master
 */

get_header();
?>
<main id="content">
	<?php get_template_part( 'template-parts/content', 'services-hero' ); ?>
	<?php get_template_part( 'template-parts/content', 'services-sect01' ); ?>
	<?php get_template_part( 'template-parts/content', 'services-sect02' ); ?>
	<?php get_template_part( 'template-parts/content', 'services-sect03' ); ?>
	<?php get_template_part( 'template-parts/content', 'services-sect04' ); ?>
	<?php get_template_part( 'template-parts/content', 'services-sect05' ); ?>
	<?php get_template_part( 'template-parts/content', 'services-cta' ); ?>
</main>
<?php get_footer();
