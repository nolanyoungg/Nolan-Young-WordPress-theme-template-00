<?php
/**
 * Blog-preview section.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_posts_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	)
);
?>
<section class="nytt01-section">
	<div class="nytt01-container">
		<header class="nytt01-section-header">
			<div>
				<p class="nytt01-eyebrow"><?php esc_html_e( 'Insights', 'nolan-young-theme-template-01' ); ?></p>
				<h2><?php esc_html_e( 'From the blog', 'nolan-young-theme-template-01' ); ?></h2>
			</div>
		</header>
		<div class="nytt01-card-grid">
			<?php while ( $nytt01_posts_query->have_posts() ) : ?>
				<?php $nytt01_posts_query->the_post(); ?>
				<?php get_template_part( 'template-parts/content/content', 'search' ); ?>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</section>
