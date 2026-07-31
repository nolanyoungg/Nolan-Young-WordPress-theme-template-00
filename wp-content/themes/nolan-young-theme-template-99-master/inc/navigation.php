<?php
/**
 * Native primary navigation and enterprise mega panels.
 *
 * @package NolanYoungThemeTemplate99Master
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return the assigned primary menu's top-level URLs when available.
 *
 * @return array<string, string>
 */
function nytt99_primary_menu_urls() {
	$urls      = array();
	$locations = get_nav_menu_locations();

	if ( empty( $locations['primary'] ) ) {
		return $urls;
	}

	$items = wp_get_nav_menu_items( $locations['primary'] );
	if ( ! is_array( $items ) ) {
		return $urls;
	}

	foreach ( $items as $item ) {
		if ( 0 !== (int) $item->menu_item_parent ) {
			continue;
		}

		$key          = sanitize_title( wp_strip_all_tags( (string) $item->title ) );
		$urls[ $key ] = (string) $item->url;
	}

	return $urls;
}

/**
 * Resolve a primary navigation URL from the assigned menu or a safe fallback.
 *
 * @param string $key      Menu key.
 * @param string $fallback Fallback relative path.
 * @return string
 */
function nytt99_primary_menu_url( $key, $fallback ) {
	$urls = nytt99_primary_menu_urls();

	if ( isset( $urls[ $key ] ) ) {
		return $urls[ $key ];
	}

	return home_url( $fallback );
}

/**
 * Return rich mega-menu content.
 *
 * @return array<string, array<string, mixed>>
 */
function nytt99_mega_menu_data() {
	return array(
		'services' => array(
			'label'       => __( 'Services', 'nolan-young-theme-template-99-master' ),
			'eyebrow'     => __( 'Enterprise capabilities', 'nolan-young-theme-template-99-master' ),
			'heading'     => __( 'Build the system behind better growth.', 'nolan-young-theme-template-99-master' ),
			'description' => __( 'Strategy, experience, engineering, and long-term stewardship connected as one practical delivery system.', 'nolan-young-theme-template-99-master' ),
			'url'         => nytt99_primary_menu_url( 'services', '/services/' ),
			'metric'      => __( 'Four connected service tracks', 'nolan-young-theme-template-99-master' ),
			'items'       => array(
				array(
					'title'       => __( 'Service 1', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Turn a defined business need into a clear, measurable implementation plan.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/services/#service-1' ),
					'links'       => array( __( 'Overview', 'nolan-young-theme-template-99-master' ), __( 'Capabilities', 'nolan-young-theme-template-99-master' ), __( 'Process', 'nolan-young-theme-template-99-master' ) ),
					'code'        => '01',
				),
				array(
					'title'       => __( 'Service 2', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Improve the structure, usability, and accessibility of an existing experience.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/services/#service-2' ),
					'links'       => array( __( 'Experience review', 'nolan-young-theme-template-99-master' ), __( 'Accessibility', 'nolan-young-theme-template-99-master' ), __( 'Optimization', 'nolan-young-theme-template-99-master' ) ),
					'code'        => '02',
				),
				array(
					'title'       => __( 'Service 3', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Production engineering for maintainable WordPress systems and integrations.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/services/#service-3' ),
					'links'       => array( __( 'WordPress', 'nolan-young-theme-template-99-master' ), __( 'Integrations', 'nolan-young-theme-template-99-master' ), __( 'Release systems', 'nolan-young-theme-template-99-master' ) ),
					'code'        => '03',
				),
				array(
					'title'       => __( 'Service 4', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Ongoing stewardship for performance, stability, security, and improvement.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/services/#service-4' ),
					'links'       => array( __( 'Maintenance', 'nolan-young-theme-template-99-master' ), __( 'Performance', 'nolan-young-theme-template-99-master' ), __( 'Support', 'nolan-young-theme-template-99-master' ) ),
					'code'        => '04',
				),
			),
		),
		'about'    => array(
			'label'       => __( 'About', 'nolan-young-theme-template-99-master' ),
			'eyebrow'     => __( 'How the team works', 'nolan-young-theme-template-99-master' ),
			'heading'     => __( 'Senior thinking, close collaboration.', 'nolan-young-theme-template-99-master' ),
			'description' => __( 'Meet the people, principles, and experiments behind careful enterprise delivery.', 'nolan-young-theme-template-99-master' ),
			'url'         => nytt99_primary_menu_url( 'about', '/about-us/' ),
			'metric'      => __( 'One team from strategy through launch', 'nolan-young-theme-template-99-master' ),
			'items'       => array(
				array(
					'title'       => __( 'About Us', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'The story, values, and approach behind the work.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/about-us/#story' ),
					'links'       => array( __( 'Our story', 'nolan-young-theme-template-99-master' ), __( 'Values', 'nolan-young-theme-template-99-master' ), __( 'Approach', 'nolan-young-theme-template-99-master' ) ),
					'code'        => 'A1',
				),
				array(
					'title'       => __( 'Meet the Team', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Leadership, design, and engineering working as one unit.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/about-us/#team' ),
					'links'       => array( __( 'Leadership', 'nolan-young-theme-template-99-master' ), __( 'Design', 'nolan-young-theme-template-99-master' ), __( 'Engineering', 'nolan-young-theme-template-99-master' ) ),
					'code'        => 'A2',
				),
				array(
					'title'       => __( 'Careers', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'A collaborative environment for thoughtful, standards-based work.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/about-us/#careers' ),
					'links'       => array( __( 'Open roles', 'nolan-young-theme-template-99-master' ), __( 'Culture', 'nolan-young-theme-template-99-master' ), __( 'Benefits', 'nolan-young-theme-template-99-master' ) ),
					'code'        => 'A3',
				),
				array(
					'title'       => __( 'Future Work', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Research and experiments shaping the next delivery capability.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/about-us/#future' ),
					'links'       => array( __( 'Research', 'nolan-young-theme-template-99-master' ), __( 'Experiments', 'nolan-young-theme-template-99-master' ), __( 'Roadmap', 'nolan-young-theme-template-99-master' ) ),
					'code'        => 'A4',
				),
			),
		),
		'work'     => array(
			'label'       => __( 'Work', 'nolan-young-theme-template-99-master' ),
			'eyebrow'     => __( 'Evidence and outcomes', 'nolan-young-theme-template-99-master' ),
			'heading'     => __( 'See what changed—not just what shipped.', 'nolan-young-theme-template-99-master' ),
			'description' => __( 'Explore fictional enterprise cases organized around the business pressure, intervention, and measurable result.', 'nolan-young-theme-template-99-master' ),
			'url'         => nytt99_primary_menu_url( 'work', '/work/' ),
			'metric'      => __( 'Six cases across three capability tracks', 'nolan-young-theme-template-99-master' ),
			'items'       => array(
				array(
					'title'       => __( 'Flagship case', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'A fragmented global platform becomes one confident customer system.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/work/#flagship-case' ),
					'links'       => array( __( 'Challenge', 'nolan-young-theme-template-99-master' ), __( 'Intervention', 'nolan-young-theme-template-99-master' ), __( 'Outcomes', 'nolan-young-theme-template-99-master' ) ),
					'code'        => 'W1',
				),
				array(
					'title'       => __( 'Strategy work', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Positioning, portfolio, and decision systems built for alignment.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/work/#project-library' ),
					'links'       => array( __( 'Positioning', 'nolan-young-theme-template-99-master' ), __( 'Roadmaps', 'nolan-young-theme-template-99-master' ), __( 'Decision systems', 'nolan-young-theme-template-99-master' ) ),
					'code'        => 'W2',
				),
				array(
					'title'       => __( 'Experience work', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Complex customer and employee journeys made clear and usable.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/work/#project-library' ),
					'links'       => array( __( 'Journey design', 'nolan-young-theme-template-99-master' ), __( 'Prototypes', 'nolan-young-theme-template-99-master' ), __( 'Accessibility', 'nolan-young-theme-template-99-master' ) ),
					'code'        => 'W3',
				),
				array(
					'title'       => __( 'Platform work', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Maintainable publishing and service platforms designed for ownership.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/work/#portfolio-results' ),
					'links'       => array( __( 'WordPress', 'nolan-young-theme-template-99-master' ), __( 'Integrations', 'nolan-young-theme-template-99-master' ), __( 'Release quality', 'nolan-young-theme-template-99-master' ) ),
					'code'        => 'W4',
				),
			),
		),
	);
}

/**
 * Render a rich full-width mega panel.
 *
 * @param string               $key  Panel key.
 * @param array<string, mixed> $data Panel data.
 * @return void
 */
function nytt99_render_mega_panel( $key, $data ) {
	$panel_id = 'nytt99-mega-' . sanitize_html_class( $key );
	$first    = $data['items'][0];
	?>
	<li class="site-menu__item site-menu__item--mega" data-mega-item>
		<button
			class="site-menu__trigger"
			type="button"
			aria-expanded="false"
			aria-controls="<?php echo esc_attr( $panel_id ); ?>"
			data-mega-trigger
		>
			<span><?php echo esc_html( $data['label'] ); ?></span>
			<svg viewBox="0 0 12 12" aria-hidden="true"><path d="M2 4.25 6 8l4-3.75"/></svg>
		</button>
		<div id="<?php echo esc_attr( $panel_id ); ?>" class="mega-panel" data-mega-panel>
			<div class="mega-panel__context content-wrap">
				<div>
					<strong><?php echo esc_html( $data['label'] ); ?></strong>
					<span><?php echo esc_html( $data['metric'] ); ?></span>
				</div>
				<a href="<?php echo esc_url( $data['url'] ); ?>">
					<?php esc_html_e( 'Explore the complete practice', 'nolan-young-theme-template-99-master' ); ?>
					<span aria-hidden="true"> ↗</span>
				</a>
			</div>
			<div class="mega-panel__inner content-wrap">
				<div class="mega-panel__intro">
					<span class="mega-panel__index" aria-hidden="true"><?php echo esc_html( strtoupper( substr( $key, 0, 1 ) ) ); ?></span>
					<p class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></p>
					<h2><?php echo esc_html( $data['heading'] ); ?></h2>
					<p><?php echo esc_html( $data['description'] ); ?></p>
					<a class="text-link" href="<?php echo esc_url( $data['url'] ); ?>">
						<?php esc_html_e( 'View overview', 'nolan-young-theme-template-99-master' ); ?>
						<span aria-hidden="true">→</span>
					</a>
				</div>
				<div class="mega-panel__options" aria-label="<?php echo esc_attr( $data['label'] ); ?>">
					<span class="mega-panel__rail-label"><?php esc_html_e( 'Choose a direction', 'nolan-young-theme-template-99-master' ); ?></span>
					<?php foreach ( $data['items'] as $index => $item ) : ?>
						<a
							class="mega-option<?php echo 0 === $index ? ' is-active' : ''; ?>"
							href="<?php echo esc_url( $item['url'] ); ?>"
							data-mega-option
							data-title="<?php echo esc_attr( $item['title'] ); ?>"
							data-description="<?php echo esc_attr( $item['description'] ); ?>"
							data-code="<?php echo esc_attr( $item['code'] ); ?>"
							data-links="<?php echo esc_attr( wp_json_encode( $item['links'] ) ); ?>"
						>
							<span class="mega-option__code"><?php echo esc_html( $item['code'] ); ?></span>
							<span><strong><?php echo esc_html( $item['title'] ); ?></strong><small><?php echo esc_html( $item['description'] ); ?></small></span>
							<span aria-hidden="true">↗</span>
						</a>
					<?php endforeach; ?>
				</div>
				<aside class="mega-feature" data-mega-feature>
					<div class="mega-feature__top">
						<span><?php esc_html_e( 'Live capability view', 'nolan-young-theme-template-99-master' ); ?></span>
						<span><?php esc_html_e( 'Available', 'nolan-young-theme-template-99-master' ); ?></span>
					</div>
					<div class="mega-feature__visual" aria-hidden="true">
						<span data-mega-code><?php echo esc_html( $first['code'] ); ?></span>
						<div class="mega-feature__diagram"><i></i><i></i><i></i><i></i></div>
					</div>
					<div class="mega-feature__details">
						<p class="eyebrow"><?php echo esc_html( $data['metric'] ); ?></p>
						<h3 data-mega-title><?php echo esc_html( $first['title'] ); ?></h3>
						<span aria-hidden="true">↗</span>
						<p data-mega-description><?php echo esc_html( $first['description'] ); ?></p>
						<ul data-mega-links>
							<?php foreach ( $first['links'] as $link ) : ?>
								<li><?php echo esc_html( $link ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</aside>
			</div>
			<div class="mega-panel__utility content-wrap">
				<a href="<?php echo esc_url( nytt99_primary_menu_url( 'work', '/work/' ) ); ?>">
					<span><?php esc_html_e( 'See the evidence in our work', 'nolan-young-theme-template-99-master' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a href="<?php echo esc_url( nytt99_primary_menu_url( 'blog', '/journal/' ) ); ?>">
					<span><?php esc_html_e( 'Read the latest field notes', 'nolan-young-theme-template-99-master' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a href="<?php echo esc_url( nytt99_page_url( 'contact-us' ) ); ?>">
					<span><?php esc_html_e( 'Discuss the right first move', 'nolan-young-theme-template-99-master' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
			</div>
		</div>
	</li>
	<?php
}

/**
 * Render the live-post Blog mega panel.
 *
 * @return void
 */
function nytt99_render_blog_panel() {
	$posts = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 4,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	?>
	<li class="site-menu__item site-menu__item--mega" data-mega-item>
		<button class="site-menu__trigger" type="button" aria-expanded="false" aria-controls="nytt99-mega-blog" data-mega-trigger>
			<span><?php esc_html_e( 'Blog', 'nolan-young-theme-template-99-master' ); ?></span>
			<svg viewBox="0 0 12 12" aria-hidden="true"><path d="M2 4.25 6 8l4-3.75"/></svg>
		</button>
		<div id="nytt99-mega-blog" class="mega-panel mega-panel--blog" data-mega-panel>
			<div class="mega-panel__context content-wrap">
				<div>
					<strong><?php esc_html_e( 'Journal', 'nolan-young-theme-template-99-master' ); ?></strong>
					<span><?php esc_html_e( 'Strategy, experience, engineering, and operations', 'nolan-young-theme-template-99-master' ); ?></span>
				</div>
				<a href="<?php echo esc_url( nytt99_primary_menu_url( 'blog', '/journal/' ) ); ?>">
					<?php esc_html_e( 'Open the editorial index', 'nolan-young-theme-template-99-master' ); ?>
					<span aria-hidden="true"> ↗</span>
				</a>
			</div>
			<div class="mega-panel__blog content-wrap">
				<header>
					<div>
						<p class="eyebrow"><?php esc_html_e( 'Latest intelligence', 'nolan-young-theme-template-99-master' ); ?></p>
						<h2><?php esc_html_e( 'Ideas for teams building what comes next.', 'nolan-young-theme-template-99-master' ); ?></h2>
					</div>
					<a class="text-link" href="<?php echo esc_url( nytt99_primary_menu_url( 'blog', '/journal/' ) ); ?>">
						<?php esc_html_e( 'View all articles', 'nolan-young-theme-template-99-master' ); ?> <span aria-hidden="true">→</span>
					</a>
				</header>
				<div class="mega-blog-grid">
					<?php if ( $posts->have_posts() ) : ?>
						<?php while ( $posts->have_posts() ) : ?>
							<?php $posts->the_post(); ?>
							<article class="mega-blog-card">
								<a href="<?php the_permalink(); ?>">
									<span class="mega-blog-card__visual">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium' ); ?>
										<?php else : ?>
											<span aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $posts->current_post + 1 ) ); ?></span>
										<?php endif; ?>
									</span>
									<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
									<h3><?php the_title(); ?></h3>
									<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 12 ) ); ?></p>
									<span class="text-link"><?php esc_html_e( 'Read article', 'nolan-young-theme-template-99-master' ); ?> →</span>
								</a>
							</article>
						<?php endwhile; ?>
					<?php else : ?>
						<article class="mega-blog-card mega-blog-card--empty">
							<span class="mega-blog-card__visual" aria-hidden="true">01</span>
							<p class="eyebrow"><?php esc_html_e( 'Journal', 'nolan-young-theme-template-99-master' ); ?></p>
							<h3><?php esc_html_e( 'Publish the first insight to populate this live panel.', 'nolan-young-theme-template-99-master' ); ?></h3>
						</article>
					<?php endif; ?>
				</div>
			</div>
			<div class="mega-panel__utility content-wrap">
				<a href="<?php echo esc_url( home_url( '/?s=strategy' ) ); ?>">
					<span><?php esc_html_e( 'Explore strategy', 'nolan-young-theme-template-99-master' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a href="<?php echo esc_url( home_url( '/?s=wordpress' ) ); ?>">
					<span><?php esc_html_e( 'Explore WordPress', 'nolan-young-theme-template-99-master' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a href="<?php echo esc_url( nytt99_page_url( 'contact-us' ) ); ?>">
					<span><?php esc_html_e( 'Turn an idea into a working session', 'nolan-young-theme-template-99-master' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
			</div>
		</div>
	</li>
	<?php
	wp_reset_postdata();
}

/**
 * Render a complete menu when no primary WordPress menu is assigned.
 *
 * The enhanced mega menu is intentionally separate from this native tree. This
 * fallback guarantees that every destination remains reachable without
 * JavaScript and before an editor assigns a menu.
 *
 * @param array<string, mixed> $args WordPress menu arguments.
 * @return void
 */
function nytt99_primary_menu_fallback( $args = array() ) {
	$menu_class = isset( $args['menu_class'] ) ? (string) $args['menu_class'] : 'site-menu site-menu--native';
	?>
	<ul class="<?php echo esc_attr( $menu_class ); ?>">
		<li class="menu-item menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Services', 'nolan-young-theme-template-99-master' ); ?></a>
			<ul class="sub-menu">
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#service-1' ) ); ?>"><?php esc_html_e( 'Service 1', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#service-2' ) ); ?>"><?php esc_html_e( 'Service 2', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#service-3' ) ); ?>"><?php esc_html_e( 'Service 3', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#service-4' ) ); ?>"><?php esc_html_e( 'Service 4', 'nolan-young-theme-template-99-master' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About', 'nolan-young-theme-template-99-master' ); ?></a>
			<ul class="sub-menu">
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/about-us/#story' ) ); ?>"><?php esc_html_e( 'About Us', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/about-us/#team' ) ); ?>"><?php esc_html_e( 'Meet the Team', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/about-us/#careers' ) ); ?>"><?php esc_html_e( 'Careers', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/about-us/#future' ) ); ?>"><?php esc_html_e( 'Future Work', 'nolan-young-theme-template-99-master' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/work/' ) ); ?>"><?php esc_html_e( 'Work', 'nolan-young-theme-template-99-master' ); ?></a>
			<ul class="sub-menu">
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/work/#flagship-case' ) ); ?>"><?php esc_html_e( 'Flagship Case', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/work/#project-library' ) ); ?>"><?php esc_html_e( 'Project Library', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/work/#portfolio-results' ) ); ?>"><?php esc_html_e( 'Results', 'nolan-young-theme-template-99-master' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/journal/' ) ); ?>"><?php esc_html_e( 'Blog', 'nolan-young-theme-template-99-master' ); ?></a>
			<ul class="sub-menu">
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/journal/' ) ); ?>"><?php esc_html_e( 'Latest articles', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/?s=strategy' ) ); ?>"><?php esc_html_e( 'Strategy', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/?s=wordpress' ) ); ?>"><?php esc_html_e( 'WordPress', 'nolan-young-theme-template-99-master' ); ?></a></li>
			</ul>
		</li>
	</ul>
	<?php
}

/**
 * Render primary navigation.
 *
 * @return void
 */
function nytt99_primary_navigation() {
	$data = nytt99_mega_menu_data();
	?>
	<nav id="site-navigation" class="site-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'nolan-young-theme-template-99-master' ); ?>">
		<ul class="site-menu site-menu--enhanced">
			<?php nytt99_render_mega_panel( 'services', $data['services'] ); ?>
			<?php nytt99_render_mega_panel( 'about', $data['about'] ); ?>
			<?php nytt99_render_mega_panel( 'work', $data['work'] ); ?>
			<?php nytt99_render_blog_panel(); ?>
		</ul>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'site-menu site-menu--native',
				'depth'          => 2,
				'fallback_cb'    => 'nytt99_primary_menu_fallback',
				'walker'         => new Walker_Nav_Menu(),
			)
		);
		?>
	</nav>
	<div class="mega-overlay" data-mega-overlay aria-hidden="true"></div>
	<?php
}
