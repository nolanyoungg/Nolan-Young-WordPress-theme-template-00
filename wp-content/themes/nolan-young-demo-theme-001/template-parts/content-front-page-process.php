<?php
/**
 * Front-page delivery operating system.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;

$phases = array(
	array( '01', __( 'Frame the decision', 'nolan-young-demo-theme-001' ), __( 'Align the context, evidence, constraints, and definition of success.', 'nolan-young-demo-theme-001' ), __( 'Decision brief', 'nolan-young-demo-theme-001' ), __( 'Week 01–02', 'nolan-young-demo-theme-001' ) ),
	array( '02', __( 'Shape the system', 'nolan-young-demo-theme-001' ), __( 'Prototype the experience and test the highest-risk assumptions early.', 'nolan-young-demo-theme-001' ), __( 'Validated prototype', 'nolan-young-demo-theme-001' ), __( 'Week 03–05', 'nolan-young-demo-theme-001' ) ),
	array( '03', __( 'Build with control', 'nolan-young-demo-theme-001' ), __( 'Deliver in visible increments with accessibility and quality built in.', 'nolan-young-demo-theme-001' ), __( 'Production system', 'nolan-young-demo-theme-001' ), __( 'Week 06–10', 'nolan-young-demo-theme-001' ) ),
	array( '04', __( 'Launch and improve', 'nolan-young-demo-theme-001' ), __( 'Measure adoption, remove friction, and strengthen the internal team.', 'nolan-young-demo-theme-001' ), __( 'Improvement rhythm', 'nolan-young-demo-theme-001' ), __( 'Ongoing', 'nolan-young-demo-theme-001' ) ),
);
?>
<section class="section section--cream">
	<div class="content-wrap delivery-system">
		<header class="delivery-system__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'A visible delivery system', 'nolan-young-demo-theme-001' ); ?></p>
				<h2><?php esc_html_e( 'Less theatre. More useful decisions.', 'nolan-young-demo-theme-001' ); ?></h2>
			</div>
			<div>
				<p><?php esc_html_e( 'Short cycles, senior access, and clear evidence keep important choices visible from discovery through launch.', 'nolan-young-demo-theme-001' ); ?></p>
				<span><?php esc_html_e( 'Every phase ends in an inspectable artifact.', 'nolan-young-demo-theme-001' ); ?></span>
			</div>
		</header>

		<ol class="delivery-system__timeline" data-reveal>
			<?php foreach ( $phases as $phase ) : ?>
				<li>
					<div class="delivery-system__phase">
						<span><?php echo esc_html( $phase[0] ); ?></span>
						<i aria-hidden="true"></i>
					</div>
					<div class="delivery-system__content">
						<h3><?php echo esc_html( $phase[1] ); ?></h3>
						<p><?php echo esc_html( $phase[2] ); ?></p>
					</div>
					<div class="delivery-system__artifact">
						<span><?php esc_html_e( 'Primary artifact', 'nolan-young-demo-theme-001' ); ?></span>
						<strong><?php echo esc_html( $phase[3] ); ?></strong>
					</div>
					<time><?php echo esc_html( $phase[4] ); ?></time>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
