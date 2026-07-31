<?php
/**
 * Front-page proof ledger.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="proof-ledger section">
	<div class="content-wrap proof-ledger__grid">
		<header data-reveal><span>03 / 05</span><p class="eyebrow"><?php esc_html_e( 'Selected evidence', 'nolan-young-demo-theme-003' ); ?></p><h2><?php esc_html_e( 'Measure the change, not the theatre.', 'nolan-young-demo-theme-003' ); ?></h2></header>
		<figure data-reveal><img src="<?php echo esc_url( nydemo003_asset_url( 'images/generated/capability-analytics.jpg' ) ); ?>" alt="" width="900" height="900" loading="lazy"><figcaption><?php esc_html_e( 'A physical model for one shared measurement practice.', 'nolan-young-demo-theme-003' ); ?></figcaption></figure>
		<div class="proof-ledger__results" data-reveal><article><strong>−64%</strong><span><?php esc_html_e( 'reporting effort', 'nolan-young-demo-theme-003' ); ?></span></article><article><strong>+31%</strong><span><?php esc_html_e( 'decision confidence', 'nolan-young-demo-theme-003' ); ?></span></article><article><strong>08</strong><span><?php esc_html_e( 'shared measures', 'nolan-young-demo-theme-003' ); ?></span></article><a class="text-link" href="<?php echo esc_url( nydemo003_page_url( 'work' ) ); ?>"><?php esc_html_e( 'Open the project ledger', 'nolan-young-demo-theme-003' ); ?> ↗</a></div>
	</div>
</section>
