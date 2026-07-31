<?php
/**
 * Template Name: About Us
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="content" class="editorial-page">
	<header class="editorial-cover editorial-cover--moss">
		<div class="content-wrap editorial-cover__inner">
			<p class="eyebrow"><?php esc_html_e( 'About the atelier', 'nolan-young-demo-theme-002' ); ?></p>
			<h1><?php esc_html_e( 'Independent minds. Shared craft.', 'nolan-young-demo-theme-002' ); ?></h1>
			<p><?php esc_html_e( 'A compact team of strategists, designers, and engineers working close to the people responsible for the outcome.', 'nolan-young-demo-theme-002' ); ?></p>
		</div>
	</header>
	<section id="story" class="editorial-split section">
		<div class="content-wrap editorial-split__inner">
			<figure data-reveal><img src="<?php echo esc_url( nydemo002_asset_url( 'images/generated/atelier-hero.jpg' ) ); ?>" alt="<?php esc_attr_e( 'A creative technology team collaborating around a studio table.', 'nolan-young-demo-theme-002' ); ?>" width="1920" height="1080" loading="lazy"><figcaption><?php esc_html_e( 'Different disciplines, one table.', 'nolan-young-demo-theme-002' ); ?></figcaption></figure>
			<div data-reveal><p class="eyebrow"><?php esc_html_e( 'Our premise', 'nolan-young-demo-theme-002' ); ?></p><h2><?php esc_html_e( 'The best digital work feels considered—not manufactured.', 'nolan-young-demo-theme-002' ); ?></h2><p><?php esc_html_e( 'We keep the team senior, the work visible, and the decisions close to their consequences. That produces clearer thinking and leaves less room for theatre.', 'nolan-young-demo-theme-002' ); ?></p></div>
		</div>
	</section>
	<section id="team" class="manifesto section"><div class="content-wrap"><p class="eyebrow"><?php esc_html_e( 'Studio principles', 'nolan-young-demo-theme-002' ); ?></p><ol><li><span>01</span><?php esc_html_e( 'Listen before prescribing.', 'nolan-young-demo-theme-002' ); ?></li><li><span>02</span><?php esc_html_e( 'Make choices inspectable.', 'nolan-young-demo-theme-002' ); ?></li><li><span>03</span><?php esc_html_e( 'Build for ownership.', 'nolan-young-demo-theme-002' ); ?></li><li><span>04</span><?php esc_html_e( 'Leave systems stronger.', 'nolan-young-demo-theme-002' ); ?></li></ol></div></section>
	<?php get_template_part( 'template-parts/content', 'about-us-cta' ); ?>
</main>
<?php get_footer();
