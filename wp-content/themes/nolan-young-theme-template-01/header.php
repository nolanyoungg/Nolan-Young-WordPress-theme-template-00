<?php
/**
 * Site header.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text skip-link" href="#primary">
	<?php esc_html_e( 'Skip to content', 'nolan-young-theme-template-01' ); ?>
</a>
<div id="page" class="nytt01-site">
	<header id="masthead" class="nytt01-site-header">
		<div class="nytt01-container nytt01-site-header__inner">
			<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
			<?php get_template_part( 'template-parts/header/primary', 'navigation' ); ?>
			<?php
			$nytt01_contact_url = nytt01_get_destination_url( 'contact' );
			if ( $nytt01_contact_url ) :
				?>
				<a class="nytt01-button nytt01-site-header__cta" href="<?php echo esc_url( $nytt01_contact_url ); ?>">
					<?php esc_html_e( 'Contact', 'nolan-young-theme-template-01' ); ?>
				</a>
			<?php endif; ?>
			<?php get_template_part( 'template-parts/header/mobile', 'navigation' ); ?>
		</div>
	</header>
