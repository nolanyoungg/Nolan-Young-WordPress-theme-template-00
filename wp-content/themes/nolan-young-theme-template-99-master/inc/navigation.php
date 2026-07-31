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
			'eyebrow'     => __( 'Digital capabilities', 'nolan-young-theme-template-99-master' ),
			'heading'     => __( 'Choose what you want to move forward.', 'nolan-young-theme-template-99-master' ),
			'description' => __( 'Explore focused services designed to turn ambitious ideas into useful, measurable digital systems.', 'nolan-young-theme-template-99-master' ),
			'url'         => nytt99_primary_menu_url( 'services', '/services/' ),
			'metric'      => __( 'Five specialties. One connected delivery team.', 'nolan-young-theme-template-99-master' ),
			'items'       => array(
				array(
					'title'       => __( 'Website Development', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Fast, accessible websites built around clear content, confident interactions, and maintainable systems.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/services/#website-development' ),
					'links'       => array(
						__( 'WordPress Development', 'nolan-young-theme-template-99-master' ),
						__( 'Custom Website Development', 'nolan-young-theme-template-99-master' ),
						__( 'Headless CMS Development', 'nolan-young-theme-template-99-master' ),
						__( 'React Development', 'nolan-young-theme-template-99-master' ),
						__( 'Shopify Development', 'nolan-young-theme-template-99-master' ),
						__( 'Landing Page Builds', 'nolan-young-theme-template-99-master' ),
						__( 'Website Redesigns', 'nolan-young-theme-template-99-master' ),
					),
					'code'        => '01',
					'visual'      => 'website',
					'glyph'       => '</>',
				),
				array(
					'title'       => __( 'Plugin Development', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Purpose-built WordPress functionality that fits the editorial workflow instead of fighting it.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/services/#plugin-development' ),
					'links'       => array(
						__( 'SEO Plugins', 'nolan-young-theme-template-99-master' ),
						__( 'Form Plugins', 'nolan-young-theme-template-99-master' ),
						__( 'Menu Plugins', 'nolan-young-theme-template-99-master' ),
						__( 'Custom WordPress Plugins', 'nolan-young-theme-template-99-master' ),
						__( 'API Integration Plugins', 'nolan-young-theme-template-99-master' ),
						__( 'Booking Plugins', 'nolan-young-theme-template-99-master' ),
						__( 'Admin Dashboard Extensions', 'nolan-young-theme-template-99-master' ),
					),
					'code'        => '02',
					'visual'      => 'plugin',
					'glyph'       => '+',
				),
				array(
					'title'       => __( 'SEO', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Search foundations and content signals that help the right audience discover—and trust—your expertise.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/services/#seo' ),
					'links'       => array(
						__( 'Technical SEO', 'nolan-young-theme-template-99-master' ),
						__( 'On-Page SEO', 'nolan-young-theme-template-99-master' ),
						__( 'Local SEO', 'nolan-young-theme-template-99-master' ),
						__( 'Keyword Research', 'nolan-young-theme-template-99-master' ),
						__( 'Content Optimization', 'nolan-young-theme-template-99-master' ),
						__( 'Schema Markup', 'nolan-young-theme-template-99-master' ),
						__( 'Site Speed Improvements', 'nolan-young-theme-template-99-master' ),
					),
					'code'        => '03',
					'visual'      => 'seo',
					'glyph'       => '↑',
				),
				array(
					'title'       => __( 'Analytics', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Decision-ready measurement that turns noisy traffic and campaign data into a useful operating picture.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/services/#analytics' ),
					'links'       => array(
						__( 'GA4 Setup', 'nolan-young-theme-template-99-master' ),
						__( 'Conversion Tracking', 'nolan-young-theme-template-99-master' ),
						__( 'Dashboard Creation', 'nolan-young-theme-template-99-master' ),
						__( 'Event Tracking', 'nolan-young-theme-template-99-master' ),
						__( 'Funnel Analysis', 'nolan-young-theme-template-99-master' ),
						__( 'Marketing Reports', 'nolan-young-theme-template-99-master' ),
						__( 'Data Cleanup', 'nolan-young-theme-template-99-master' ),
					),
					'code'        => '04',
					'visual'      => 'analytics',
					'glyph'       => '∿',
				),
				array(
					'title'       => __( 'AI Development', 'nolan-young-theme-template-99-master' ),
					'description' => __( 'Practical AI tools and automations shaped around real workflows, useful guardrails, and human control.', 'nolan-young-theme-template-99-master' ),
					'url'         => home_url( '/services/#ai-development' ),
					'links'       => array(
						__( 'AI Chatbots', 'nolan-young-theme-template-99-master' ),
						__( 'Automation Workflows', 'nolan-young-theme-template-99-master' ),
						__( 'AI-Powered Search', 'nolan-young-theme-template-99-master' ),
						__( 'Content Generation Tools', 'nolan-young-theme-template-99-master' ),
						__( 'Custom GPT Integrations', 'nolan-young-theme-template-99-master' ),
						__( 'Lead Qualification Bots', 'nolan-young-theme-template-99-master' ),
						__( 'Internal AI Assistants', 'nolan-young-theme-template-99-master' ),
					),
					'code'        => '05',
					'visual'      => 'ai',
					'glyph'       => 'AI',
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
 * Render the interactive services mega panel.
 *
 * @param array<string, mixed> $data Services panel data.
 * @return void
 */
function nytt99_render_services_panel( $data ) {
	$panel_id = 'nytt99-mega-services';
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
		<div id="<?php echo esc_attr( $panel_id ); ?>" class="mega-panel mega-panel--services" data-mega-panel>
			<div class="mega-panel__context content-wrap">
				<div>
					<strong><?php echo esc_html( $data['label'] ); ?></strong>
					<span><?php echo esc_html( $data['metric'] ); ?></span>
				</div>
				<a href="<?php echo esc_url( $data['url'] ); ?>">
					<?php esc_html_e( 'Explore every service', 'nolan-young-theme-template-99-master' ); ?>
					<span aria-hidden="true"> ↗</span>
				</a>
			</div>
			<div class="mega-services content-wrap" data-service-tabs>
				<section class="mega-services__categories" aria-labelledby="nytt99-services-heading">
					<div class="mega-services__intro">
						<p class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></p>
						<h2 id="nytt99-services-heading"><?php echo esc_html( $data['heading'] ); ?></h2>
						<p><?php echo esc_html( $data['description'] ); ?></p>
					</div>
					<div class="mega-services__list" role="tablist" aria-label="<?php esc_attr_e( 'Service categories', 'nolan-young-theme-template-99-master' ); ?>" aria-orientation="vertical">
						<?php foreach ( $data['items'] as $index => $item ) : ?>
							<?php
							$tab_id     = 'nytt99-service-tab-' . sanitize_html_class( $item['visual'] );
							$content_id = 'nytt99-service-panel-' . sanitize_html_class( $item['visual'] );
							?>
							<button
								id="<?php echo esc_attr( $tab_id ); ?>"
								class="mega-service-tab<?php echo 0 === $index ? ' is-active' : ''; ?>"
								type="button"
								role="tab"
								aria-controls="<?php echo esc_attr( $content_id ); ?>"
								aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
								tabindex="<?php echo 0 === $index ? '0' : '-1'; ?>"
								data-service-tab
							>
								<span class="mega-service-tab__code"><?php echo esc_html( $item['code'] ); ?></span>
								<span><?php echo esc_html( $item['title'] ); ?></span>
								<span aria-hidden="true">→</span>
							</button>
						<?php endforeach; ?>
					</div>
				</section>
				<div class="mega-services__stage">
					<?php foreach ( $data['items'] as $index => $item ) : ?>
						<?php
						$tab_id     = 'nytt99-service-tab-' . sanitize_html_class( $item['visual'] );
						$content_id = 'nytt99-service-panel-' . sanitize_html_class( $item['visual'] );
						?>
						<section
							id="<?php echo esc_attr( $content_id ); ?>"
							class="mega-service-panel<?php echo 0 === $index ? ' is-active' : ''; ?>"
							role="tabpanel"
							aria-labelledby="<?php echo esc_attr( $tab_id ); ?>"
							tabindex="0"
							data-service-panel
							<?php echo 0 === $index ? '' : 'hidden'; ?>
						>
							<header class="mega-service-panel__header">
								<div>
									<p class="eyebrow"><?php esc_html_e( 'Featured capability', 'nolan-young-theme-template-99-master' ); ?></p>
									<h3><?php echo esc_html( $item['title'] ); ?></h3>
									<p><?php echo esc_html( $item['description'] ); ?></p>
								</div>
								<div class="service-visual service-visual--<?php echo esc_attr( $item['visual'] ); ?>" aria-hidden="true">
									<span class="service-visual__orbit"></span>
									<span class="service-mascot service-mascot--<?php echo esc_attr( $item['visual'] ); ?>">
										<span class="service-mascot__eyes"><i></i><i></i></span>
										<span class="service-mascot__glyph"><?php echo esc_html( $item['glyph'] ); ?></span>
									</span>
									<span class="service-visual__spark service-visual__spark--one"></span>
									<span class="service-visual__spark service-visual__spark--two"></span>
								</div>
							</header>
							<div class="mega-service-panel__details">
								<span><?php esc_html_e( 'What we build', 'nolan-young-theme-template-99-master' ); ?></span>
								<ul>
									<?php foreach ( $item['links'] as $link ) : ?>
										<li><span aria-hidden="true">✓</span><?php echo esc_html( $link ); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<a class="mega-service-panel__cta" href="<?php echo esc_url( $item['url'] ); ?>">
								<span><?php echo esc_html( sprintf( __( 'Explore %s', 'nolan-young-theme-template-99-master' ), $item['title'] ) ); ?></span>
								<span aria-hidden="true">↗</span>
							</a>
						</section>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</li>
	<?php
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
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#website-development' ) ); ?>"><?php esc_html_e( 'Website Development', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#plugin-development' ) ); ?>"><?php esc_html_e( 'Plugin Development', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#seo' ) ); ?>"><?php esc_html_e( 'SEO', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#analytics' ) ); ?>"><?php esc_html_e( 'Analytics', 'nolan-young-theme-template-99-master' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#ai-development' ) ); ?>"><?php esc_html_e( 'AI Development', 'nolan-young-theme-template-99-master' ); ?></a></li>
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
			<?php nytt99_render_services_panel( $data['services'] ); ?>
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
