<?php
/**
 * Footer widget and brand area.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="nytt01-site-footer__main">
	<div class="nytt01-site-footer__brand">
		<p class="nytt01-site-footer__title"><?php bloginfo( 'name' ); ?></p>
		<p><?php esc_html_e( 'A disciplined WordPress foundation built for accessibility, maintainability, and reliable production delivery.', 'nolan-young-theme-template-01' ); ?></p>
		<?php if ( trim( (string) get_theme_mod( 'nytt01_newsletter_shortcode', '' ) ) || current_user_can( 'edit_theme_options' ) ) : ?>
			<div class="nytt01-newsletter">
				<?php nytt01_render_form_shortcode_slot( 'newsletter' ); ?>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
		<div class="nytt01-footer-widgets">
			<?php dynamic_sidebar( 'footer-widgets' ); ?>
		</div>
	<?php endif; ?>
</div>
