<?php
/**
 * Template Name: Contact Us
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="content" class="editorial-page contact-letter">
	<header class="editorial-cover editorial-cover--rose"><div class="content-wrap editorial-cover__inner"><p class="eyebrow"><?php esc_html_e( 'Correspondence', 'nolan-young-demo-theme-002' ); ?></p><h1><?php esc_html_e( 'Start with the part that feels unresolved.', 'nolan-young-demo-theme-002' ); ?></h1><p><?php esc_html_e( 'A concise note is enough. Tell us what is changing, where the tension lives, and what a better outcome would make possible.', 'nolan-young-demo-theme-002' ); ?></p></div></header>
	<section class="section"><div class="content-wrap contact-letter__layout">
		<aside><span class="studio-invitation__seal" aria-hidden="true">NY<br>002</span><h2><?php esc_html_e( 'New York · Working worldwide', 'nolan-young-demo-theme-002' ); ?></h2><p><?php esc_html_e( 'Replies usually arrive within two working days.', 'nolan-young-demo-theme-002' ); ?></p></aside>
		<form class="contact-letter__form" action="#" method="post">
			<label><?php esc_html_e( 'Your name', 'nolan-young-demo-theme-002' ); ?><input type="text" name="demo_name" autocomplete="name" required></label>
			<label><?php esc_html_e( 'Email address', 'nolan-young-demo-theme-002' ); ?><input type="email" name="demo_email" autocomplete="email" required></label>
			<label><?php esc_html_e( 'What should feel different?', 'nolan-young-demo-theme-002' ); ?><textarea name="demo_context" rows="7" required></textarea></label>
			<p><?php esc_html_e( 'Demo form only—connect a form plugin before production use.', 'nolan-young-demo-theme-002' ); ?></p>
			<button class="button" type="submit"><?php esc_html_e( 'Send the note', 'nolan-young-demo-theme-002' ); ?></button>
		</form>
	</div></section>
</main>
<?php get_footer();
