<?php
/**
 * Editor-authored static front-page content.
 *
 * The visual hero owns the page-level heading, so this part deliberately
 * renders neither the page title nor featured image.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_front_page_content = get_the_content();

if ( '' === trim( wp_strip_all_tags( $nytt01_front_page_content ) ) ) {
	return;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'nytt01-section nytt01-front-page-content' ); ?>>
	<div class="nytt01-container nytt01-content-area nytt01-entry-content">
		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<nav class="nytt01-page-links" aria-label="' . esc_attr__( 'Page navigation', 'nolan-young-theme-template-01' ) . '">',
				'after'  => '</nav>',
			)
		);
		?>
	</div>
</article>
