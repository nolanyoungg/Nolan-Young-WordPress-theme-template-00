<?php
/**
 * Empty-results presentation.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_heading_level = isset( $args['heading_level'] ) && 2 === (int) $args['heading_level'] ? 'h2' : 'h1';
$nytt01_heading_id    = wp_unique_id( 'nytt01-no-results-title-' );
?>
<section class="nytt01-no-results" aria-labelledby="<?php echo esc_attr( $nytt01_heading_id ); ?>">
	<header>
		<<?php echo tag_escape( $nytt01_heading_level ); ?> id="<?php echo esc_attr( $nytt01_heading_id ); ?>"><?php esc_html_e( 'Nothing found', 'nolan-young-theme-template-01' ); ?></<?php echo tag_escape( $nytt01_heading_level ); ?>>
	</header>
	<?php if ( is_search() ) : ?>
		<p><?php esc_html_e( 'No results matched your search. Try different keywords.', 'nolan-young-theme-template-01' ); ?></p>
		<?php get_search_form(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'There is no content to display yet.', 'nolan-young-theme-template-01' ); ?></p>
	<?php endif; ?>
</section>
