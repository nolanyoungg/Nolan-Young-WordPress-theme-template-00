<?php
/**
 * Template Name: Work
 * Template Post Type: page
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="nytt01-site-main nytt01-page-work">
	<div class="nytt01-container nytt01-content-area nytt01-page-intro">
		<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content/content', 'page' );
		}
		?>
	</div>
	<?php
	get_template_part( 'template-parts/front-page/content', 'featured-work' );
	get_template_part( 'template-parts/global/content', 'cta-banner' );
	?>
</main>
<?php
get_footer();
