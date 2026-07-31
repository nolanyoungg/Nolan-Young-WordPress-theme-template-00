<?php
/**
 * Journal index call to action.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--cream journal-bridge">
	<div class="content-wrap">
		<div class="journal-bridge__panel" data-reveal>
			<div class="journal-bridge__index" aria-hidden="true">J / 01</div>
			<div class="journal-bridge__content">
				<p class="eyebrow"><?php esc_html_e( 'From perspective to plan', 'nolan-young-demo-theme-003' ); ?></p>
				<h2><?php esc_html_e( 'Bring the decision that still feels unresolved.', 'nolan-young-demo-theme-003' ); ?></h2>
				<p><?php esc_html_e( 'A focused working session can expose the real constraint, align the team, and define the smallest responsible first move.', 'nolan-young-demo-theme-003' ); ?></p>
			</div>
			<div class="journal-bridge__action">
				<span><i aria-hidden="true"></i><?php esc_html_e( 'New project conversations are open', 'nolan-young-demo-theme-003' ); ?></span>
				<a class="button" href="<?php echo esc_url( nydemo003_page_url( 'contact-us' ) ); ?>">
					<span><?php esc_html_e( 'Start the conversation', 'nolan-young-demo-theme-003' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a class="text-link" href="<?php echo esc_url( nydemo003_page_url( 'services' ) ); ?>">
					<?php esc_html_e( 'Review the service system', 'nolan-young-demo-theme-003' ); ?>
					<span aria-hidden="true">↗</span>
				</a>
			</div>
		</div>
	</div>
</section>
