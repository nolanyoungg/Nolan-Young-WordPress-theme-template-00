<?php
/**
 * Front-page interactive service system.
 *
 * @package NolanYoungThemeTemplate99Master
 */

defined( 'ABSPATH' ) || exit;

$services = array(
	array(
		'code'         => '01',
		'title'        => __( 'Strategy and direction', 'nolan-young-theme-template-99-master' ),
		'description'  => __( 'Clarify the opportunity, align decision-makers, and define measurable success before expensive delivery begins.', 'nolan-young-theme-template-99-master' ),
		'outcome'      => __( 'A decision-ready roadmap', 'nolan-young-theme-template-99-master' ),
		'deliverables' => array( __( 'Opportunity framing', 'nolan-young-theme-template-99-master' ), __( 'Stakeholder alignment', 'nolan-young-theme-template-99-master' ), __( 'Prioritized roadmap', 'nolan-young-theme-template-99-master' ) ),
	),
	array(
		'code'         => '02',
		'title'        => __( 'Experience transformation', 'nolan-young-theme-template-99-master' ),
		'description'  => __( 'Turn complex customer and employee journeys into accessible, understandable, and high-performing digital experiences.', 'nolan-young-theme-template-99-master' ),
		'outcome'      => __( 'Less friction, stronger adoption', 'nolan-young-theme-template-99-master' ),
		'deliverables' => array( __( 'Journey diagnostics', 'nolan-young-theme-template-99-master' ), __( 'Interaction system', 'nolan-young-theme-template-99-master' ), __( 'Accessible prototypes', 'nolan-young-theme-template-99-master' ) ),
	),
	array(
		'code'         => '03',
		'title'        => __( 'WordPress engineering', 'nolan-young-theme-template-99-master' ),
		'description'  => __( 'Build maintainable publishing platforms, integrations, and dependable release systems around the way teams actually work.', 'nolan-young-theme-template-99-master' ),
		'outcome'      => __( 'A platform the organization can own', 'nolan-young-theme-template-99-master' ),
		'deliverables' => array( __( 'Component architecture', 'nolan-young-theme-template-99-master' ), __( 'Integration delivery', 'nolan-young-theme-template-99-master' ), __( 'Release controls', 'nolan-young-theme-template-99-master' ) ),
	),
	array(
		'code'         => '04',
		'title'        => __( 'Technical stewardship', 'nolan-young-theme-template-99-master' ),
		'description'  => __( 'Improve performance, stability, security, and internal capability after launch through an evidence-led operating rhythm.', 'nolan-young-theme-template-99-master' ),
		'outcome'      => __( 'Continuous, controlled improvement', 'nolan-young-theme-template-99-master' ),
		'deliverables' => array( __( 'Performance program', 'nolan-young-theme-template-99-master' ), __( 'Risk management', 'nolan-young-theme-template-99-master' ), __( 'Team enablement', 'nolan-young-theme-template-99-master' ) ),
	),
);
?>
<section class="section section--cream">
	<div class="content-wrap service-system">
		<header class="service-system__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Connected capabilities', 'nolan-young-theme-template-99-master' ); ?></p>
				<h2><?php esc_html_e( 'One senior team. Four ways to create momentum.', 'nolan-young-theme-template-99-master' ); ?></h2>
			</div>
			<div>
				<p><?php esc_html_e( 'Start with the pressure point. Combine only the capabilities that help the organization make a better next move.', 'nolan-young-theme-template-99-master' ); ?></p>
				<a class="text-link" href="<?php echo esc_url( nytt99_page_url( 'services' ) ); ?>">
					<?php esc_html_e( 'Explore the complete service system', 'nolan-young-theme-template-99-master' ); ?>
					<span aria-hidden="true">→</span>
				</a>
			</div>
		</header>

		<div class="service-system__workspace" data-reveal>
			<div class="service-system__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Service capabilities', 'nolan-young-theme-template-99-master' ); ?>">
				<?php foreach ( $services as $index => $service ) : ?>
					<button
						id="home-service-tab-<?php echo esc_attr( $service['code'] ); ?>"
						type="button"
						role="tab"
						aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
						aria-controls="home-service-panel-<?php echo esc_attr( $service['code'] ); ?>"
						tabindex="<?php echo 0 === $index ? '0' : '-1'; ?>"
					>
						<span><?php echo esc_html( $service['code'] ); ?></span>
						<strong><?php echo esc_html( $service['title'] ); ?></strong>
						<i aria-hidden="true">↗</i>
					</button>
				<?php endforeach; ?>
			</div>

			<div class="service-system__panels">
				<?php foreach ( $services as $index => $service ) : ?>
					<article
						id="home-service-panel-<?php echo esc_attr( $service['code'] ); ?>"
						class="service-system__panel"
						role="tabpanel"
						aria-labelledby="home-service-tab-<?php echo esc_attr( $service['code'] ); ?>"
						<?php echo 0 === $index ? '' : 'hidden'; ?>
					>
						<div class="service-system__panel-top">
							<span><?php esc_html_e( 'Capability view', 'nolan-young-theme-template-99-master' ); ?></span>
							<span><?php echo esc_html( $service['code'] ); ?> / 04</span>
						</div>
						<div class="service-system__panel-main">
							<div>
								<p class="eyebrow"><?php echo esc_html( $service['outcome'] ); ?></p>
								<h3><?php echo esc_html( $service['title'] ); ?></h3>
								<p><?php echo esc_html( $service['description'] ); ?></p>
								<a class="text-link" href="<?php echo esc_url( nytt99_page_url( 'services' ) . '#service-' . ( $index + 1 ) ); ?>">
									<?php esc_html_e( 'Review this capability', 'nolan-young-theme-template-99-master' ); ?>
									<span aria-hidden="true">→</span>
								</a>
							</div>
							<div class="service-system__diagram" aria-hidden="true">
								<span></span><span></span><span></span><span></span>
							</div>
						</div>
						<ul>
							<?php foreach ( $service['deliverables'] as $deliverable ) : ?>
								<li><i aria-hidden="true"></i><?php echo esc_html( $deliverable ); ?></li>
							<?php endforeach; ?>
						</ul>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
