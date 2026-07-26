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

	if ( is_home() ) {
		$classes[] = 'nytt01-page-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'nytt01_body_classes' );

/**
 * Resolve a published site destination without assuming a fixed permalink.
 *
 * @param string $destination Destination key.
 * @return string
 */
function nytt01_get_destination_url( $destination ) {
	$destination = sanitize_key( $destination );

	if ( 'blog' === $destination ) {
		$posts_page_id = (int) get_option( 'page_for_posts' );
		$url           = $posts_page_id ? get_permalink( $posts_page_id ) : '';

		/** This filter is documented below with the generic return path. */
		return (string) apply_filters( 'nytt01_destination_url', $url, $destination );
	}

	$templates = array(
		'about'    => 'page-templates/template-about-us.php',
		'contact'  => 'page-templates/template-contact.php',
		'services' => 'page-templates/template-services.php',
		'work'     => 'page-templates/template-work.php',
	);
	$slugs     = array(
		'about'    => array( 'about', 'about-us' ),
		'contact'  => array( 'contact' ),
		'services' => array( 'services' ),
		'work'     => array( 'work' ),
	);
	$url       = '';

	if ( isset( $templates[ $destination ] ) ) {
		$pages = get_pages(
			array(
				'meta_key'    => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- Resolves a single published page and is cached by WordPress.
				'meta_value'  => $templates[ $destination ], // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value -- Template assignment is the authoritative lookup.
				'post_status' => 'publish',
				'number'      => 1,
			)
		);

		if ( ! empty( $pages ) ) {
			$url = get_permalink( $pages[0] );
		}
	}

	if ( '' === $url && isset( $slugs[ $destination ] ) ) {
		foreach ( $slugs[ $destination ] as $slug ) {
			$page = get_page_by_path( $slug );

			if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
				$url = get_permalink( $page );
				break;
			}
		}
	}

	/**
	 * Filter a resolved theme destination.
	 *
	 * @param string $url         Resolved URL, or an empty string.
	 * @param string $destination Destination key.
	 */
	return (string) apply_filters( 'nytt01_destination_url', $url, $destination );
}

/**
 * Return manually selected Featured Work post IDs.
 *
 * WordPress sticky posts provide a core-owned editorial selection mechanism.
 *
 * @return int[]
 */
function nytt01_get_featured_work_ids() {
	$ids = array_values(
		array_filter(
			array_map( 'absint', (array) get_option( 'sticky_posts', array() ) )
		)
	);

	/**
	 * Filter the manually selected Featured Work post IDs.
	 *
	 * @param int[] $ids Sticky post IDs.
	 */
	return array_slice( array_values( (array) apply_filters( 'nytt01_featured_work_ids', $ids ) ), 0, 3 );
}

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

	if ( ! current_user_can( 'edit_theme_options' ) ) {
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
 * Hide legacy page-template aliases from new assignments.
 *
 * Existing pages keep working because WordPress stores and loads their paths.
 *
 * @param array<string, string> $templates Available templates.
 * @return array<string, string>
 */
function nytt01_hide_legacy_page_templates( $templates ) {
	unset(
		$templates['page-templates/template-blog.php'],
		$templates['page-templates/template-single-service.php']
	);

	return $templates;
}
add_filter( 'theme_page_templates', 'nytt01_hide_legacy_page_templates' );

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
