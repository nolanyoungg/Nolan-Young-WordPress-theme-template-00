<?php
/**
 * 404 destination cards.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;

$destinations = array(
	array( '01', 'Services', 'Connect strategy, experience, technology, and growth around one outcome.', nydemo001_page_url( 'services' ), 'Capabilities', array( 'Strategy', 'Experience', 'Platforms' ) ),
	array( '02', 'Work', 'Explore fictional transformation stories, operating choices, and measurable results.', nydemo001_page_url( 'work' ), 'Evidence', array( 'Cases', 'Outcomes', 'Methods' ) ),
	array( '03', 'About', 'Meet the principles, roles, and collaboration model behind the work.', nydemo001_page_url( 'about-us' ), 'Studio', array( 'Story', 'Team', 'Careers' ) ),
	array( '04', 'Journal', 'Read the latest published thinking from the real WordPress post archive.', home_url( '/blog/' ), 'Ideas', array( 'Articles', 'Research', 'Notes' ) ),
);
?>
<section class="section section--cream recovery-routes">
	<div class="content-wrap">
		<header class="section-heading section-heading--split" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Verified destinations', 'nolan-young-demo-theme-001' ); ?></p>
				<h2><?php esc_html_e( 'Choose the route closest to your intent.', 'nolan-young-demo-theme-001' ); ?></h2>
			</div>
			<p><?php esc_html_e( 'Every destination below is part of the current site map and gives you a useful way back into the experience.', 'nolan-young-demo-theme-001' ); ?></p>
		</header>
		<nav class="recovery-route-grid" aria-label="<?php esc_attr_e( 'Recovery destinations', 'nolan-young-demo-theme-001' ); ?>">
			<?php foreach ( $destinations as $destination ) : ?>
				<a class="recovery-route" href="<?php echo esc_url( $destination[3] ); ?>" data-reveal>
					<header>
						<span><?php echo esc_html( $destination[0] ); ?></span>
						<small><?php echo esc_html( $destination[4] ); ?></small>
					</header>
					<div class="recovery-route__signal" aria-hidden="true">
						<i></i><i></i><i></i>
					</div>
					<h3><?php echo esc_html( $destination[1] ); ?></h3>
					<p><?php echo esc_html( $destination[2] ); ?></p>
					<ul>
						<?php foreach ( $destination[5] as $label ) : ?>
							<li><?php echo esc_html( $label ); ?></li>
						<?php endforeach; ?>
					</ul>
					<footer>
						<span><?php esc_html_e( 'Open destination', 'nolan-young-demo-theme-001' ); ?></span>
						<i aria-hidden="true">→</i>
					</footer>
				</a>
			<?php endforeach; ?>
		</nav>
	</div>
</section>
