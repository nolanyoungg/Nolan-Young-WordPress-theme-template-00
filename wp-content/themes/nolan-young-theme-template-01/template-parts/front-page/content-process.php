<?php
/**
 * Process section.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_steps = array(
	array( __( 'Discover', 'nolan-young-theme-template-01' ), __( 'Define users, outcomes, constraints, and measurable success.', 'nolan-young-theme-template-01' ) ),
	array( __( 'Design', 'nolan-young-theme-template-01' ), __( 'Create a clear information system and accessible interaction model.', 'nolan-young-theme-template-01' ) ),
	array( __( 'Build', 'nolan-young-theme-template-01' ), __( 'Implement maintainable WordPress components with explicit boundaries.', 'nolan-young-theme-template-01' ) ),
	array( __( 'Validate', 'nolan-young-theme-template-01' ), __( 'Test functionality, accessibility, performance, and release packaging.', 'nolan-young-theme-template-01' ) ),
);
?>
<section class="nytt01-section nytt01-section--dark">
	<div class="nytt01-container">
		<header class="nytt01-section-header">
			<div>
				<p class="nytt01-eyebrow"><?php esc_html_e( 'Process', 'nolan-young-theme-template-01' ); ?></p>
				<h2><?php esc_html_e( 'A controlled path from idea to production', 'nolan-young-theme-template-01' ); ?></h2>
			</div>
		</header>
		<ol class="nytt01-process-list">
			<?php foreach ( $nytt01_steps as $nytt01_step ) : ?>
				<li>
					<h3><?php echo esc_html( $nytt01_step[0] ); ?></h3>
					<p><?php echo esc_html( $nytt01_step[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
