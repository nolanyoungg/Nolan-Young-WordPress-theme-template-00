<?php
/**
 * Services technology and assurance system.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;

$assurances = array(
	array( '01', __( 'Accessible', 'nolan-young-demo-theme-001' ), __( 'WCAG-aware patterns, semantic foundations, and verified keyboard paths.', 'nolan-young-demo-theme-001' ), 'AA' ),
	array( '02', __( 'Performant', 'nolan-young-demo-theme-001' ), __( 'Lean assets, measurable budgets, and user-centered performance targets.', 'nolan-young-demo-theme-001' ), '<2.5s' ),
	array( '03', __( 'Integrated', 'nolan-young-demo-theme-001' ), __( 'Explicit contracts and graceful failure between essential systems.', 'nolan-young-demo-theme-001' ), 'API' ),
	array( '04', __( 'Observable', 'nolan-young-demo-theme-001' ), __( 'Signals that support useful operational and product decisions.', 'nolan-young-demo-theme-001' ), '24/7' ),
	array( '05', __( 'Maintainable', 'nolan-young-demo-theme-001' ), __( 'Documented systems, controlled releases, and ownership your team can sustain.', 'nolan-young-demo-theme-001' ), 'OWN' ),
	array( '06', __( 'Supported', 'nolan-young-demo-theme-001' ), __( 'Clear escalation, response expectations, and improvement planning after launch.', 'nolan-young-demo-theme-001' ), 'SLA' ),
);
?>
<section class="section section--navy">
	<div class="content-wrap assurance-system">
		<header class="section__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Quality built in', 'nolan-young-demo-theme-001' ); ?></p>
				<h2><?php esc_html_e( 'Every interaction should pull its weight.', 'nolan-young-demo-theme-001' ); ?></h2>
			</div>
			<p class="section__lede"><?php esc_html_e( 'The platform is treated as an operating system: usable, observable, maintainable, and ready to evolve.', 'nolan-young-demo-theme-001' ); ?></p>
		</header>
		<div class="assurance-system__grid" data-reveal>
			<?php foreach ( $assurances as $assurance ) : ?>
				<article>
					<div>
						<span><?php echo esc_html( $assurance[0] ); ?></span>
						<strong><?php echo esc_html( $assurance[3] ); ?></strong>
					</div>
					<h3><?php echo esc_html( $assurance[1] ); ?></h3>
					<p><?php echo esc_html( $assurance[2] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
		<footer class="assurance-system__footer" data-reveal>
			<span><?php esc_html_e( 'Delivery standard', 'nolan-young-demo-theme-001' ); ?></span>
			<strong><?php esc_html_e( 'Accessibility, performance, testing, and documentation are release criteria—not optional extras.', 'nolan-young-demo-theme-001' ); ?></strong>
		</footer>
	</div>
</section>
