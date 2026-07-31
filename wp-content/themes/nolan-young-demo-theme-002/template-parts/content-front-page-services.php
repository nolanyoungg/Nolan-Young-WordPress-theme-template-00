<?php
/**
 * Front-page services folio.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

$nydemo002_services = array(
	array( '01', __( 'Website Development', 'nolan-young-demo-theme-002' ), __( 'Accessible, expressive websites built to age well.', 'nolan-young-demo-theme-002' ), 'service-web.jpg', 'website-development' ),
	array( '02', __( 'Plugin Development', 'nolan-young-demo-theme-002' ), __( 'Focused WordPress tools fitted to the way your team works.', 'nolan-young-demo-theme-002' ), 'service-plugin.jpg', 'plugin-development' ),
	array( '03', __( 'SEO', 'nolan-young-demo-theme-002' ), __( 'Search foundations shaped around useful content and real intent.', 'nolan-young-demo-theme-002' ), 'service-seo.jpg', 'seo' ),
	array( '04', __( 'Analytics', 'nolan-young-demo-theme-002' ), __( 'Measurement systems that turn signals into better decisions.', 'nolan-young-demo-theme-002' ), 'service-analytics.jpg', 'analytics' ),
	array( '05', __( 'AI Development', 'nolan-young-demo-theme-002' ), __( 'Practical automation with human judgment kept in the loop.', 'nolan-young-demo-theme-002' ), 'service-ai.jpg', 'ai-development' ),
);
?>
<section class="folio section">
	<div class="content-wrap">
		<header class="folio__intro" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'The studio folio', 'nolan-young-demo-theme-002' ); ?></p>
			<h2><?php esc_html_e( 'Five disciplines, composed around one ambition.', 'nolan-young-demo-theme-002' ); ?></h2>
			<p><?php esc_html_e( 'Make the digital experience feel simpler on the outside and stronger underneath.', 'nolan-young-demo-theme-002' ); ?></p>
		</header>
		<div class="folio__grid">
			<?php foreach ( $nydemo002_services as $nydemo002_index => $nydemo002_service ) : ?>
				<article class="folio-card<?php echo 0 === $nydemo002_index ? ' folio-card--feature' : ''; ?>" data-reveal>
					<a href="<?php echo esc_url( nydemo002_page_url( 'services' ) . '#' . $nydemo002_service[4] ); ?>">
						<figure>
							<img src="<?php echo esc_url( nydemo002_asset_url( 'images/generated/' . $nydemo002_service[3] ) ); ?>" alt="" width="900" height="900" loading="lazy">
							<span><?php echo esc_html( $nydemo002_service[0] ); ?></span>
						</figure>
						<div>
							<h3><?php echo esc_html( $nydemo002_service[1] ); ?></h3>
							<p><?php echo esc_html( $nydemo002_service[2] ); ?></p>
							<span class="folio-card__arrow" aria-hidden="true">↗</span>
						</div>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
