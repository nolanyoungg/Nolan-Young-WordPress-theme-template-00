<?php
/**
 * Front-page project-fit conversion panel.
 *
 * @package NolanYoungThemeTemplate99Master
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--cool">
	<div class="content-wrap">
		<div class="project-fit" data-reveal>
			<div class="project-fit__status">
				<span><i aria-hidden="true"></i><?php esc_html_e( 'Now scheduling select engagements', 'nolan-young-theme-template-99-master' ); ?></span>
				<strong>Q4 / 2026</strong>
			</div>
			<div class="project-fit__content">
				<p class="eyebrow"><?php esc_html_e( 'The right starting point', 'nolan-young-theme-template-99-master' ); ?></p>
				<h2><?php esc_html_e( 'Bring the challenge that matters next.', 'nolan-young-theme-template-99-master' ); ?></h2>
				<p><?php esc_html_e( 'A focused first conversation is enough to identify the pressure point, test the fit, and define a useful next step.', 'nolan-young-theme-template-99-master' ); ?></p>
			</div>
			<ul class="project-fit__criteria">
				<li><span>01</span><?php esc_html_e( 'A consequential decision or delivery problem', 'nolan-young-theme-template-99-master' ); ?></li>
				<li><span>02</span><?php esc_html_e( 'Access to the people and evidence that matter', 'nolan-young-theme-template-99-master' ); ?></li>
				<li><span>03</span><?php esc_html_e( 'A willingness to make the work visible', 'nolan-young-theme-template-99-master' ); ?></li>
			</ul>
			<div class="project-fit__action">
				<?php nytt99_button( __( 'Start the conversation', 'nolan-young-theme-template-99-master' ) ); ?>
				<a class="text-link" href="<?php echo esc_url( nytt99_page_url( 'services' ) ); ?>">
					<?php esc_html_e( 'Check project fit', 'nolan-young-theme-template-99-master' ); ?>
					<span aria-hidden="true">↗</span>
				</a>
			</div>
		</div>
	</div>
</section>
