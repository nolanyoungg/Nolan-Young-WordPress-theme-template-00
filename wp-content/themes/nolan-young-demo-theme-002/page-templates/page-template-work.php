<?php
/**
 * Template Name: Work
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

$nydemo002_cases = array(
	array( __( 'Publishing platform', 'nolan-young-demo-theme-002' ), __( 'A fragmented publishing estate becomes one calm editorial system.', 'nolan-young-demo-theme-002' ), 'service-web.jpg', '41%' ),
	array( __( 'Search practice', 'nolan-young-demo-theme-002' ), __( 'A useful content model turns expertise into sustained discovery.', 'nolan-young-demo-theme-002' ), 'service-seo.jpg', '2.8×' ),
	array( __( 'Measurement studio', 'nolan-young-demo-theme-002' ), __( 'One shared story replaces a tangle of competing dashboards.', 'nolan-young-demo-theme-002' ), 'service-analytics.jpg', '−64%' ),
	array( __( 'Internal assistant', 'nolan-young-demo-theme-002' ), __( 'A guarded AI workflow gives specialists more time for judgment.', 'nolan-young-demo-theme-002' ), 'service-ai.jpg', '11h' ),
);
get_header();
?>
<main id="content" class="editorial-page">
	<header class="editorial-cover editorial-cover--plum"><div class="content-wrap editorial-cover__inner"><p class="eyebrow"><?php esc_html_e( 'Selected work · Fictional cases', 'nolan-young-demo-theme-002' ); ?></p><h1><?php esc_html_e( 'Evidence, arranged as stories.', 'nolan-young-demo-theme-002' ); ?></h1><p><?php esc_html_e( 'What changed, why it mattered, and the craft that connected the two.', 'nolan-young-demo-theme-002' ); ?></p></div></header>
	<section id="project-library" class="work-folio section"><div class="content-wrap work-folio__grid">
		<?php foreach ( $nydemo002_cases as $nydemo002_index => $nydemo002_case ) : ?>
			<article<?php echo 0 === $nydemo002_index ? ' id="flagship-case"' : ''; ?> data-reveal><img src="<?php echo esc_url( nydemo002_asset_url( 'images/generated/' . $nydemo002_case[2] ) ); ?>" alt="" width="900" height="900" loading="lazy"><div><span><?php echo esc_html( sprintf( '%02d', $nydemo002_index + 1 ) ); ?></span><h2><?php echo esc_html( $nydemo002_case[0] ); ?></h2><p><?php echo esc_html( $nydemo002_case[1] ); ?></p><strong><?php echo esc_html( $nydemo002_case[3] ); ?></strong></div></article>
		<?php endforeach; ?>
	</div></section>
	<?php get_template_part( 'template-parts/content', 'work-cta' ); ?>
</main>
<?php get_footer();
