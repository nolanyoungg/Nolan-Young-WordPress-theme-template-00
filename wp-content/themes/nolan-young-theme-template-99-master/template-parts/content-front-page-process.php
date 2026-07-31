<?php
/**
 * Front-page delivery operating system.
 *
 * @package NolanYoungThemeTemplate99Master
 */

defined( 'ABSPATH' ) || exit;

$phases = array(
	array( '01', __( 'Frame the decision', 'nolan-young-theme-template-99-master' ), __( 'Align the context, evidence, constraints, and definition of success.', 'nolan-young-theme-template-99-master' ), __( 'Decision brief', 'nolan-young-theme-template-99-master' ), __( 'Week 01–02', 'nolan-young-theme-template-99-master' ) ),
	array( '02', __( 'Shape the system', 'nolan-young-theme-template-99-master' ), __( 'Prototype the experience and test the highest-risk assumptions early.', 'nolan-young-theme-template-99-master' ), __( 'Validated prototype', 'nolan-young-theme-template-99-master' ), __( 'Week 03–05', 'nolan-young-theme-template-99-master' ) ),
	array( '03', __( 'Build with control', 'nolan-young-theme-template-99-master' ), __( 'Deliver in visible increments with accessibility and quality built in.', 'nolan-young-theme-template-99-master' ), __( 'Production system', 'nolan-young-theme-template-99-master' ), __( 'Week 06–10', 'nolan-young-theme-template-99-master' ) ),
	array( '04', __( 'Launch and improve', 'nolan-young-theme-template-99-master' ), __( 'Measure adoption, remove friction, and strengthen the internal team.', 'nolan-young-theme-template-99-master' ), __( 'Improvement rhythm', 'nolan-young-theme-template-99-master' ), __( 'Ongoing', 'nolan-young-theme-template-99-master' ) ),
);
?>
<section class="section section--cream">
	<div class="content-wrap delivery-system">
		<header class="delivery-system__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'A visible delivery system', 'nolan-young-theme-template-99-master' ); ?></p>
				<h2><?php esc_html_e( 'Less theatre. More useful decisions.', 'nolan-young-theme-template-99-master' ); ?></h2>
			</div>
			<div>
				<p><?php esc_html_e( 'Short cycles, senior access, and clear evidence keep important choices visible from discovery through launch.', 'nolan-young-theme-template-99-master' ); ?></p>
				<span><?php esc_html_e( 'Every phase ends in an inspectable artifact.', 'nolan-young-theme-template-99-master' ); ?></span>
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
						<span><?php esc_html_e( 'Primary artifact', 'nolan-young-theme-template-99-master' ); ?></span>
						<strong><?php echo esc_html( $phase[3] ); ?></strong>
					</div>
					<time><?php echo esc_html( $phase[4] ); ?></time>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
