<?php
/**
 * Template Name: Privacy Policy
 * Template Post Type: page
 *
 * @package NolanYoungDemoTheme001
 */

get_header();
?>
<main id="content">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article <?php post_class( 'legal-page' ); ?>>
			<header class="legal-hero">
				<div class="content-wrap legal-hero__layout">
					<div data-reveal>
						<p class="eyebrow"><?php esc_html_e( 'Trust / transparency / responsibility', 'nolan-young-demo-theme-001' ); ?></p>
						<h1><?php the_title(); ?></h1>
						<p class="hero__lede"><?php esc_html_e( 'A plain-language record of how this site approaches information, privacy, and responsible use.', 'nolan-young-demo-theme-001' ); ?></p>
					</div>
					<div class="legal-hero__record" data-reveal>
						<header><span><?php esc_html_e( 'Policy record', 'nolan-young-demo-theme-001' ); ?></span><small>LIVE</small></header>
						<strong><?php echo esc_html( get_the_modified_date( 'Y.m.d' ) ); ?></strong>
						<dl>
							<div><dt><?php esc_html_e( 'Status', 'nolan-young-demo-theme-001' ); ?></dt><dd><?php esc_html_e( 'Current', 'nolan-young-demo-theme-001' ); ?></dd></div>
							<div><dt><?php esc_html_e( 'Scope', 'nolan-young-demo-theme-001' ); ?></dt><dd><?php esc_html_e( 'This website', 'nolan-young-demo-theme-001' ); ?></dd></div>
							<div><dt><?php esc_html_e( 'Owner', 'nolan-young-demo-theme-001' ); ?></dt><dd><?php echo esc_html( get_bloginfo( 'name' ) ); ?></dd></div>
						</dl>
					</div>
				</div>
			</header>
			<section class="section legal-body">
				<div class="content-wrap legal-layout">
					<aside class="legal-aside" data-reveal>
						<p class="eyebrow"><?php esc_html_e( 'Policy details', 'nolan-young-demo-theme-001' ); ?></p>
						<dl>
							<div>
								<dt><?php esc_html_e( 'Last updated', 'nolan-young-demo-theme-001' ); ?></dt>
								<dd><?php echo esc_html( get_the_modified_date( 'F j, Y' ) ); ?></dd>
							</div>
							<div>
								<dt><?php esc_html_e( 'Effective', 'nolan-young-demo-theme-001' ); ?></dt>
								<dd><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></dd>
							</div>
						</dl>
						<div class="legal-aside__signal">
							<i aria-hidden="true"></i>
							<span><?php esc_html_e( 'Current published version', 'nolan-young-demo-theme-001' ); ?></span>
						</div>
						<a href="<?php echo esc_url( nydemo001_page_url( 'contact-us' ) ); ?>">
							<?php esc_html_e( 'Ask a privacy question', 'nolan-young-demo-theme-001' ); ?>
							<span aria-hidden="true">→</span>
						</a>
					</aside>
					<div class="entry-content legal-content" data-reveal>
						<?php the_content(); ?>
						<?php
						wp_link_pages(
							array(
								'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Policy pages', 'nolan-young-demo-theme-001' ) . '">',
								'after'  => '</nav>',
							)
						);
						?>
					</div>
				</div>
			</section>
		</article>
	<?php endwhile; ?>
</main>
<?php
get_footer();
