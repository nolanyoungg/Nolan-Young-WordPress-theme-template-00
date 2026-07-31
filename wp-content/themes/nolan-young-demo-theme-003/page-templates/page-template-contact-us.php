<?php
/**
 * Template Name: Contact Us
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="content" class="brief-page"><header class="brief-page__cover"><div class="content-wrap"><span>C–003</span><p class="eyebrow"><?php esc_html_e( 'Open brief', 'nolan-young-demo-theme-003' ); ?></p><h1><?php esc_html_e( 'Start with what is not working yet.', 'nolan-young-demo-theme-003' ); ?></h1></div></header><section class="brief-form section"><div class="content-wrap"><aside><strong><?php esc_html_e( 'New York / Working worldwide', 'nolan-young-demo-theme-003' ); ?></strong><p><?php esc_html_e( 'A short note is enough. Expect a thoughtful reply within two working days.', 'nolan-young-demo-theme-003' ); ?></p><span>NY–003</span></aside><form action="#" method="post"><label><span>01</span><?php esc_html_e( 'Your name', 'nolan-young-demo-theme-003' ); ?><input type="text" name="demo_name" autocomplete="name" required></label><label><span>02</span><?php esc_html_e( 'Email address', 'nolan-young-demo-theme-003' ); ?><input type="email" name="demo_email" autocomplete="email" required></label><label><span>03</span><?php esc_html_e( 'What should change?', 'nolan-young-demo-theme-003' ); ?><textarea name="demo_context" rows="7" required></textarea></label><p><?php esc_html_e( 'Demonstration form only. Connect a form handler before launch.', 'nolan-young-demo-theme-003' ); ?></p><button class="button" type="submit"><?php esc_html_e( 'Send the brief', 'nolan-young-demo-theme-003' ); ?></button></form></div></section></main>
<?php get_footer();
