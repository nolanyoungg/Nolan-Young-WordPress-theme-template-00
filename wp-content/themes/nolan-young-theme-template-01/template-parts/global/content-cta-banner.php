<?php
/**
 * Call-to-action banner.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

$nytt01_contact_url = nytt01_get_destination_url( 'contact' );
?>
<section class="nytt01-section">
	<div class="nytt01-container">
		<div class="nytt01-cta-banner">
			<div>
				<p class="nytt01-eyebrow"><?php esc_html_e( 'Ready to build?', 'nolan-young-theme-template-01' ); ?></p>
				<h2><?php esc_html_e( 'Turn the next idea into a dependable WordPress experience.', 'nolan-young-theme-template-01' ); ?></h2>
			</div>
			<?php if ( $nytt01_contact_url ) : ?>
				<a class="nytt01-button nytt01-button--light" href="<?php echo esc_url( $nytt01_contact_url ); ?>"><?php esc_html_e( 'Contact us', 'nolan-young-theme-template-01' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
