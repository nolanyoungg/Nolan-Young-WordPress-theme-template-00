<?php
/**
 * Services capability workspace.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

$service_tracks = array(
	array( '01', __( 'Strategy and direction', 'nolan-young-demo-theme-003' ), __( 'Create a direction people can use.', 'nolan-young-demo-theme-003' ), __( 'Research, stakeholder alignment, service framing, roadmap design, and measurable success criteria.', 'nolan-young-demo-theme-003' ), __( '2–4 weeks', 'nolan-young-demo-theme-003' ), __( 'Decision-ready roadmap', 'nolan-young-demo-theme-003' ), array( __( 'Research', 'nolan-young-demo-theme-003' ), __( 'Opportunity framing', 'nolan-young-demo-theme-003' ), __( 'Roadmaps', 'nolan-young-demo-theme-003' ) ) ),
	array( '02', __( 'Experience transformation', 'nolan-young-demo-theme-003' ), __( 'Make complex journeys feel simple.', 'nolan-young-demo-theme-003' ), __( 'Journey mapping, content architecture, interaction design, usability testing, and accessibility improvement.', 'nolan-young-demo-theme-003' ), __( '4–8 weeks', 'nolan-young-demo-theme-003' ), __( 'Validated experience system', 'nolan-young-demo-theme-003' ), array( __( 'UX audits', 'nolan-young-demo-theme-003' ), __( 'Prototypes', 'nolan-young-demo-theme-003' ), __( 'Accessibility', 'nolan-young-demo-theme-003' ) ) ),
	array( '03', __( 'WordPress engineering', 'nolan-young-demo-theme-003' ), __( 'Build a platform the team can trust.', 'nolan-young-demo-theme-003' ), __( 'Custom WordPress engineering, integrations, component systems, testing, and controlled release workflows.', 'nolan-young-demo-theme-003' ), __( '6–12 weeks', 'nolan-young-demo-theme-003' ), __( 'Maintainable production platform', 'nolan-young-demo-theme-003' ), array( __( 'WordPress', 'nolan-young-demo-theme-003' ), __( 'APIs', 'nolan-young-demo-theme-003' ), __( 'Release systems', 'nolan-young-demo-theme-003' ) ) ),
	array( '04', __( 'Technical stewardship', 'nolan-young-demo-theme-003' ), __( 'Keep improving after launch.', 'nolan-young-demo-theme-003' ), __( 'Performance, maintenance, observability, security support, experimentation, and capability transfer.', 'nolan-young-demo-theme-003' ), __( 'Quarterly', 'nolan-young-demo-theme-003' ), __( 'Controlled improvement rhythm', 'nolan-young-demo-theme-003' ), array( __( 'Performance', 'nolan-young-demo-theme-003' ), __( 'Maintenance', 'nolan-young-demo-theme-003' ), __( 'Support', 'nolan-young-demo-theme-003' ) ) ),
);
?>
<section id="capabilities" class="section section--cream">
	<div class="content-wrap">
		<header class="section__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Service architecture', 'nolan-young-demo-theme-003' ); ?></p>
				<h2><?php esc_html_e( 'Choose the right entry point.', 'nolan-young-demo-theme-003' ); ?></h2>
			</div>
			<p class="section__lede"><?php esc_html_e( 'Each track can stand alone or connect into a complete transformation program without changing teams at every handoff.', 'nolan-young-demo-theme-003' ); ?></p>
		</header>
		<div class="service-tabs" data-reveal>
			<div class="service-tabs__controls" role="tablist" aria-label="<?php esc_attr_e( 'Service tracks', 'nolan-young-demo-theme-003' ); ?>">
				<?php foreach ( $service_tracks as $index => $track ) : ?>
					<button
						id="service-tab-<?php echo esc_attr( $track[0] ); ?>"
						role="tab"
						aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
						aria-controls="service-panel-<?php echo esc_attr( $track[0] ); ?>"
						tabindex="<?php echo 0 === $index ? '0' : '-1'; ?>"
					>
						<span><?php echo esc_html( $track[0] ); ?></span>
						<strong><?php echo esc_html( $track[1] ); ?></strong>
						<i aria-hidden="true">↗</i>
					</button>
				<?php endforeach; ?>
			</div>
			<div class="service-tabs__panels">
				<?php foreach ( $service_tracks as $index => $track ) : ?>
					<article
						id="service-panel-<?php echo esc_attr( $track[0] ); ?>"
						class="service-tabs__panel"
						role="tabpanel"
						aria-labelledby="service-tab-<?php echo esc_attr( $track[0] ); ?>"
						<?php echo 0 === $index ? '' : 'hidden'; ?>
					>
						<div class="service-tabs__panel-top">
							<span><?php esc_html_e( 'Service track', 'nolan-young-demo-theme-003' ); ?></span>
							<span><?php echo esc_html( $track[0] ); ?> / 04</span>
						</div>
						<div class="service-tabs__panel-main">
							<div>
								<p class="eyebrow"><?php echo esc_html( $track[1] ); ?></p>
								<h3><?php echo esc_html( $track[2] ); ?></h3>
								<p><?php echo esc_html( $track[3] ); ?></p>
							</div>
							<div class="service-tabs__panel-diagram" aria-hidden="true"><i></i><i></i><i></i></div>
						</div>
						<dl>
							<div>
								<dt><?php esc_html_e( 'Typical duration', 'nolan-young-demo-theme-003' ); ?></dt>
								<dd><?php echo esc_html( $track[4] ); ?></dd>
							</div>
							<div>
								<dt><?php esc_html_e( 'Primary outcome', 'nolan-young-demo-theme-003' ); ?></dt>
								<dd><?php echo esc_html( $track[5] ); ?></dd>
							</div>
						</dl>
						<ul>
							<?php foreach ( $track[6] as $capability ) : ?>
								<li><?php echo esc_html( $capability ); ?></li>
							<?php endforeach; ?>
						</ul>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
