<?php
/**
 * Template Name: Work
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

$nydemo003_projects = array(
	array( 'capability-web.jpg', __( 'One publishing system', 'nolan-young-demo-theme-003' ), __( 'Platform', 'nolan-young-demo-theme-003' ), '41%' ),
	array( 'capability-seo.jpg', __( 'Expertise made discoverable', 'nolan-young-demo-theme-003' ), __( 'Search', 'nolan-young-demo-theme-003' ), '2.8×' ),
	array( 'capability-analytics.jpg', __( 'One shared measurement story', 'nolan-young-demo-theme-003' ), __( 'Analytics', 'nolan-young-demo-theme-003' ), '−64%' ),
	array( 'capability-ai.jpg', __( 'Judgment amplified carefully', 'nolan-young-demo-theme-003' ), __( 'AI systems', 'nolan-young-demo-theme-003' ), '11h' ),
);
get_header();
?>
<main id="content" class="project-index"><header class="project-index__cover"><div class="content-wrap"><span>W–003</span><p class="eyebrow"><?php esc_html_e( 'Project index', 'nolan-young-demo-theme-003' ); ?></p><h1><?php esc_html_e( 'Four fictional cases. Four visible shifts.', 'nolan-young-demo-theme-003' ); ?></h1></div></header><section id="project-library" class="project-posters section"><div class="content-wrap">
	<?php foreach ( $nydemo003_projects as $nydemo003_index => $nydemo003_project ) : ?><article<?php echo 0 === $nydemo003_index ? ' id="flagship-case"' : ''; ?> data-reveal><span><?php echo esc_html( sprintf( '%02d', $nydemo003_index + 1 ) ); ?></span><figure><img src="<?php echo esc_url( nydemo003_asset_url( 'images/generated/' . $nydemo003_project[0] ) ); ?>" alt="" width="900" height="900" loading="lazy"><figcaption><?php echo esc_html( $nydemo003_project[2] ); ?></figcaption></figure><div><h2><?php echo esc_html( $nydemo003_project[1] ); ?></h2><strong><?php echo esc_html( $nydemo003_project[3] ); ?></strong></div></article><?php endforeach; ?>
</div></section><?php get_template_part( 'template-parts/content', 'work-cta' ); ?></main>
<?php get_footer();
