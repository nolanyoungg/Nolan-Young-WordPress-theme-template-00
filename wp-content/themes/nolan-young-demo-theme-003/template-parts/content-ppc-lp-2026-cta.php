<?php
/**
 * PPC conversion call to action.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--cream ppc-conversion" id="campaign-fit">
	<div class="content-wrap">
		<div class="ppc-conversion__panel" data-reveal>
			<div class="ppc-conversion__score" aria-hidden="true">
				<span><?php esc_html_e( 'FIT', 'nolan-young-demo-theme-003' ); ?></span>
				<strong>01</strong>
				<i></i>
			</div>
			<div class="ppc-conversion__content">
				<p class="eyebrow"><?php esc_html_e( 'Campaign fit assessment', 'nolan-young-demo-theme-003' ); ?></p>
				<h2><?php esc_html_e( 'Find the biggest leak before buying more traffic.', 'nolan-young-demo-theme-003' ); ?></h2>
				<p><?php esc_html_e( 'Bring the current journey, recent performance, and growth target. We will identify where message, experience, or measurement can create the fastest useful learning.', 'nolan-young-demo-theme-003' ); ?></p>
				<ul>
					<li><?php esc_html_e( 'Journey pressure review', 'nolan-young-demo-theme-003' ); ?></li>
					<li><?php esc_html_e( 'Signal-quality assessment', 'nolan-young-demo-theme-003' ); ?></li>
					<li><?php esc_html_e( 'Recommended first move', 'nolan-young-demo-theme-003' ); ?></li>
				</ul>
			</div>
			<div class="ppc-conversion__action">
				<span><i class="availability-dot" aria-hidden="true"></i><?php esc_html_e( 'Assessment windows open', 'nolan-young-demo-theme-003' ); ?></span>
				<a class="button button--primary" href="<?php echo esc_url( nydemo003_page_url( 'contact-us' ) ); ?>">
					<?php esc_html_e( 'Request an assessment', 'nolan-young-demo-theme-003' ); ?>
					<span aria-hidden="true">→</span>
				</a>
				<small><?php esc_html_e( 'A focused conversation. No automated sequence.', 'nolan-young-demo-theme-003' ); ?></small>
			</div>
		</div>
	</div>
</section>
