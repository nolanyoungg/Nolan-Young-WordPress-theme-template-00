<?php
/**
 * Template Name: Services
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

$nydemo002_service_chapters = array(
	array( 'website-development', '01', __( 'Website Development', 'nolan-young-demo-theme-002' ), __( 'WordPress, headless, React, Shopify, landing pages, and redesigns composed into useful digital places.', 'nolan-young-demo-theme-002' ), 'service-web.jpg' ),
	array( 'plugin-development', '02', __( 'Plugin Development', 'nolan-young-demo-theme-002' ), __( 'Purpose-built WordPress tools, API integrations, booking systems, forms, and dashboard extensions.', 'nolan-young-demo-theme-002' ), 'service-plugin.jpg' ),
	array( 'seo', '03', __( 'SEO', 'nolan-young-demo-theme-002' ), __( 'Technical foundations, content optimization, schema, local search, research, and speed improvements.', 'nolan-young-demo-theme-002' ), 'service-seo.jpg' ),
	array( 'analytics', '04', __( 'Analytics', 'nolan-young-demo-theme-002' ), __( 'GA4, event and conversion tracking, funnels, dashboards, reporting, and trustworthy data cleanup.', 'nolan-young-demo-theme-002' ), 'service-analytics.jpg' ),
	array( 'ai-development', '05', __( 'AI Development', 'nolan-young-demo-theme-002' ), __( 'Chatbots, workflow automation, AI search, custom integrations, and internal assistants with human control.', 'nolan-young-demo-theme-002' ), 'service-ai.jpg' ),
);

get_header();
?>
<main id="content" class="editorial-page">
	<header class="editorial-cover">
		<div class="content-wrap editorial-cover__inner">
			<p class="eyebrow"><?php esc_html_e( 'Services · Five studio disciplines', 'nolan-young-demo-theme-002' ); ?></p>
			<h1><?php esc_html_e( 'A small, senior practice for ambitious digital work.', 'nolan-young-demo-theme-002' ); ?></h1>
			<p><?php esc_html_e( 'Choose one focused capability or compose several around the change your organization needs to make.', 'nolan-young-demo-theme-002' ); ?></p>
		</div>
	</header>
	<section class="editorial-chapters section">
		<div class="content-wrap">
			<?php foreach ( $nydemo002_service_chapters as $nydemo002_chapter ) : ?>
				<article id="<?php echo esc_attr( $nydemo002_chapter[0] ); ?>" class="editorial-chapter" data-reveal>
					<span><?php echo esc_html( $nydemo002_chapter[1] ); ?></span>
					<div><h2><?php echo esc_html( $nydemo002_chapter[2] ); ?></h2><p><?php echo esc_html( $nydemo002_chapter[3] ); ?></p></div>
					<img src="<?php echo esc_url( nydemo002_asset_url( 'images/generated/' . $nydemo002_chapter[4] ) ); ?>" alt="" width="900" height="900" loading="lazy">
					<a href="<?php echo esc_url( nydemo002_page_url( 'contact-us' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Discuss %s', 'nolan-young-demo-theme-002' ), $nydemo002_chapter[2] ) ); ?>">↗</a>
				</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php get_template_part( 'template-parts/content', 'services-cta' ); ?>
</main>
<?php get_footer();
