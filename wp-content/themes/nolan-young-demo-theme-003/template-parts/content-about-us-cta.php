<?php
/**
 * About partnership CTA.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--cream">
	<div class="content-wrap">
		<div class="about-conversion" data-reveal>
			<div class="about-conversion__index">A / 01</div>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Work with the team', 'nolan-young-demo-theme-003' ); ?></p>
				<h2><?php esc_html_e( 'Good work starts with a precise question.', 'nolan-young-demo-theme-003' ); ?></h2>
				<p><?php esc_html_e( 'Share the change your organization is navigating and where better momentum would matter most.', 'nolan-young-demo-theme-003' ); ?></p>
			</div>
			<div class="about-conversion__fit">
				<span><?php esc_html_e( 'Strongest fit', 'nolan-young-demo-theme-003' ); ?></span>
				<ul>
					<li><?php esc_html_e( 'Complex decision', 'nolan-young-demo-theme-003' ); ?></li>
					<li><?php esc_html_e( 'Cross-functional delivery', 'nolan-young-demo-theme-003' ); ?></li>
					<li><?php esc_html_e( 'Long-term ownership', 'nolan-young-demo-theme-003' ); ?></li>
				</ul>
			</div>
			<div class="about-conversion__action">
				<?php nydemo003_button( __( 'Start the conversation', 'nolan-young-demo-theme-003' ) ); ?>
				<a class="text-link" href="<?php echo esc_url( nydemo003_page_url( 'work' ) ); ?>">
					<?php esc_html_e( 'Review the evidence', 'nolan-young-demo-theme-003' ); ?>
					<span aria-hidden="true">↗</span>
				</a>
			</div>
		</div>
	</div>
</section>
