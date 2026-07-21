<?php
/**
 * Presentation hooks and filters.
 *
 * @package NolanYoungThemeTemplate01
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add contextual classes to the body element.
 *
 * @param string[] $classes Existing classes.
 * @return string[]
 */
function nytt01_body_classes( $classes ) {
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( ! is_active_sidebar( 'footer-widgets' ) ) {
		$classes[] = 'nytt01-no-footer-widgets';
	}

	if ( is_front_page() ) {
		$classes[] = 'nytt01-front-page';
	}

	return $classes;
}
add_filter( 'body_class', 'nytt01_body_classes' );

/**
 * Add a pingback discovery header when appropriate.
 *
 * @return void
 */
function nytt01_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'nytt01_pingback_header' );

/**
 * Render an optional, editor-configured form shortcode or its visible placeholder.
 *
 * The placeholder keeps the theme self-contained while showing where a site owner
 * can paste a shortcode from any chosen form provider.
 *
 * @param string $slot Form slot identifier.
 * @return void
 */
function nytt01_render_form_shortcode_slot( $slot ) {
	$slots = array(
		'contact'    => array(
			'setting'     => 'nytt01_contact_form_shortcode',
			'placeholder' => '[your-contact-form-shortcode]',
			'label'       => esc_html__( 'Contact form shortcode placeholder', 'nolan-young-theme-template-01' ),
		),
		'newsletter' => array(
			'setting'     => 'nytt01_newsletter_shortcode',
			'placeholder' => '[your-newsletter-shortcode]',
			'label'       => esc_html__( 'Newsletter shortcode placeholder', 'nolan-young-theme-template-01' ),
		),
	);

	if ( ! isset( $slots[ $slot ] ) ) {
		return;
	}

	$config    = $slots[ $slot ];
	$shortcode = trim( (string) get_theme_mod( $config['setting'], '' ) );

	$shortcode_tag = '';
	if ( preg_match( '/^\s*\[([A-Za-z][A-Za-z0-9_-]*)\b/', $shortcode, $matches ) ) {
		$shortcode_tag = $matches[1];
	}

	if ( '' !== $shortcode && '' !== $shortcode_tag && shortcode_exists( $shortcode_tag ) ) {
		echo do_shortcode( $shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Shortcode markup is supplied by the site's selected form integration.
		return;
	}
	?>
	<div class="nytt01-form-placeholder" role="note">
		<p class="nytt01-form-placeholder__label"><?php echo esc_html( $config['label'] ); ?></p>
		<code><?php echo esc_html( $config['placeholder'] ); ?></code>
		<p><?php esc_html_e( 'Paste a shortcode in Appearance → Customize → Form Shortcodes to display your form here.', 'nolan-young-theme-template-01' ); ?></p>
	</div>
	<?php
}

/**
 * Add current-page context to primary navigation links.
 *
 * @param array    $attributes Link attributes.
 * @param WP_Post  $menu_item  Menu item object.
 * @param stdClass $args       Menu arguments.
 * @return array
 */
function nytt01_nav_menu_link_attributes( $attributes, $menu_item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location && $menu_item->current ) {
		$attributes['aria-current'] = 'page';
	}

	return $attributes;
}
add_filter( 'nav_menu_link_attributes', 'nytt01_nav_menu_link_attributes', 10, 3 );

/**
 * Provide a safe fallback for the primary menu.
 *
 * @return void
 */
function nytt01_primary_menu_fallback() {
	$walker = new NYTT01_Primary_Nav_Walker();
	$args   = (object) array(
		'theme_location' => 'primary',
		'menu_id'        => 'primary-menu',
		'menu_class'     => 'nytt01-menu',
	);
	$output = '<ul id="primary-menu" class="nytt01-menu nytt01-menu--fallback">';

	foreach ( nytt01_get_default_primary_menu_items() as $index => $menu_item ) {
		$item = (object) array(
			'ID'        => 9000 + (int) $index,
			'title'     => isset( $menu_item['menu-item-title'] ) ? $menu_item['menu-item-title'] : '',
			'url'       => isset( $menu_item['menu-item-url'] ) ? $menu_item['menu-item-url'] : get_permalink( (int) $menu_item['menu-item-object-id'] ),
			'classes'   => isset( $menu_item['menu-item-classes'] ) ? $menu_item['menu-item-classes'] : array(),
			'current'   => false,
			'object'    => isset( $menu_item['menu-item-object'] ) ? $menu_item['menu-item-object'] : 'custom',
			'object_id' => isset( $menu_item['menu-item-object-id'] ) ? (int) $menu_item['menu-item-object-id'] : 0,
		);

		$walker->start_el( $output, $item, 0, $args, 0 );
		$walker->end_el( $output, $item, 0, $args );
	}

	$output .= '</ul>';

	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Markup is generated and escaped by the theme walker.
}
