<?php
/**
 * Contact page hero.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;

$admin_email = antispambot( get_option( 'admin_email' ) );
?>
<section class="contact-hero">
	<div class="content-wrap contact-hero__layout">
		<div class="contact-hero__content" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Senior team / direct response', 'nolan-young-demo-theme-003' ); ?></p>
			<h1><?php esc_html_e( 'Bring us the problem behind the brief.', 'nolan-young-demo-theme-003' ); ?></h1>
			<p class="hero__lede">
				<?php esc_html_e( 'Share the pressure, the people affected, and the outcome that matters. We will respond with a point of view and a practical next move—not an automated sales sequence.', 'nolan-young-demo-theme-003' ); ?>
			</p>
			<div class="button-row">
				<a class="button button--primary" href="#project-brief">
					<?php esc_html_e( 'Shape the brief', 'nolan-young-demo-theme-003' ); ?>
					<span aria-hidden="true">↓</span>
				</a>
				<a class="button button--quiet" href="mailto:<?php echo esc_attr( $admin_email ); ?>">
					<?php esc_html_e( 'Email directly', 'nolan-young-demo-theme-003' ); ?>
				</a>
			</div>
			<ul class="contact-hero__proof" aria-label="<?php esc_attr_e( 'What to expect', 'nolan-young-demo-theme-003' ); ?>">
				<li><strong><?php esc_html_e( 'Human', 'nolan-young-demo-theme-003' ); ?></strong><span><?php esc_html_e( 'Senior review', 'nolan-young-demo-theme-003' ); ?></span></li>
				<li><strong><?php esc_html_e( 'Useful', 'nolan-young-demo-theme-003' ); ?></strong><span><?php esc_html_e( 'A clear response', 'nolan-young-demo-theme-003' ); ?></span></li>
				<li><strong><?php esc_html_e( 'Private', 'nolan-young-demo-theme-003' ); ?></strong><span><?php esc_html_e( 'No mailing list', 'nolan-young-demo-theme-003' ); ?></span></li>
			</ul>
		</div>

		<aside class="contact-desk" data-reveal aria-label="<?php esc_attr_e( 'Project availability overview', 'nolan-young-demo-theme-003' ); ?>">
			<header class="contact-desk__header">
				<div>
					<span class="availability-dot" aria-hidden="true"></span>
					<strong><?php esc_html_e( 'Studio desk', 'nolan-young-demo-theme-003' ); ?></strong>
				</div>
				<small><?php esc_html_e( 'NY / 09:42', 'nolan-young-demo-theme-003' ); ?></small>
			</header>
			<div class="contact-desk__signal">
				<p><?php esc_html_e( 'Next discovery window', 'nolan-young-demo-theme-003' ); ?></p>
				<strong><?php esc_html_e( 'Now booking', 'nolan-young-demo-theme-003' ); ?></strong>
				<span><?php esc_html_e( 'Two focused engagements available', 'nolan-young-demo-theme-003' ); ?></span>
			</div>
			<div class="contact-desk__route" aria-hidden="true">
				<span>01</span>
				<i></i>
				<span>02</span>
				<i></i>
				<span>03</span>
			</div>
			<dl class="contact-desk__facts">
				<div>
					<dt><?php esc_html_e( 'Typical response', 'nolan-young-demo-theme-003' ); ?></dt>
					<dd><?php esc_html_e( 'Within 2 business days', 'nolan-young-demo-theme-003' ); ?></dd>
				</div>
				<div>
					<dt><?php esc_html_e( 'Best fit', 'nolan-young-demo-theme-003' ); ?></dt>
					<dd><?php esc_html_e( 'Complex digital change', 'nolan-young-demo-theme-003' ); ?></dd>
				</div>
				<div>
					<dt><?php esc_html_e( 'First conversation', 'nolan-young-demo-theme-003' ); ?></dt>
					<dd><?php esc_html_e( '30 focused minutes', 'nolan-young-demo-theme-003' ); ?></dd>
				</div>
			</dl>
			<footer class="contact-desk__footer">
				<span><?php esc_html_e( 'No pitch deck required', 'nolan-young-demo-theme-003' ); ?></span>
				<i aria-hidden="true">↗</i>
			</footer>
		</aside>
	</div>
</section>
