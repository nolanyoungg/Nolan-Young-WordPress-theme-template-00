<?php
/**
 * Site search form.
 *
 * @package NolanYoungDemoTheme003
 */

$nydemo003_search_id = wp_unique_id( 'site-search-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $nydemo003_search_id ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'nolan-young-demo-theme-003' ); ?></span>
		<input id="<?php echo esc_attr( $nydemo003_search_id ); ?>" class="search-field" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search by topic or question', 'nolan-young-demo-theme-003' ); ?>">
	</label>
	<button class="search-submit" type="submit">
		<?php esc_html_e( 'Search', 'nolan-young-demo-theme-003' ); ?>
		<span aria-hidden="true">→</span>
	</button>
</form>
