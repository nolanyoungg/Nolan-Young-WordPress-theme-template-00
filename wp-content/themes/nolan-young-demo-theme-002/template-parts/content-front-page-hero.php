<?php
/**
 * Front-page editorial hero.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="atelier-hero">
	<div class="atelier-hero__image" aria-hidden="true">
		<img src="<?php echo esc_url( nydemo002_asset_url( 'images/generated/atelier-hero.jpg' ) ); ?>" alt="" width="1920" height="1080" fetchpriority="high">
	</div>
	<div class="content-wrap atelier-hero__frame">
		<div class="atelier-hero__card" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Independent digital atelier · Est. 2026', 'nolan-young-demo-theme-002' ); ?></p>
			<h1><?php esc_html_e( 'Digital work with a human point of view.', 'nolan-young-demo-theme-002' ); ?></h1>
			<p class="atelier-hero__lede"><?php esc_html_e( 'We pair strategy, expressive design, and resilient engineering to make complex organizations feel clear, useful, and unmistakably themselves.', 'nolan-young-demo-theme-002' ); ?></p>
			<div class="button-row">
				<?php nydemo002_button( __( 'Begin a conversation', 'nolan-young-demo-theme-002' ) ); ?>
				<a class="text-link" href="<?php echo esc_url( nydemo002_page_url( 'work' ) ); ?>">
					<?php esc_html_e( 'Browse selected work', 'nolan-young-demo-theme-002' ); ?><span aria-hidden="true">↗</span>
				</a>
			</div>
		</div>
		<div class="atelier-hero__note" data-reveal>
			<span><?php esc_html_e( 'Currently exploring', 'nolan-young-demo-theme-002' ); ?></span>
			<strong><?php esc_html_e( 'More thoughtful ways for people and technology to work together.', 'nolan-young-demo-theme-002' ); ?></strong>
		</div>
	</div>
</section>
<aside class="studio-ticker" aria-label="<?php esc_attr_e( 'Studio disciplines', 'nolan-young-demo-theme-002' ); ?>">
	<div class="content-wrap">
		<span><?php esc_html_e( 'Strategy', 'nolan-young-demo-theme-002' ); ?></span>
		<span><?php esc_html_e( 'Experience', 'nolan-young-demo-theme-002' ); ?></span>
		<span><?php esc_html_e( 'WordPress', 'nolan-young-demo-theme-002' ); ?></span>
		<span><?php esc_html_e( 'Search', 'nolan-young-demo-theme-002' ); ?></span>
		<span><?php esc_html_e( 'Responsible AI', 'nolan-young-demo-theme-002' ); ?></span>
	</div>
</aside>
