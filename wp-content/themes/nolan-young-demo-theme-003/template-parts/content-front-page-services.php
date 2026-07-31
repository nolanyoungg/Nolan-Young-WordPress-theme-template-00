<?php
/**
 * Front-page capability index.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

$nydemo003_capabilities = array(
	array( '01', __( 'Website Development', 'nolan-young-demo-theme-003' ), __( 'Useful digital places, designed for people and built for change.', 'nolan-young-demo-theme-003' ), 'capability-web.jpg', 'website-development' ),
	array( '02', __( 'Plugin Development', 'nolan-young-demo-theme-003' ), __( 'Focused WordPress systems that fit the work instead of adding friction.', 'nolan-young-demo-theme-003' ), 'capability-plugin.jpg', 'plugin-development' ),
	array( '03', __( 'SEO', 'nolan-young-demo-theme-003' ), __( 'Technical and editorial foundations that make expertise findable.', 'nolan-young-demo-theme-003' ), 'capability-seo.jpg', 'seo' ),
	array( '04', __( 'Analytics', 'nolan-young-demo-theme-003' ), __( 'Clear measures that help teams choose what deserves attention next.', 'nolan-young-demo-theme-003' ), 'capability-analytics.jpg', 'analytics' ),
	array( '05', __( 'AI Development', 'nolan-young-demo-theme-003' ), __( 'Human-centered tools that automate carefully and keep judgment visible.', 'nolan-young-demo-theme-003' ), 'capability-ai.jpg', 'ai-development' ),
);
?>
<section class="capability-index section">
	<div class="content-wrap">
		<header class="capability-index__header" data-reveal><span>02 / 05</span><div><p class="eyebrow"><?php esc_html_e( 'Capability index', 'nolan-young-demo-theme-003' ); ?></p><h2><?php esc_html_e( 'Five ways to move the work.', 'nolan-young-demo-theme-003' ); ?></h2></div></header>
		<ol>
			<?php foreach ( $nydemo003_capabilities as $nydemo003_capability ) : ?>
				<li data-reveal><a href="<?php echo esc_url( nydemo003_page_url( 'services' ) . '#' . $nydemo003_capability[4] ); ?>"><span><?php echo esc_html( $nydemo003_capability[0] ); ?></span><h3><?php echo esc_html( $nydemo003_capability[1] ); ?></h3><p><?php echo esc_html( $nydemo003_capability[2] ); ?></p><img src="<?php echo esc_url( nydemo003_asset_url( 'images/generated/' . $nydemo003_capability[3] ) ); ?>" alt="" width="900" height="900" loading="lazy"><i aria-hidden="true">↗</i></a></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
