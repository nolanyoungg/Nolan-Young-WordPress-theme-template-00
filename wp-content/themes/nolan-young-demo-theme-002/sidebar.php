<?php
/**
 * Widget sidebar.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside class="sidebar" aria-label="<?php esc_attr_e( 'Supporting content', 'nolan-young-demo-theme-002' ); ?>">
	<div class="sidebar__header">
		<div>
			<p class="eyebrow"><?php esc_html_e( 'Explore further', 'nolan-young-demo-theme-002' ); ?></p>
			<strong><?php esc_html_e( 'Supporting routes', 'nolan-young-demo-theme-002' ); ?></strong>
		</div>
		<span aria-hidden="true">↘</span>
	</div>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
