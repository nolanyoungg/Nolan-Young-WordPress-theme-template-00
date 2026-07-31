<?php
/**
 * PPC landing page hero.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="ppc-hero">
	<div class="content-wrap ppc-hero__layout">
		<div class="ppc-hero__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Demand performance system / 2026', 'nolan-young-demo-theme-001' ); ?></p>
			<h1><?php esc_html_e( 'Make the click the start of the learning.', 'nolan-young-demo-theme-001' ); ?></h1>
			<p class="hero__lede"><?php esc_html_e( 'One connected landing experience, measurement model, and optimization rhythm for enterprise teams that need qualified momentum—not cheaper traffic.', 'nolan-young-demo-theme-001' ); ?></p>
			<div class="button-row">
				<a class="button button--primary" href="#campaign-fit">
					<?php esc_html_e( 'Assess campaign fit', 'nolan-young-demo-theme-001' ); ?>
					<span aria-hidden="true">→</span>
				</a>
				<a class="button button--quiet" href="#proof"><?php esc_html_e( 'Inspect the model', 'nolan-young-demo-theme-001' ); ?></a>
			</div>
			<ul class="ppc-hero__trust" aria-label="<?php esc_attr_e( 'Campaign system benefits', 'nolan-young-demo-theme-001' ); ?>">
				<li><span>01</span><?php esc_html_e( 'Message continuity', 'nolan-young-demo-theme-001' ); ?></li>
				<li><span>02</span><?php esc_html_e( 'Qualified signal', 'nolan-young-demo-theme-001' ); ?></li>
				<li><span>03</span><?php esc_html_e( 'Faster learning', 'nolan-young-demo-theme-001' ); ?></li>
			</ul>
		</div>

		<div class="demand-console" data-reveal aria-label="<?php esc_attr_e( 'Illustrative campaign performance dashboard', 'nolan-young-demo-theme-001' ); ?>">
			<header class="demand-console__header">
				<div>
					<i aria-hidden="true"></i>
					<strong><?php esc_html_e( 'Demand OS', 'nolan-young-demo-theme-001' ); ?></strong>
				</div>
				<span><?php esc_html_e( 'Illustrative data', 'nolan-young-demo-theme-001' ); ?></span>
			</header>
			<div class="demand-console__nav" aria-hidden="true">
				<span class="is-active">Overview</span>
				<span>Journey</span>
				<span>Signals</span>
			</div>
			<div class="demand-console__primary">
				<div>
					<span><?php esc_html_e( 'Qualified opportunity rate', 'nolan-young-demo-theme-001' ); ?></span>
					<strong data-metric="38" data-prefix="+" data-suffix="%">+38%</strong>
					<small><?php esc_html_e( 'Compared with prior journey', 'nolan-young-demo-theme-001' ); ?></small>
				</div>
				<div class="demand-console__spark" aria-hidden="true">
					<svg viewBox="0 0 260 100" preserveAspectRatio="none">
						<path d="M0 82C30 77 47 86 70 64S111 70 139 45 176 56 198 32 230 31 260 12" />
						<path class="area" d="M0 82C30 77 47 86 70 64S111 70 139 45 176 56 198 32 230 31 260 12V100H0Z" />
					</svg>
					<div><span>W1</span><span>W3</span><span>W6</span></div>
				</div>
			</div>
			<div class="demand-console__journey">
				<header>
					<span><?php esc_html_e( 'Journey quality', 'nolan-young-demo-theme-001' ); ?></span>
					<small><?php esc_html_e( 'Last 30 days', 'nolan-young-demo-theme-001' ); ?></small>
				</header>
				<ol>
					<li><span><?php esc_html_e( 'Intent match', 'nolan-young-demo-theme-001' ); ?></span><i style="--value: 88%;"></i><strong>88</strong></li>
					<li><span><?php esc_html_e( 'Proof depth', 'nolan-young-demo-theme-001' ); ?></span><i style="--value: 73%;"></i><strong>73</strong></li>
					<li><span><?php esc_html_e( 'Decision clarity', 'nolan-young-demo-theme-001' ); ?></span><i style="--value: 81%;"></i><strong>81</strong></li>
				</ol>
			</div>
			<footer class="demand-console__footer">
				<div><strong data-metric="27" data-prefix="−" data-suffix="%">−27%</strong><span><?php esc_html_e( 'wasted spend', 'nolan-young-demo-theme-001' ); ?></span></div>
				<div><strong data-metric="2.4" data-suffix="×">2.4×</strong><span><?php esc_html_e( 'learning velocity', 'nolan-young-demo-theme-001' ); ?></span></div>
				<div><strong data-metric="21" data-suffix="d">21d</strong><span><?php esc_html_e( 'validated signal', 'nolan-young-demo-theme-001' ); ?></span></div>
			</footer>
		</div>
	</div>
</section>
