<?php
/**
 * About operating and collaboration model.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

$operating_phases = array(
	array( '01', __( 'Frame', 'nolan-young-demo-theme-003' ), __( 'Context and decision', 'nolan-young-demo-theme-003' ) ),
	array( '02', __( 'Focus', 'nolan-young-demo-theme-003' ), __( 'Direction and priorities', 'nolan-young-demo-theme-003' ) ),
	array( '03', __( 'Make', 'nolan-young-demo-theme-003' ), __( 'Prototype and evidence', 'nolan-young-demo-theme-003' ) ),
	array( '04', __( 'Build', 'nolan-young-demo-theme-003' ), __( 'System and release', 'nolan-young-demo-theme-003' ) ),
	array( '05', __( 'Improve', 'nolan-young-demo-theme-003' ), __( 'Measurement and ownership', 'nolan-young-demo-theme-003' ) ),
);
?>
<section id="approach" class="section section--navy">
	<div class="content-wrap operating-system">
		<header class="operating-system__heading" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Operating model', 'nolan-young-demo-theme-003' ); ?></p>
			<h2><?php esc_html_e( 'Fewer handovers. Better decisions.', 'nolan-young-demo-theme-003' ); ?></h2>
			<p><?php esc_html_e( 'The same senior team frames, prototypes, builds, tests, and improves the work while decision rights remain explicit.', 'nolan-young-demo-theme-003' ); ?></p>
		</header>
		<div class="operating-system__map" data-reveal>
			<div class="operating-system__topline">
				<span><?php esc_html_e( 'Connected delivery path', 'nolan-young-demo-theme-003' ); ?></span>
				<span><?php esc_html_e( 'One team / one evidence base', 'nolan-young-demo-theme-003' ); ?></span>
			</div>
			<ol>
				<?php foreach ( $operating_phases as $phase ) : ?>
					<li><span><?php echo esc_html( $phase[0] ); ?></span><i aria-hidden="true"></i><strong><?php echo esc_html( $phase[1] ); ?></strong><small><?php echo esc_html( $phase[2] ); ?></small></li>
				<?php endforeach; ?>
			</ol>
			<div class="operating-system__rhythm">
				<div><span><?php esc_html_e( 'Weekly', 'nolan-young-demo-theme-003' ); ?></span><strong><?php esc_html_e( 'Working review', 'nolan-young-demo-theme-003' ); ?></strong></div>
				<div><span><?php esc_html_e( 'At each gate', 'nolan-young-demo-theme-003' ); ?></span><strong><?php esc_html_e( 'Evidence and decision', 'nolan-young-demo-theme-003' ); ?></strong></div>
				<div><span><?php esc_html_e( 'At handover', 'nolan-young-demo-theme-003' ); ?></span><strong><?php esc_html_e( 'Ownership transfer', 'nolan-young-demo-theme-003' ); ?></strong></div>
			</div>
		</div>
	</div>
</section>
