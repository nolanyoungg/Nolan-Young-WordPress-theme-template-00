<?php
/**
 * Journal index WordPress loop.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="section journal-index" id="latest">
	<div class="content-wrap">
		<header class="section-heading journal-index__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Latest thinking', 'nolan-young-demo-theme-003' ); ?></p>
				<h2><?php esc_html_e( 'Ideas designed to survive contact with the work.', 'nolan-young-demo-theme-003' ); ?></h2>
			</div>
			<p><?php esc_html_e( 'Every article is pulled from the live WordPress journal and organized to make the next useful perspective easy to find.', 'nolan-young-demo-theme-003' ); ?></p>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>
					<article <?php post_class( 'post-card' ); ?> data-reveal>
						<a class="post-card__link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read %s', 'nolan-young-demo-theme-003' ), get_the_title() ) ); ?>">
							<span class="post-card__visual">
								<?php nydemo003_editorial_visual( get_the_ID(), 'medium_large' ); ?>
							</span>
							<span class="post-card__body">
								<span class="post-card__meta"><?php echo esc_html( get_the_date() ); ?></span>
								<span class="post-card__title"><?php the_title(); ?></span>
							</span>
						</a>
					</article>
				<?php endwhile; ?>
			</div>
			<div class="pagination-wrap"><?php nydemo003_pagination(); ?></div>
		<?php else : ?>
			<div class="empty-state" data-reveal>
				<h3><?php esc_html_e( 'The editorial system is ready for its first article.', 'nolan-young-demo-theme-003' ); ?></h3>
				<p><?php esc_html_e( 'Publish a WordPress post and it will appear here automatically.', 'nolan-young-demo-theme-003' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>
