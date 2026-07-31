<?php
/**
 * Front-page case-note feature.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="case-note section">
	<div class="content-wrap case-note__layout">
		<figure class="case-note__portrait" data-reveal>
			<img src="<?php echo esc_url( nydemo002_asset_url( 'images/generated/service-analytics.jpg' ) ); ?>" alt="" width="900" height="900" loading="lazy">
			<figcaption><?php esc_html_e( 'Field note 04 · Measurement made tangible', 'nolan-young-demo-theme-002' ); ?></figcaption>
		</figure>
		<article class="case-note__story" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'A selected outcome', 'nolan-young-demo-theme-002' ); ?></p>
			<h2><?php esc_html_e( 'From scattered signals to one useful story.', 'nolan-young-demo-theme-002' ); ?></h2>
			<p><?php esc_html_e( 'A fictional growth team replaced dashboard clutter with a focused measurement practice—making priorities visible and weekly decisions faster.', 'nolan-young-demo-theme-002' ); ?></p>
			<dl>
				<div><dt><?php esc_html_e( 'Reporting time', 'nolan-young-demo-theme-002' ); ?></dt><dd>−64%</dd></div>
				<div><dt><?php esc_html_e( 'Decision confidence', 'nolan-young-demo-theme-002' ); ?></dt><dd>+31%</dd></div>
				<div><dt><?php esc_html_e( 'Shared measures', 'nolan-young-demo-theme-002' ); ?></dt><dd>08</dd></div>
			</dl>
			<a class="text-link" href="<?php echo esc_url( nydemo002_page_url( 'work' ) ); ?>"><?php esc_html_e( 'Read the field notes', 'nolan-young-demo-theme-002' ); ?><span aria-hidden="true">↗</span></a>
		</article>
	</div>
</section>
