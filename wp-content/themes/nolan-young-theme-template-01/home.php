<?php
/**
 * Posts index template.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="primary" class="nytt01-site-main nytt01-container nytt01-content-area">
	<header class="nytt01-page-header">
		<h1>
			<?php
			$nytt01_posts_page_title = single_post_title( '', false );
			echo esc_html( $nytt01_posts_page_title ? $nytt01_posts_page_title : __( 'Blog', 'nolan-young-theme-template-01' ) );
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="nytt01-post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/content', 'search', array( 'heading_level' => 2 ) );
			endwhile;
			?>
		</div>
		<?php nytt01_posts_pagination(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content/content', 'none', array( 'heading_level' => 2 ) ); ?>
	<?php endif; ?>
</main>
<?php
get_footer();
