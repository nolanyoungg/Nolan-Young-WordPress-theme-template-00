<?php
/**
 * Front-page project-fit conversion panel.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--cool">
	<div class="content-wrap">
		<div class="project-fit" data-reveal>
			<div class="project-fit__status">
				<span><i aria-hidden="true"></i><?php esc_html_e( 'Now scheduling select engagements', 'nolan-young-demo-theme-001' ); ?></span>
				<strong>Q4 / 2026</strong>
			</div>
			<div class="project-fit__content">
				<p class="eyebrow"><?php esc_html_e( 'The right starting point', 'nolan-young-demo-theme-001' ); ?></p>
				<h2><?php esc_html_e( 'Bring the challenge that matters next.', 'nolan-young-demo-theme-001' ); ?></h2>
				<p><?php esc_html_e( 'A focused first conversation is enough to identify the pressure point, test the fit, and define a useful next step.', 'nolan-young-demo-theme-001' ); ?></p>
			</div>
			<ul class="project-fit__criteria">
				<li><span>01</span><?php esc_html_e( 'A consequential decision or delivery problem', 'nolan-young-demo-theme-001' ); ?></li>
				<li><span>02</span><?php esc_html_e( 'Access to the people and evidence that matter', 'nolan-young-demo-theme-001' ); ?></li>
				<li><span>03</span><?php esc_html_e( 'A willingness to make the work visible', 'nolan-young-demo-theme-001' ); ?></li>
			</ul>
			<div class="project-fit__action">
				<?php nydemo001_button( __( 'Start the conversation', 'nolan-young-demo-theme-001' ) ); ?>
				<a class="text-link" href="<?php echo esc_url( nydemo001_page_url( 'services' ) ); ?>">
					<?php esc_html_e( 'Check project fit', 'nolan-young-demo-theme-001' ); ?>
					<span aria-hidden="true">↗</span>
				</a>
			</div>
		</div>
	</div>
</section>
