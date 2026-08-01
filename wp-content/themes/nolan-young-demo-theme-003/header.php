<?php
/**
 * Shared site header.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>document.documentElement.classList.remove('no-js');document.documentElement.classList.add('js');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'nolan-young-demo-theme-003' ); ?></a>
<header class="site-header" data-site-header>
	<div class="content-wrap site-header__inner">
		<div class="site-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="brand__mark" aria-hidden="true"><?php echo esc_html( strtoupper( substr( get_bloginfo( 'name' ), 0, 1 ) ) ); ?></span>
					<span class="brand__name"><?php bloginfo( 'name' ); ?></span>
				</a>
			<?php endif; ?>
		</div>
		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-navigation" data-nav-toggle>
			<span class="screen-reader-text"><?php esc_html_e( 'Toggle menu', 'nolan-young-demo-theme-003' ); ?></span>
			<span></span><span></span>
		</button>
		<?php nydemo003_primary_navigation(); ?>
		<?php nydemo003_button( __( 'Start a project', 'nolan-young-demo-theme-003' ) ); ?>
	</div>
</header>
<div class="mega-overlay" data-mega-overlay aria-hidden="true"></div>
