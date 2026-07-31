<?php
/**
 * Front-page modernist index.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="index-hero">
	<div class="index-hero__copy">
		<div class="index-hero__meta"><span>NY–003</span><span><?php esc_html_e( 'Independent digital practice', 'nolan-young-demo-theme-003' ); ?></span></div>
		<div class="index-hero__statement" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Strategy · Design · Technology', 'nolan-young-demo-theme-003' ); ?></p>
			<h1><?php esc_html_e( 'Make digital work feel inevitable.', 'nolan-young-demo-theme-003' ); ?></h1>
			<p><?php esc_html_e( 'We turn complicated ambitions into clear systems people can understand, use, and grow.', 'nolan-young-demo-theme-003' ); ?></p>
			<div class="button-row"><?php nydemo003_button( __( 'Bring us a challenge', 'nolan-young-demo-theme-003' ) ); ?><a class="text-link" href="<?php echo esc_url( nydemo003_page_url( 'work' ) ); ?>"><?php esc_html_e( 'See the evidence', 'nolan-young-demo-theme-003' ); ?> ↗</a></div>
		</div>
		<div class="index-hero__foot"><span><?php esc_html_e( 'New York / Everywhere', 'nolan-young-demo-theme-003' ); ?></span><span><?php esc_html_e( 'Scroll to explore', 'nolan-young-demo-theme-003' ); ?> ↓</span></div>
	</div>
	<figure class="index-hero__media">
		<img src="<?php echo esc_url( nydemo003_asset_url( 'images/generated/modernist-studio.jpg' ) ); ?>" alt="<?php esc_attr_e( 'A creative team arranging interface studies in a sunlit modernist studio.', 'nolan-young-demo-theme-003' ); ?>" width="1920" height="1080" fetchpriority="high">
		<figcaption><span>01</span><?php esc_html_e( 'The work stays visible.', 'nolan-young-demo-theme-003' ); ?></figcaption>
	</figure>
</section>
