<?php
/**
 * Front-page invitation.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="studio-invitation section">
	<div class="content-wrap studio-invitation__inner" data-reveal>
		<div><span class="studio-invitation__seal" aria-hidden="true">NY<br>002</span></div>
		<div>
			<p class="eyebrow"><?php esc_html_e( 'A good place to begin', 'nolan-young-demo-theme-002' ); ?></p>
			<h2><?php esc_html_e( 'Tell us what should feel different six months from now.', 'nolan-young-demo-theme-002' ); ?></h2>
			<p><?php esc_html_e( 'One thoughtful conversation is enough to understand the tension, test the fit, and name a useful next step.', 'nolan-young-demo-theme-002' ); ?></p>
		</div>
		<div><?php nydemo002_button( __( 'Write to the studio', 'nolan-young-demo-theme-002' ) ); ?></div>
	</div>
</section>
