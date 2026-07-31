<?php
/**
 * 404 help call to action.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--cream recovery-help">
	<div class="content-wrap">
		<div class="recovery-help__panel" data-reveal>
			<div class="recovery-help__status" aria-hidden="true">
				<span>HELP</span>
				<strong>?</strong>
			</div>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Still looking?', 'nolan-young-demo-theme-001' ); ?></p>
				<h2><?php esc_html_e( 'Tell us what you expected to find.', 'nolan-young-demo-theme-001' ); ?></h2>
				<p><?php esc_html_e( 'A person can point you toward the right service, resource, or next conversation.', 'nolan-young-demo-theme-001' ); ?></p>
			</div>
			<div class="recovery-help__action">
				<span><i class="availability-dot" aria-hidden="true"></i><?php esc_html_e( 'Human response', 'nolan-young-demo-theme-001' ); ?></span>
				<a class="button button--primary" href="<?php echo esc_url( nydemo001_page_url( 'contact-us' ) ); ?>">
					<?php esc_html_e( 'Ask for help', 'nolan-young-demo-theme-001' ); ?>
					<span aria-hidden="true">→</span>
				</a>
			</div>
		</div>
	</div>
</section>
