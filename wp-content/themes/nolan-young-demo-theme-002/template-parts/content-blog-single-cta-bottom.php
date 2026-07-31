<?php
/**
 * Single article contextual call to action.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

$category = nydemo002_primary_category();
?>
<section class="section article-conversion">
	<div class="content-wrap">
		<div class="article-conversion__panel" data-reveal>
			<div class="article-conversion__context">
				<span><?php esc_html_e( 'Apply the perspective', 'nolan-young-demo-theme-002' ); ?></span>
				<strong><?php echo esc_html( $category ? $category->name : __( 'Focused working session', 'nolan-young-demo-theme-002' ) ); ?></strong>
			</div>
			<div class="article-conversion__content">
				<h2><?php esc_html_e( 'Turn the useful idea into a responsible first move.', 'nolan-young-demo-theme-002' ); ?></h2>
				<p><?php esc_html_e( 'Bring the context, the constraint, and the decision your team needs to make. We will help structure what should happen next.', 'nolan-young-demo-theme-002' ); ?></p>
			</div>
			<div class="article-conversion__actions">
				<a class="button" href="<?php echo esc_url( nydemo002_page_url( 'contact-us' ) ); ?>">
					<span><?php esc_html_e( 'Book a working session', 'nolan-young-demo-theme-002' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a class="text-link" href="<?php echo esc_url( nydemo002_page_url( 'services' ) ); ?>">
					<?php esc_html_e( 'See how we can help', 'nolan-young-demo-theme-002' ); ?>
					<span aria-hidden="true">↗</span>
				</a>
			</div>
		</div>
	</div>
</section>
