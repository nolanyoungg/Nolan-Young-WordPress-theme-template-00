<?php
/**
 * Front-page command-center hero.
 *
 * @package NolanYoungThemeTemplate99Master
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero hero--home">
	<div class="content-wrap home-hero">
		<div class="home-hero__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Enterprise strategy · Experience · Engineering', 'nolan-young-theme-template-99-master' ); ?></p>
			<h1><?php esc_html_e( 'Move important digital work forward with confidence.', 'nolan-young-theme-template-99-master' ); ?></h1>
			<p class="hero__lede"><?php esc_html_e( 'A senior delivery team for organizations that need sharper decisions, better customer experiences, and technology built to last.', 'nolan-young-theme-template-99-master' ); ?></p>
			<div class="button-row">
				<?php nytt99_button( __( 'Start a project', 'nolan-young-theme-template-99-master' ) ); ?>
				<a class="button button--quiet" href="<?php echo esc_url( nytt99_page_url( 'work' ) ); ?>">
					<span><?php esc_html_e( 'View the work', 'nolan-young-theme-template-99-master' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
			</div>
			<div class="home-hero__proof">
				<div>
					<strong>12+</strong>
					<span><?php esc_html_e( 'enterprise launches', 'nolan-young-theme-template-99-master' ); ?></span>
				</div>
				<div>
					<strong>96%</strong>
					<span><?php esc_html_e( 'milestones delivered', 'nolan-young-theme-template-99-master' ); ?></span>
				</div>
				<div>
					<strong>4.9/5</strong>
					<span><?php esc_html_e( 'partner satisfaction', 'nolan-young-theme-template-99-master' ); ?></span>
				</div>
			</div>
		</div>

		<div class="delivery-console" data-reveal>
			<header class="delivery-console__header">
				<div>
					<span class="delivery-console__mark" aria-hidden="true">NY</span>
					<div>
						<strong><?php esc_html_e( 'Delivery command center', 'nolan-young-theme-template-99-master' ); ?></strong>
						<span><?php esc_html_e( 'Transformation program / live view', 'nolan-young-theme-template-99-master' ); ?></span>
					</div>
				</div>
				<span class="delivery-console__status"><i aria-hidden="true"></i><?php esc_html_e( 'On track', 'nolan-young-theme-template-99-master' ); ?></span>
			</header>
			<div class="delivery-console__body">
				<div class="delivery-console__signal">
					<div class="delivery-console__signal-top">
						<span><?php esc_html_e( 'Momentum index', 'nolan-young-theme-template-99-master' ); ?></span>
						<strong>+42%</strong>
					</div>
					<div class="delivery-console__chart" aria-hidden="true">
						<span style="--value: 28%"></span>
						<span style="--value: 38%"></span>
						<span style="--value: 46%"></span>
						<span style="--value: 58%"></span>
						<span style="--value: 71%"></span>
						<span style="--value: 86%"></span>
					</div>
					<div class="delivery-console__axis"><span>Discover</span><span>Deliver</span></div>
				</div>
				<div class="delivery-console__metrics">
					<div>
						<span><?php esc_html_e( 'Active decisions', 'nolan-young-theme-template-99-master' ); ?></span>
						<strong>04</strong>
						<small><?php esc_html_e( '2 cleared this week', 'nolan-young-theme-template-99-master' ); ?></small>
					</div>
					<div>
						<span><?php esc_html_e( 'Experience score', 'nolan-young-theme-template-99-master' ); ?></span>
						<strong>91</strong>
						<small><?php esc_html_e( '+18 from baseline', 'nolan-young-theme-template-99-master' ); ?></small>
					</div>
				</div>
				<div class="delivery-console__roadmap">
					<span><?php esc_html_e( 'Current delivery path', 'nolan-young-theme-template-99-master' ); ?></span>
					<ol>
						<li class="is-complete"><i aria-hidden="true"></i><span><?php esc_html_e( 'Frame', 'nolan-young-theme-template-99-master' ); ?></span></li>
						<li class="is-complete"><i aria-hidden="true"></i><span><?php esc_html_e( 'Prototype', 'nolan-young-theme-template-99-master' ); ?></span></li>
						<li class="is-current"><i aria-hidden="true"></i><span><?php esc_html_e( 'Build', 'nolan-young-theme-template-99-master' ); ?></span></li>
						<li><i aria-hidden="true"></i><span><?php esc_html_e( 'Improve', 'nolan-young-theme-template-99-master' ); ?></span></li>
					</ol>
				</div>
			</div>
			<footer class="delivery-console__footer">
				<span><?php esc_html_e( 'Next decision', 'nolan-young-theme-template-99-master' ); ?></span>
				<strong><?php esc_html_e( 'Approve accessible component system', 'nolan-young-theme-template-99-master' ); ?></strong>
				<span>02:14:36</span>
			</footer>
		</div>
	</div>
</section>
<div class="trust-strip">
	<div class="content-wrap trust-strip__inner">
		<p><?php esc_html_e( 'Built for teams navigating real complexity', 'nolan-young-theme-template-99-master' ); ?></p>
		<ul aria-label="<?php esc_attr_e( 'Example client sectors', 'nolan-young-theme-template-99-master' ); ?>">
			<li><?php esc_html_e( 'Financial services', 'nolan-young-theme-template-99-master' ); ?></li>
			<li><?php esc_html_e( 'Healthcare', 'nolan-young-theme-template-99-master' ); ?></li>
			<li><?php esc_html_e( 'Technology', 'nolan-young-theme-template-99-master' ); ?></li>
			<li><?php esc_html_e( 'Public sector', 'nolan-young-theme-template-99-master' ); ?></li>
		</ul>
	</div>
</div>
