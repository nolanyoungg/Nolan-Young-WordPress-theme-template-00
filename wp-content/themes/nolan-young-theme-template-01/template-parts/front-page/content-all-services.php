<?php
/**
 * Services section with editable starter content.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_services = array(
	array(
		'title'       => esc_html__( 'WordPress strategy', 'nolan-young-theme-template-01' ),
		'description' => esc_html__( 'Clarify priorities, audiences, and the path from goals to a focused digital presence.', 'nolan-young-theme-template-01' ),
	),
	array(
		'title'       => esc_html__( 'Experience design', 'nolan-young-theme-template-01' ),
		'description' => esc_html__( 'Shape clear, accessible journeys that make the next step easy for every visitor.', 'nolan-young-theme-template-01' ),
	),
	array(
		'title'       => esc_html__( 'Theme engineering', 'nolan-young-theme-template-01' ),
		'description' => esc_html__( 'Build a maintainable WordPress foundation with practical performance and editing workflows.', 'nolan-young-theme-template-01' ),
	),
	array(
		'title'       => esc_html__( 'Performance optimization', 'nolan-young-theme-template-01' ),
		'description' => esc_html__( 'Improve loading, resilience, and the day-to-day experience of running the site.', 'nolan-young-theme-template-01' ),
	),
);
?>
<section class="nytt01-section nytt01-section--muted">
	<div class="nytt01-container">
		<header class="nytt01-section-header">
			<div>
				<p class="nytt01-eyebrow"><?php esc_html_e( 'Services', 'nolan-young-theme-template-01' ); ?></p>
				<h2><?php esc_html_e( 'Capabilities organized around real outcomes', 'nolan-young-theme-template-01' ); ?></h2>
			</div>
		</header>
		<div class="nytt01-service-grid">
			<?php foreach ( $nytt01_services as $nytt01_service ) : ?>
				<article class="nytt01-service-card">
					<h3><?php echo esc_html( $nytt01_service['title'] ); ?></h3>
					<p><?php echo esc_html( $nytt01_service['description'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
