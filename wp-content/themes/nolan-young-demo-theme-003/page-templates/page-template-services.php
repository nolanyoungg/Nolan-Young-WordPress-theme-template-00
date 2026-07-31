<?php
/**
 * Template Name: Services
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

$nydemo003_services = array(
	array( 'website-development', '01', __( 'Website Development', 'nolan-young-demo-theme-003' ), __( 'WordPress, headless, React, Shopify, landing pages, and redesigns.', 'nolan-young-demo-theme-003' ), 'capability-web.jpg' ),
	array( 'plugin-development', '02', __( 'Plugin Development', 'nolan-young-demo-theme-003' ), __( 'Forms, menus, bookings, APIs, SEO tools, and custom admin systems.', 'nolan-young-demo-theme-003' ), 'capability-plugin.jpg' ),
	array( 'seo', '03', __( 'SEO', 'nolan-young-demo-theme-003' ), __( 'Technical SEO, local search, research, content, schema, and performance.', 'nolan-young-demo-theme-003' ), 'capability-seo.jpg' ),
	array( 'analytics', '04', __( 'Analytics', 'nolan-young-demo-theme-003' ), __( 'GA4, events, conversions, dashboards, funnels, reports, and data cleanup.', 'nolan-young-demo-theme-003' ), 'capability-analytics.jpg' ),
	array( 'ai-development', '05', __( 'AI Development', 'nolan-young-demo-theme-003' ), __( 'Assistants, search, workflow automation, content tools, and custom integrations.', 'nolan-young-demo-theme-003' ), 'capability-ai.jpg' ),
);
get_header();
?>
<main id="content" class="catalogue-page">
	<header class="catalogue-cover"><div class="content-wrap"><span>S–003</span><p class="eyebrow"><?php esc_html_e( 'Service catalogue', 'nolan-young-demo-theme-003' ); ?></p><h1><?php esc_html_e( 'Choose a capability. Compose a system.', 'nolan-young-demo-theme-003' ); ?></h1></div></header>
	<section class="service-catalogue section"><div class="content-wrap"><ol>
		<?php foreach ( $nydemo003_services as $nydemo003_service ) : ?>
			<li id="<?php echo esc_attr( $nydemo003_service[0] ); ?>" data-reveal><span><?php echo esc_html( $nydemo003_service[1] ); ?></span><img src="<?php echo esc_url( nydemo003_asset_url( 'images/generated/' . $nydemo003_service[4] ) ); ?>" alt="" width="900" height="900" loading="lazy"><div><h2><?php echo esc_html( $nydemo003_service[2] ); ?></h2><p><?php echo esc_html( $nydemo003_service[3] ); ?></p><a class="text-link" href="<?php echo esc_url( nydemo003_page_url( 'contact-us' ) ); ?>"><?php esc_html_e( 'Start here', 'nolan-young-demo-theme-003' ); ?> ↗</a></div></li>
		<?php endforeach; ?>
	</ol></div></section>
	<?php get_template_part( 'template-parts/content', 'services-cta' ); ?>
</main>
<?php get_footer();
