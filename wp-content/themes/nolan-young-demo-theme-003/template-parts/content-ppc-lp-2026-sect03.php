<?php
/**
 * PPC proof dashboard.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--navy ppc-proof" id="proof">
	<div class="content-wrap">
		<header class="section-heading section-heading--split" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Illustrative performance model', 'nolan-young-demo-theme-003' ); ?></p>
				<h2><?php esc_html_e( 'Measure the path to pipeline—not the volume of traffic.', 'nolan-young-demo-theme-003' ); ?></h2>
			</div>
			<p><?php esc_html_e( 'The fictional metrics below demonstrate a balanced operating view across efficiency, experience quality, learning velocity, and commercial value.', 'nolan-young-demo-theme-003' ); ?></p>
		</header>
		<div class="ppc-proof__dashboard" data-reveal>
			<header class="ppc-proof__toolbar">
				<div><i aria-hidden="true"></i><strong><?php esc_html_e( 'Commercial demand view', 'nolan-young-demo-theme-003' ); ?></strong></div>
				<span><?php esc_html_e( 'Sample data / 90 days', 'nolan-young-demo-theme-003' ); ?></span>
			</header>
			<div class="ppc-proof__metrics">
				<article>
					<span><?php esc_html_e( 'Qualified opportunities', 'nolan-young-demo-theme-003' ); ?></span>
					<strong data-metric="38" data-prefix="+" data-suffix="%">+38%</strong>
					<i style="--value: 78%;"></i>
					<small><?php esc_html_e( 'Business quality', 'nolan-young-demo-theme-003' ); ?></small>
				</article>
				<article>
					<span><?php esc_html_e( 'Cost per qualified lead', 'nolan-young-demo-theme-003' ); ?></span>
					<strong data-metric="27" data-prefix="−" data-suffix="%">−27%</strong>
					<i style="--value: 62%;"></i>
					<small><?php esc_html_e( 'Efficiency', 'nolan-young-demo-theme-003' ); ?></small>
				</article>
				<article>
					<span><?php esc_html_e( 'Journey completion', 'nolan-young-demo-theme-003' ); ?></span>
					<strong data-metric="46" data-suffix="%">46%</strong>
					<i style="--value: 70%;"></i>
					<small><?php esc_html_e( 'Experience quality', 'nolan-young-demo-theme-003' ); ?></small>
				</article>
				<article>
					<span><?php esc_html_e( 'Validated learning', 'nolan-young-demo-theme-003' ); ?></span>
					<strong data-metric="21" data-suffix=" days">21 days</strong>
					<i style="--value: 84%;"></i>
					<small><?php esc_html_e( 'Learning velocity', 'nolan-young-demo-theme-003' ); ?></small>
				</article>
			</div>
			<div class="ppc-proof__lower">
				<div class="ppc-proof__chart" aria-hidden="true">
					<header><span>Qualified signal</span><strong>↑ 18.4%</strong></header>
					<div><i style="--h: 22%;"></i><i style="--h: 32%;"></i><i style="--h: 28%;"></i><i style="--h: 46%;"></i><i style="--h: 52%;"></i><i style="--h: 68%;"></i><i style="--h: 78%;"></i><i style="--h: 91%;"></i></div>
					<footer><span>W1</span><span>W4</span><span>W8</span></footer>
				</div>
				<figure class="ppc-proof__quote">
					<blockquote><?php esc_html_e( 'The team finally had one view of what was driving real demand. That changed our landing experience and our investment decisions in the same quarter.', 'nolan-young-demo-theme-003' ); ?></blockquote>
					<figcaption>
						<span aria-hidden="true">VG</span>
						<div>
							<strong><?php esc_html_e( 'Fictional VP Growth', 'nolan-young-demo-theme-003' ); ?></strong>
							<small><?php esc_html_e( 'Enterprise SaaS', 'nolan-young-demo-theme-003' ); ?></small>
						</div>
					</figcaption>
				</figure>
			</div>
			<footer class="ppc-proof__note">
				<span><?php esc_html_e( 'Demonstration', 'nolan-young-demo-theme-003' ); ?></span>
				<p><?php esc_html_e( 'All figures and testimony are fictional and illustrate the theme presentation only.', 'nolan-young-demo-theme-003' ); ?></p>
			</footer>
		</div>
	</div>
</section>
