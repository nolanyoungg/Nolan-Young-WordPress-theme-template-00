<?php
/**
 * Search/archive card.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_post_type_object = get_post_type_object( get_post_type() );
$nytt01_type_label       = $nytt01_post_type_object ? $nytt01_post_type_object->labels->singular_name : get_post_type();
$nytt01_heading_level    = isset( $args['heading_level'] ) && 3 === (int) $args['heading_level'] ? 'h3' : 'h2';
$nytt01_title            = get_the_title();
$nytt01_title            = '' !== trim( $nytt01_title ) ? $nytt01_title : __( 'Untitled', 'nolan-young-theme-template-01' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'nytt01-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="nytt01-card__media" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"><?php the_post_thumbnail( 'nytt01-card' ); ?></a>
	<?php endif; ?>
	<div class="nytt01-card__body">
		<p class="nytt01-card__meta"><?php echo esc_html( $nytt01_type_label ); ?></p>
		<<?php echo tag_escape( $nytt01_heading_level ); ?> class="nytt01-card__title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( $nytt01_title ); ?></a></<?php echo tag_escape( $nytt01_heading_level ); ?>>
		<div class="nytt01-card__excerpt"><?php the_excerpt(); ?></div>
		<a class="nytt01-text-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'nolan-young-theme-template-01' ); ?><span aria-hidden="true"> →</span></a>
	</div>
</article>
