<?php
/**
 * Services solution-map hero.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero hero--services">
	<div class="content-wrap services-hero">
		<div class="services-hero__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Four connected service tracks', 'nolan-young-demo-theme-001' ); ?></p>
			<h1><?php esc_html_e( 'Solve the business problem, not just the brief.', 'nolan-young-demo-theme-001' ); ?></h1>
			<p class="hero__lede"><?php esc_html_e( 'Connect strategy, customer experience, engineering, and continuous improvement around one measurable direction.', 'nolan-young-demo-theme-001' ); ?></p>
			<div class="button-row">
				<?php nydemo001_button( __( 'Discuss the challenge', 'nolan-young-demo-theme-001' ) ); ?>
				<a class="button button--quiet" href="#capabilities"><span><?php esc_html_e( 'View capabilities', 'nolan-young-demo-theme-001' ); ?></span><span aria-hidden="true">↓</span></a>
			</div>
			<div class="services-hero__assurance">
				<span><?php esc_html_e( 'Senior team throughout', 'nolan-young-demo-theme-001' ); ?></span>
				<span><?php esc_html_e( 'Accessible by default', 'nolan-young-demo-theme-001' ); ?></span>
				<span><?php esc_html_e( 'Evidence-led decisions', 'nolan-young-demo-theme-001' ); ?></span>
			</div>
		</div>

		<div class="solution-map" data-reveal>
			<header>
				<span><?php esc_html_e( 'Solution architecture', 'nolan-young-demo-theme-001' ); ?></span>
				<strong><?php esc_html_e( 'One measurable direction', 'nolan-young-demo-theme-001' ); ?></strong>
			</header>
			<div class="solution-map__canvas">
				<div class="solution-map__center">
					<span><?php esc_html_e( 'Business outcome', 'nolan-young-demo-theme-001' ); ?></span>
					<strong><?php esc_html_e( 'Controlled momentum', 'nolan-young-demo-theme-001' ); ?></strong>
				</div>
				<div class="solution-map__node solution-map__node--one">
					<span>01</span>
					<strong><?php esc_html_e( 'Direction', 'nolan-young-demo-theme-001' ); ?></strong>
					<small><?php esc_html_e( 'Evidence and alignment', 'nolan-young-demo-theme-001' ); ?></small>
				</div>
				<div class="solution-map__node solution-map__node--two">
					<span>02</span>
					<strong><?php esc_html_e( 'Experience', 'nolan-young-demo-theme-001' ); ?></strong>
					<small><?php esc_html_e( 'Journeys and interfaces', 'nolan-young-demo-theme-001' ); ?></small>
				</div>
				<div class="solution-map__node solution-map__node--three">
					<span>03</span>
					<strong><?php esc_html_e( 'Engineering', 'nolan-young-demo-theme-001' ); ?></strong>
					<small><?php esc_html_e( 'Platforms and integrations', 'nolan-young-demo-theme-001' ); ?></small>
				</div>
				<div class="solution-map__node solution-map__node--four">
					<span>04</span>
					<strong><?php esc_html_e( 'Stewardship', 'nolan-young-demo-theme-001' ); ?></strong>
					<small><?php esc_html_e( 'Performance and growth', 'nolan-young-demo-theme-001' ); ?></small>
				</div>
			</div>
			<footer>
				<span><?php esc_html_e( 'Entry point', 'nolan-young-demo-theme-001' ); ?></span>
				<strong><?php esc_html_e( 'Start wherever progress is blocked', 'nolan-young-demo-theme-001' ); ?></strong>
				<span>→</span>
			</footer>
		</div>
	</div>
</section>
