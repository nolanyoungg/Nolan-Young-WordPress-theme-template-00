<?php
/**
 * Template Name: About Us
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="content" class="studio-page">
	<header class="studio-cover"><div><span>A–003</span><p class="eyebrow"><?php esc_html_e( 'About the practice', 'nolan-young-demo-theme-003' ); ?></p><h1><?php esc_html_e( 'Small by design. Wide in perspective.', 'nolan-young-demo-theme-003' ); ?></h1></div><img src="<?php echo esc_url( nydemo003_asset_url( 'images/generated/modernist-studio.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Creative team working together in a modernist studio.', 'nolan-young-demo-theme-003' ); ?>" width="1920" height="1080"></header>
	<section id="story" class="studio-principles section"><div class="content-wrap"><header><p class="eyebrow"><?php esc_html_e( 'What holds the work together', 'nolan-young-demo-theme-003' ); ?></p><h2><?php esc_html_e( 'Clarity is a team sport.', 'nolan-young-demo-theme-003' ); ?></h2></header><div><article><span>01</span><h3><?php esc_html_e( 'Stay close', 'nolan-young-demo-theme-003' ); ?></h3><p><?php esc_html_e( 'Senior people remain present from the first question through the final release.', 'nolan-young-demo-theme-003' ); ?></p></article><article><span>02</span><h3><?php esc_html_e( 'Show the work', 'nolan-young-demo-theme-003' ); ?></h3><p><?php esc_html_e( 'Artifacts make decisions easier to inspect, challenge, and improve.', 'nolan-young-demo-theme-003' ); ?></p></article><article><span>03</span><h3><?php esc_html_e( 'Build ownership', 'nolan-young-demo-theme-003' ); ?></h3><p><?php esc_html_e( 'The system should become more useful after the external team leaves.', 'nolan-young-demo-theme-003' ); ?></p></article></div></div></section>
	<?php get_template_part( 'template-parts/content', 'about-us-cta' ); ?>
</main>
<?php get_footer();
