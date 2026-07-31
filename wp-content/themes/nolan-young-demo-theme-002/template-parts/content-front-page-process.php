<?php
/**
 * Front-page studio rhythm.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

$nydemo002_rhythm = array(
	array( 'I', __( 'Listen closely', 'nolan-young-demo-theme-002' ), __( 'Find the real pressure behind the brief and the evidence already in the room.', 'nolan-young-demo-theme-002' ) ),
	array( 'II', __( 'Make it visible', 'nolan-young-demo-theme-002' ), __( 'Turn assumptions into artifacts people can inspect, question, and improve together.', 'nolan-young-demo-theme-002' ) ),
	array( 'III', __( 'Build the right thing', 'nolan-young-demo-theme-002' ), __( 'Ship in deliberate layers with accessibility, performance, and ownership built in.', 'nolan-young-demo-theme-002' ) ),
	array( 'IV', __( 'Keep learning', 'nolan-young-demo-theme-002' ), __( 'Measure what matters, strengthen the system, and leave the team more capable.', 'nolan-young-demo-theme-002' ) ),
);
?>
<section class="studio-rhythm section">
	<div class="content-wrap">
		<header class="studio-rhythm__intro" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Our working rhythm', 'nolan-young-demo-theme-002' ); ?></p>
			<h2><?php esc_html_e( 'Careful enough to be trusted. Nimble enough to move.', 'nolan-young-demo-theme-002' ); ?></h2>
		</header>
		<ol class="studio-rhythm__steps">
			<?php foreach ( $nydemo002_rhythm as $nydemo002_step ) : ?>
				<li data-reveal><span><?php echo esc_html( $nydemo002_step[0] ); ?></span><h3><?php echo esc_html( $nydemo002_step[1] ); ?></h3><p><?php echo esc_html( $nydemo002_step[2] ); ?></p></li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
