<?php
/**
 * Front-page featured transformation.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--cool">
	<div class="content-wrap">
		<header class="section__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Selected transformation', 'nolan-young-demo-theme-001' ); ?></p>
				<h2><?php esc_html_e( 'Work measured by what changed.', 'nolan-young-demo-theme-001' ); ?></h2>
			</div>
			<p class="section__lede"><?php esc_html_e( 'A fictional enterprise case demonstrates how the theme handles complex stories, product evidence, and measurable outcomes.', 'nolan-young-demo-theme-001' ); ?></p>
		</header>

		<article class="featured-transformation" data-reveal>
			<div class="featured-transformation__product">
				<header>
					<div><i></i><i></i><i></i></div>
					<span><?php esc_html_e( 'Meridian operating platform', 'nolan-young-demo-theme-001' ); ?></span>
					<span>2026 / 01</span>
				</header>
				<div class="featured-transformation__interface">
					<aside aria-hidden="true"><span></span><span></span><span></span><span></span></aside>
					<div class="featured-transformation__canvas">
						<div class="featured-transformation__canvas-top">
							<div><span><?php esc_html_e( 'Program adoption', 'nolan-young-demo-theme-001' ); ?></span><strong>2.4×</strong></div>
							<span><?php esc_html_e( 'Last 90 days', 'nolan-young-demo-theme-001' ); ?></span>
						</div>
						<div class="featured-transformation__line" aria-hidden="true"><i></i></div>
						<div class="featured-transformation__mini-grid">
							<div><span><?php esc_html_e( 'Tasks simplified', 'nolan-young-demo-theme-001' ); ?></span><strong>38</strong></div>
							<div><span><?php esc_html_e( 'Teams aligned', 'nolan-young-demo-theme-001' ); ?></span><strong>07</strong></div>
							<div><span><?php esc_html_e( 'Support change', 'nolan-young-demo-theme-001' ); ?></span><strong>−68%</strong></div>
						</div>
					</div>
				</div>
			</div>

			<div class="featured-transformation__story">
				<div class="featured-transformation__story-top">
					<span><?php esc_html_e( 'Case 01', 'nolan-young-demo-theme-001' ); ?></span>
					<span><?php esc_html_e( 'Strategy · Experience · Platform', 'nolan-young-demo-theme-001' ); ?></span>
				</div>
				<div>
					<h3><?php esc_html_e( 'Making a complex operating model feel clear and actionable.', 'nolan-young-demo-theme-001' ); ?></h3>
					<p><?php esc_html_e( 'A connected service, content, and technology system gave every team one understandable path forward while preserving the controls the organization required.', 'nolan-young-demo-theme-001' ); ?></p>
				</div>
				<dl>
					<div><dt><?php esc_html_e( 'Completion', 'nolan-young-demo-theme-001' ); ?></dt><dd>41% <?php esc_html_e( 'faster', 'nolan-young-demo-theme-001' ); ?></dd></div>
					<div><dt><?php esc_html_e( 'Support demand', 'nolan-young-demo-theme-001' ); ?></dt><dd>68% <?php esc_html_e( 'lower', 'nolan-young-demo-theme-001' ); ?></dd></div>
				</dl>
				<a class="text-link" href="<?php echo esc_url( nydemo001_page_url( 'work' ) ); ?>">
					<?php esc_html_e( 'View the complete case study', 'nolan-young-demo-theme-001' ); ?>
					<span aria-hidden="true">→</span>
				</a>
			</div>
		</article>
	</div>
</section>
