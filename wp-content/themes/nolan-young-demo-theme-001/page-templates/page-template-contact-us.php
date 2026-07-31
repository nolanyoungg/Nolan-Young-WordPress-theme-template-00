<?php
/**
 * Template Name: Contact Us
 *
 * @package NolanYoungDemoTheme001
 */

get_header();
?>
<main id="content">
	<?php get_template_part( 'template-parts/content', 'contact-us-hero' ); ?>
	<?php get_template_part( 'template-parts/content', 'contact-us-sect01' ); ?>
	<?php get_template_part( 'template-parts/content', 'contact-us-sect02' ); ?>
	<?php get_template_part( 'template-parts/content', 'contact-us-sect03' ); ?>
	<?php get_template_part( 'template-parts/content', 'contact-us-sect04' ); ?>
	<?php get_template_part( 'template-parts/content', 'contact-us-sect05' ); ?>
	<?php get_template_part( 'template-parts/content', 'contact-us-cta' ); ?>
</main>
<?php get_footer();
