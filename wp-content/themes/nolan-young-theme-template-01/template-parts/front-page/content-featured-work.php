<?php
/**
 * Featured work section.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_featured_ids = nytt01_get_featured_work_ids();
$nytt01_work_url     = nytt01_get_destination_url( 'work' );
$nytt01_work_query   = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'post__in'       => $nytt01_featured_ids ? $nytt01_featured_ids : array( 0 ),
		'posts_per_page' => 3,
		'orderby'        => 'post__in',
	)
);
?>
<section class="nytt01-section">
	<div class="nytt01-container">
		<header class="nytt01-section-header">
			<div>
				<p class="nytt01-eyebrow"><?php esc_html_e( 'Selected work', 'nolan-young-theme-template-01' ); ?></p>
				<h2><?php esc_html_e( 'Recent ideas and outcomes', 'nolan-young-theme-template-01' ); ?></h2>
			</div>
			<?php if ( $nytt01_work_url && ! is_page_template( 'page-templates/template-work.php' ) ) : ?>
				<a class="nytt01-text-link" href="<?php echo esc_url( $nytt01_work_url ); ?>"><?php esc_html_e( 'View all', 'nolan-young-theme-template-01' ); ?><span aria-hidden="true"> →</span></a>
			<?php endif; ?>
		</header>
		<?php if ( $nytt01_work_query->have_posts() ) : ?>
			<div class="nytt01-card-grid">
				<?php
				while ( $nytt01_work_query->have_posts() ) :
					$nytt01_work_query->the_post();
					get_template_part( 'template-parts/content/content', 'search', array( 'heading_level' => 3 ) );
				endwhile;
				?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Mark up to three posts as sticky to feature them here.', 'nolan-young-theme-template-01' ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
