<?php
/**
 * Services consultation and project-fit CTA.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--cool">
	<div class="content-wrap">
		<div class="services-conversion" data-reveal>
			<div class="services-conversion__signal">
				<span>
					<i aria-hidden="true"></i>
					<?php esc_html_e( 'Consultation availability', 'nolan-young-demo-theme-002' ); ?>
				</span>
				<strong><?php esc_html_e( 'Select Q4 starts', 'nolan-young-demo-theme-002' ); ?></strong>
			</div>
			<div class="services-conversion__content">
				<p class="eyebrow"><?php esc_html_e( 'A useful first step', 'nolan-young-demo-theme-002' ); ?></p>
				<h2><?php esc_html_e( 'Bring the brief behind the brief.', 'nolan-young-demo-theme-002' ); ?></h2>
				<p><?php esc_html_e( 'Share what is changing, where momentum is blocked, and what a better outcome needs to make possible.', 'nolan-young-demo-theme-002' ); ?></p>
			</div>
			<div class="services-conversion__action">
				<?php nydemo002_button( __( 'Discuss the challenge', 'nolan-young-demo-theme-002' ) ); ?>
				<a class="text-link" href="<?php echo esc_url( nydemo002_page_url( 'work' ) ); ?>">
					<?php esc_html_e( 'See related outcomes', 'nolan-young-demo-theme-002' ); ?>
					<span aria-hidden="true">↗</span>
				</a>
			</div>
		</div>
	</div>
</section>
