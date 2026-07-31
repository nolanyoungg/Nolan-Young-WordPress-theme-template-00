<?php
/**
 * 404 recovery hero.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="error-hero">
	<div class="content-wrap error-hero__layout">
		<div class="error-hero__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( '404 / Route unavailable', 'nolan-young-demo-theme-002' ); ?></p>
			<h1><?php esc_html_e( 'Wrong turn. Strong recovery.', 'nolan-young-demo-theme-002' ); ?></h1>
			<p class="hero__lede"><?php esc_html_e( 'The page may have moved, the address may be incomplete, or the idea may now live somewhere more useful. Search the site or choose a verified route below.', 'nolan-young-demo-theme-002' ); ?></p>
			<div class="error-hero__search">
				<span><?php esc_html_e( 'Search the site', 'nolan-young-demo-theme-002' ); ?></span>
				<?php get_search_form(); ?>
			</div>
			<div class="error-hero__quick">
				<span><?php esc_html_e( 'Quick route', 'nolan-young-demo-theme-002' ); ?></span>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'nolan-young-demo-theme-002' ); ?></a>
				<a href="<?php echo esc_url( nydemo002_page_url( 'services' ) ); ?>"><?php esc_html_e( 'Services', 'nolan-young-demo-theme-002' ); ?></a>
				<a href="<?php echo esc_url( nydemo002_page_url( 'contact-us' ) ); ?>"><?php esc_html_e( 'Contact', 'nolan-young-demo-theme-002' ); ?></a>
			</div>
		</div>
		<div class="route-console" data-reveal role="img" aria-label="<?php esc_attr_e( 'Illustrative route recovery interface', 'nolan-young-demo-theme-002' ); ?>">
			<header>
				<div><i></i><i></i><i></i></div>
				<span>route-recovery.log</span>
				<small><?php esc_html_e( 'System ready', 'nolan-young-demo-theme-002' ); ?></small>
			</header>
			<div class="route-console__code">
				<span>ERROR_CODE</span>
				<strong>404</strong>
				<p><i>requested_route</i><b>unavailable</b></p>
				<p><i>recovery_index</i><b>04 destinations</b></p>
				<p><i>search_status</i><b>ready</b></p>
			</div>
			<div class="route-console__map">
				<div class="is-missing"><span>?</span><small><?php esc_html_e( 'Missing', 'nolan-young-demo-theme-002' ); ?></small></div>
				<i></i>
				<div><span>01</span><small><?php esc_html_e( 'Home', 'nolan-young-demo-theme-002' ); ?></small></div>
				<i></i>
				<div><span>02</span><small><?php esc_html_e( 'Explore', 'nolan-young-demo-theme-002' ); ?></small></div>
			</div>
			<footer>
				<span><?php esc_html_e( 'Recovery status', 'nolan-young-demo-theme-002' ); ?></span>
				<strong><?php esc_html_e( 'Routes verified', 'nolan-young-demo-theme-002' ); ?></strong>
			</footer>
		</div>
	</div>
</section>
