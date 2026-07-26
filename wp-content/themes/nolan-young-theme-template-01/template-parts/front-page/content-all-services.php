<?php
/**
 * Services section with editable starter content.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_services     = array(
	array(
		'title'       => __( 'WordPress strategy', 'nolan-young-theme-template-01' ),
		'description' => __( 'Clarify priorities, audiences, and the path from goals to a focused digital presence.', 'nolan-young-theme-template-01' ),
	),
	array(
		'title'       => __( 'Experience design', 'nolan-young-theme-template-01' ),
		'description' => __( 'Shape clear, accessible journeys that make the next step easy for every visitor.', 'nolan-young-theme-template-01' ),
	),
	array(
		'title'       => __( 'Theme engineering', 'nolan-young-theme-template-01' ),
		'description' => __( 'Build a maintainable WordPress foundation with practical performance and editing workflows.', 'nolan-young-theme-template-01' ),
	),
	array(
		'title'       => __( 'Performance optimization', 'nolan-young-theme-template-01' ),
		'description' => __( 'Improve loading, resilience, and the day-to-day experience of running the site.', 'nolan-young-theme-template-01' ),
	),
);
$nytt01_services_url = nytt01_get_destination_url( 'services' );
?>
<section class="nytt01-section nytt01-section--muted">
	<div class="nytt01-container">
		<header class="nytt01-section-header">
			<div>
				<p class="nytt01-eyebrow"><?php esc_html_e( 'Services', 'nolan-young-theme-template-01' ); ?></p>
				<h2><?php esc_html_e( 'Capabilities organized around real outcomes', 'nolan-young-theme-template-01' ); ?></h2>
			</div>
			<?php if ( $nytt01_services_url && ! is_page_template( 'page-templates/template-services.php' ) ) : ?>
				<a class="nytt01-text-link" href="<?php echo esc_url( $nytt01_services_url ); ?>"><?php esc_html_e( 'View all services', 'nolan-young-theme-template-01' ); ?><span aria-hidden="true"> →</span></a>
			<?php endif; ?>
		</header>
		<div class="nytt01-service-grid">
			<?php
			foreach ( $nytt01_services as $nytt01_service ) :
				?>
				<article class="nytt01-service-card">
					<h3><?php echo esc_html( $nytt01_service['title'] ); ?></h3>
					<p><?php echo esc_html( $nytt01_service['description'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
