<?php
/**
 * Services solution-map hero.
 *
 * @package NolanYoungThemeTemplate99Master
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero hero--services">
	<div class="content-wrap services-hero">
		<div class="services-hero__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Four connected service tracks', 'nolan-young-theme-template-99-master' ); ?></p>
			<h1><?php esc_html_e( 'Solve the business problem, not just the brief.', 'nolan-young-theme-template-99-master' ); ?></h1>
			<p class="hero__lede"><?php esc_html_e( 'Connect strategy, customer experience, engineering, and continuous improvement around one measurable direction.', 'nolan-young-theme-template-99-master' ); ?></p>
			<div class="button-row">
				<?php nytt99_button( __( 'Discuss the challenge', 'nolan-young-theme-template-99-master' ) ); ?>
				<a class="button button--quiet" href="#capabilities"><span><?php esc_html_e( 'View capabilities', 'nolan-young-theme-template-99-master' ); ?></span><span aria-hidden="true">↓</span></a>
			</div>
			<div class="services-hero__assurance">
				<span><?php esc_html_e( 'Senior team throughout', 'nolan-young-theme-template-99-master' ); ?></span>
				<span><?php esc_html_e( 'Accessible by default', 'nolan-young-theme-template-99-master' ); ?></span>
				<span><?php esc_html_e( 'Evidence-led decisions', 'nolan-young-theme-template-99-master' ); ?></span>
			</div>
		</div>

		<div class="solution-map" data-reveal>
			<header>
				<span><?php esc_html_e( 'Solution architecture', 'nolan-young-theme-template-99-master' ); ?></span>
				<strong><?php esc_html_e( 'One measurable direction', 'nolan-young-theme-template-99-master' ); ?></strong>
			</header>
			<div class="solution-map__canvas">
				<div class="solution-map__center">
					<span><?php esc_html_e( 'Business outcome', 'nolan-young-theme-template-99-master' ); ?></span>
					<strong><?php esc_html_e( 'Controlled momentum', 'nolan-young-theme-template-99-master' ); ?></strong>
				</div>
				<div class="solution-map__node solution-map__node--one">
					<span>01</span>
					<strong><?php esc_html_e( 'Direction', 'nolan-young-theme-template-99-master' ); ?></strong>
					<small><?php esc_html_e( 'Evidence and alignment', 'nolan-young-theme-template-99-master' ); ?></small>
				</div>
				<div class="solution-map__node solution-map__node--two">
					<span>02</span>
					<strong><?php esc_html_e( 'Experience', 'nolan-young-theme-template-99-master' ); ?></strong>
					<small><?php esc_html_e( 'Journeys and interfaces', 'nolan-young-theme-template-99-master' ); ?></small>
				</div>
				<div class="solution-map__node solution-map__node--three">
					<span>03</span>
					<strong><?php esc_html_e( 'Engineering', 'nolan-young-theme-template-99-master' ); ?></strong>
					<small><?php esc_html_e( 'Platforms and integrations', 'nolan-young-theme-template-99-master' ); ?></small>
				</div>
				<div class="solution-map__node solution-map__node--four">
					<span>04</span>
					<strong><?php esc_html_e( 'Stewardship', 'nolan-young-theme-template-99-master' ); ?></strong>
					<small><?php esc_html_e( 'Performance and growth', 'nolan-young-theme-template-99-master' ); ?></small>
				</div>
			</div>
			<footer>
				<span><?php esc_html_e( 'Entry point', 'nolan-young-theme-template-99-master' ); ?></span>
				<strong><?php esc_html_e( 'Start wherever progress is blocked', 'nolan-young-theme-template-99-master' ); ?></strong>
				<span>→</span>
			</footer>
		</div>
	</div>
</section>
