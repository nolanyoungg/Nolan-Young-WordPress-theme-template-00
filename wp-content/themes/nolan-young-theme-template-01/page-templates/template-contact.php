<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="primary" class="nytt01-site-main nytt01-page-contact">
	<div class="nytt01-container nytt01-content-area nytt01-page-intro">
		<?php
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content/content', 'page' );
		}
		nytt01_render_form_shortcode_slot( 'contact' );
		?>
	</div>
</main>
<?php
get_footer();
