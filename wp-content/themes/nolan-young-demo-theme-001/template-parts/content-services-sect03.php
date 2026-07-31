<?php
/**
 * Services engagement comparison.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;

$models = array(
	array( __( 'Diagnostic', 'nolan-young-demo-theme-001' ), __( '2–3 weeks', 'nolan-young-demo-theme-001' ), __( 'One high-value decision', 'nolan-young-demo-theme-001' ), __( 'Evidence review, stakeholder sessions, opportunity map, and prioritized next steps.', 'nolan-young-demo-theme-001' ) ),
	array( __( 'Delivery sprint', 'nolan-young-demo-theme-001' ), __( '6–10 weeks', 'nolan-young-demo-theme-001' ), __( 'One focused release', 'nolan-young-demo-theme-001' ), __( 'A complete cross-functional team delivering a product, service, or platform release.', 'nolan-young-demo-theme-001' ) ),
	array( __( 'Strategic partnership', 'nolan-young-demo-theme-001' ), __( 'Quarterly', 'nolan-young-demo-theme-001' ), __( 'A shared transformation roadmap', 'nolan-young-demo-theme-001' ), __( 'Ongoing planning, delivery, optimization, and internal capability support.', 'nolan-young-demo-theme-001' ) ),
);
?>
<section class="section section--cool">
	<div class="content-wrap engagement-models">
		<header class="section__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Flexible engagement', 'nolan-young-demo-theme-001' ); ?></p>
				<h2><?php esc_html_e( 'The right level of support for the decision ahead.', 'nolan-young-demo-theme-001' ); ?></h2>
			</div>
			<p class="section__lede"><?php esc_html_e( 'Start focused, scale when the evidence supports it, and keep ownership and decision rights visible throughout.', 'nolan-young-demo-theme-001' ); ?></p>
		</header>
		<div class="engagement-models__table" data-reveal>
			<div class="engagement-models__labels">
				<span><?php esc_html_e( 'Model', 'nolan-young-demo-theme-001' ); ?></span>
				<span><?php esc_html_e( 'Cadence', 'nolan-young-demo-theme-001' ); ?></span>
				<span><?php esc_html_e( 'Best for', 'nolan-young-demo-theme-001' ); ?></span>
				<span><?php esc_html_e( 'What it includes', 'nolan-young-demo-theme-001' ); ?></span>
			</div>
			<?php foreach ( $models as $index => $model ) : ?>
				<article>
					<span><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
					<h3><?php echo esc_html( $model[0] ); ?></h3>
					<strong><?php echo esc_html( $model[1] ); ?></strong>
					<p><?php echo esc_html( $model[2] ); ?></p>
					<p><?php echo esc_html( $model[3] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
		<div class="engagement-models__note" data-reveal>
			<span><?php esc_html_e( 'Not sure where to start?', 'nolan-young-demo-theme-001' ); ?></span>
			<strong><?php esc_html_e( 'Most complex programs begin with the diagnostic.', 'nolan-young-demo-theme-001' ); ?></strong>
			<a class="text-link" href="<?php echo esc_url( nydemo001_page_url( 'contact-us' ) ); ?>">
				<?php esc_html_e( 'Discuss the entry point', 'nolan-young-demo-theme-001' ); ?>
				<span aria-hidden="true">→</span>
			</a>
		</div>
	</div>
</section>
