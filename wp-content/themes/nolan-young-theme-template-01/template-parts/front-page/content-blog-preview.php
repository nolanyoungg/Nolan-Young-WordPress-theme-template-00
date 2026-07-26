<?php
/**
 * Blog-preview section.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_blog_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
		'post__not_in'        => nytt01_get_featured_work_ids(),
	)
);
$nytt01_blog_url   = nytt01_get_destination_url( 'blog' );
?>
<section class="nytt01-section">
	<div class="nytt01-container">
		<header class="nytt01-section-header">
			<div>
				<p class="nytt01-eyebrow"><?php esc_html_e( 'Insights', 'nolan-young-theme-template-01' ); ?></p>
				<h2><?php esc_html_e( 'From the blog', 'nolan-young-theme-template-01' ); ?></h2>
			</div>
			<?php if ( $nytt01_blog_url ) : ?>
				<a class="nytt01-text-link" href="<?php echo esc_url( $nytt01_blog_url ); ?>"><?php esc_html_e( 'View all', 'nolan-young-theme-template-01' ); ?><span aria-hidden="true"> →</span></a>
			<?php endif; ?>
		</header>
		<?php if ( $nytt01_blog_query->have_posts() ) : ?>
			<div class="nytt01-card-grid">
				<?php
				while ( $nytt01_blog_query->have_posts() ) :
					$nytt01_blog_query->the_post();
					get_template_part( 'template-parts/content/content', 'search', array( 'heading_level' => 3 ) );
				endwhile;
				?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'There are no recent posts to display yet.', 'nolan-young-theme-template-01' ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
