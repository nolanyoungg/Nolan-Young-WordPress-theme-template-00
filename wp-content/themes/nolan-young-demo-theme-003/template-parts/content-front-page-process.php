<?php
/**
 * Front-page method matrix.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

$nydemo003_method = array(
	array( 'A', __( 'Frame', 'nolan-young-demo-theme-003' ), __( 'Name the decision, pressure, and useful evidence.', 'nolan-young-demo-theme-003' ) ),
	array( 'B', __( 'Prototype', 'nolan-young-demo-theme-003' ), __( 'Make the difficult parts tangible before they become expensive.', 'nolan-young-demo-theme-003' ) ),
	array( 'C', __( 'Construct', 'nolan-young-demo-theme-003' ), __( 'Build in clear increments with quality visible throughout.', 'nolan-young-demo-theme-003' ) ),
	array( 'D', __( 'Evolve', 'nolan-young-demo-theme-003' ), __( 'Learn from real use and strengthen the team that owns it.', 'nolan-young-demo-theme-003' ) ),
);
?>
<section class="method-matrix section"><div class="content-wrap"><header><span>04 / 05</span><h2><?php esc_html_e( 'A method built around visible decisions.', 'nolan-young-demo-theme-003' ); ?></h2></header><ol><?php foreach ( $nydemo003_method as $nydemo003_step ) : ?><li data-reveal><span><?php echo esc_html( $nydemo003_step[0] ); ?></span><h3><?php echo esc_html( $nydemo003_step[1] ); ?></h3><p><?php echo esc_html( $nydemo003_step[2] ); ?></p></li><?php endforeach; ?></ol></div></section>
