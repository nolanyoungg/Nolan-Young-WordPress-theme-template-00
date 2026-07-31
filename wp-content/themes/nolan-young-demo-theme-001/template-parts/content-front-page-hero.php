<?php
/**
 * Front-page command-center hero.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero hero--home">
	<div class="content-wrap home-hero">
		<div class="home-hero__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Enterprise strategy · Experience · Engineering', 'nolan-young-demo-theme-001' ); ?></p>
			<h1><?php esc_html_e( 'Move important digital work forward with confidence.', 'nolan-young-demo-theme-001' ); ?></h1>
			<p class="hero__lede"><?php esc_html_e( 'A senior delivery team for organizations that need sharper decisions, better customer experiences, and technology built to last.', 'nolan-young-demo-theme-001' ); ?></p>
			<div class="button-row">
				<?php nydemo001_button( __( 'Start a project', 'nolan-young-demo-theme-001' ) ); ?>
				<a class="button button--quiet" href="<?php echo esc_url( nydemo001_page_url( 'work' ) ); ?>">
					<span><?php esc_html_e( 'View the work', 'nolan-young-demo-theme-001' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
			</div>
			<div class="home-hero__proof">
				<div>
					<strong>12+</strong>
					<span><?php esc_html_e( 'enterprise launches', 'nolan-young-demo-theme-001' ); ?></span>
				</div>
				<div>
					<strong>96%</strong>
					<span><?php esc_html_e( 'milestones delivered', 'nolan-young-demo-theme-001' ); ?></span>
				</div>
				<div>
					<strong>4.9/5</strong>
					<span><?php esc_html_e( 'partner satisfaction', 'nolan-young-demo-theme-001' ); ?></span>
				</div>
			</div>
		</div>

		<div class="delivery-console" data-reveal>
			<header class="delivery-console__header">
				<div>
					<span class="delivery-console__mark" aria-hidden="true">NY</span>
					<div>
						<strong><?php esc_html_e( 'Delivery command center', 'nolan-young-demo-theme-001' ); ?></strong>
						<span><?php esc_html_e( 'Transformation program / live view', 'nolan-young-demo-theme-001' ); ?></span>
					</div>
				</div>
				<span class="delivery-console__status"><i aria-hidden="true"></i><?php esc_html_e( 'On track', 'nolan-young-demo-theme-001' ); ?></span>
			</header>
			<div class="delivery-console__body">
				<div class="delivery-console__signal">
					<div class="delivery-console__signal-top">
						<span><?php esc_html_e( 'Momentum index', 'nolan-young-demo-theme-001' ); ?></span>
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
						<span><?php esc_html_e( 'Active decisions', 'nolan-young-demo-theme-001' ); ?></span>
						<strong>04</strong>
						<small><?php esc_html_e( '2 cleared this week', 'nolan-young-demo-theme-001' ); ?></small>
					</div>
					<div>
						<span><?php esc_html_e( 'Experience score', 'nolan-young-demo-theme-001' ); ?></span>
						<strong>91</strong>
						<small><?php esc_html_e( '+18 from baseline', 'nolan-young-demo-theme-001' ); ?></small>
					</div>
				</div>
				<div class="delivery-console__roadmap">
					<span><?php esc_html_e( 'Current delivery path', 'nolan-young-demo-theme-001' ); ?></span>
					<ol>
						<li class="is-complete"><i aria-hidden="true"></i><span><?php esc_html_e( 'Frame', 'nolan-young-demo-theme-001' ); ?></span></li>
						<li class="is-complete"><i aria-hidden="true"></i><span><?php esc_html_e( 'Prototype', 'nolan-young-demo-theme-001' ); ?></span></li>
						<li class="is-current"><i aria-hidden="true"></i><span><?php esc_html_e( 'Build', 'nolan-young-demo-theme-001' ); ?></span></li>
						<li><i aria-hidden="true"></i><span><?php esc_html_e( 'Improve', 'nolan-young-demo-theme-001' ); ?></span></li>
					</ol>
				</div>
			</div>
			<footer class="delivery-console__footer">
				<span><?php esc_html_e( 'Next decision', 'nolan-young-demo-theme-001' ); ?></span>
				<strong><?php esc_html_e( 'Approve accessible component system', 'nolan-young-demo-theme-001' ); ?></strong>
				<span>02:14:36</span>
			</footer>
		</div>
	</div>
</section>
<div class="trust-strip">
	<div class="content-wrap trust-strip__inner">
		<p><?php esc_html_e( 'Built for teams navigating real complexity', 'nolan-young-demo-theme-001' ); ?></p>
		<ul aria-label="<?php esc_attr_e( 'Example client sectors', 'nolan-young-demo-theme-001' ); ?>">
			<li><?php esc_html_e( 'Financial services', 'nolan-young-demo-theme-001' ); ?></li>
			<li><?php esc_html_e( 'Healthcare', 'nolan-young-demo-theme-001' ); ?></li>
			<li><?php esc_html_e( 'Technology', 'nolan-young-demo-theme-001' ); ?></li>
			<li><?php esc_html_e( 'Public sector', 'nolan-young-demo-theme-001' ); ?></li>
		</ul>
	</div>
</div>
