<?php
/**
 * Services diagnostic and outcome system.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;

$diagnostics = array(
	array( '01', __( 'Too many competing priorities', 'nolan-young-demo-theme-001' ), __( 'No shared decision model', 'nolan-young-demo-theme-001' ), __( 'A prioritized, measurable roadmap', 'nolan-young-demo-theme-001' ) ),
	array( '02', __( 'Customers cannot complete key journeys', 'nolan-young-demo-theme-001' ), __( 'Experience friction is spread across teams', 'nolan-young-demo-theme-001' ), __( 'A validated experience system', 'nolan-young-demo-theme-001' ) ),
	array( '03', __( 'Delivery slows as the platform grows', 'nolan-young-demo-theme-001' ), __( 'Architecture and ownership are unclear', 'nolan-young-demo-theme-001' ), __( 'A maintainable production platform', 'nolan-young-demo-theme-001' ) ),
	array( '04', __( 'Launches do not create lasting change', 'nolan-young-demo-theme-001' ), __( 'Measurement and stewardship begin too late', 'nolan-young-demo-theme-001' ), __( 'An operating rhythm for improvement', 'nolan-young-demo-theme-001' ) ),
);
?>
<section class="section section--cool">
	<div class="content-wrap service-diagnostic">
		<header class="service-diagnostic__heading" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Start at the pressure point', 'nolan-young-demo-theme-001' ); ?></p>
			<h2><?php esc_html_e( 'Complexity is manageable when the decision is clear.', 'nolan-young-demo-theme-001' ); ?></h2>
			<p><?php esc_html_e( 'The diagnostic connects visible symptoms to the operating constraint beneath them, then defines the smallest responsible intervention.', 'nolan-young-demo-theme-001' ); ?></p>
			<dl>
				<div><dt><?php esc_html_e( 'Typical diagnostic', 'nolan-young-demo-theme-001' ); ?></dt><dd><?php esc_html_e( '10 working days', 'nolan-young-demo-theme-001' ); ?></dd></div>
				<div><dt><?php esc_html_e( 'Primary output', 'nolan-young-demo-theme-001' ); ?></dt><dd><?php esc_html_e( 'Decision brief', 'nolan-young-demo-theme-001' ); ?></dd></div>
			</dl>
		</header>
		<div class="service-diagnostic__matrix" data-reveal>
			<div class="service-diagnostic__labels">
				<span><?php esc_html_e( 'Visible pressure', 'nolan-young-demo-theme-001' ); ?></span>
				<span><?php esc_html_e( 'Likely constraint', 'nolan-young-demo-theme-001' ); ?></span>
				<span><?php esc_html_e( 'Useful outcome', 'nolan-young-demo-theme-001' ); ?></span>
			</div>
			<?php foreach ( $diagnostics as $diagnostic ) : ?>
				<article>
					<span><?php echo esc_html( $diagnostic[0] ); ?></span>
					<strong><?php echo esc_html( $diagnostic[1] ); ?></strong>
					<p><?php echo esc_html( $diagnostic[2] ); ?></p>
					<p><?php echo esc_html( $diagnostic[3] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
		<div class="service-diagnostic__metrics" data-reveal>
			<div><strong data-count="30" data-suffix="%">30%</strong><span><?php esc_html_e( 'less duplicated effort', 'nolan-young-demo-theme-001' ); ?></span></div>
			<div><strong data-count="2" data-suffix="×">2×</strong><span><?php esc_html_e( 'faster decisions', 'nolan-young-demo-theme-001' ); ?></span></div>
			<div><strong data-count="96" data-suffix="%">96%</strong><span><?php esc_html_e( 'delivery predictability', 'nolan-young-demo-theme-001' ); ?></span></div>
		</div>
	</div>
</section>
