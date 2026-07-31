<?php
/**
 * Native primary navigation and enterprise mega panels.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return the assigned primary menu's top-level URLs when available.
 *
 * @return array<string, string>
 */
function nydemo002_primary_menu_urls() {
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
function nydemo002_primary_menu_url( $key, $fallback ) {
	$urls = nydemo002_primary_menu_urls();

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
function nydemo002_mega_menu_data() {
	return array(
		'services' => array(
			'label'       => __( 'Services', 'nolan-young-demo-theme-002' ),
			'eyebrow'     => __( 'Digital capabilities', 'nolan-young-demo-theme-002' ),
			'heading'     => __( 'Choose what you want to move forward.', 'nolan-young-demo-theme-002' ),
			'description' => __( 'Explore focused services designed to turn ambitious ideas into useful, measurable digital systems.', 'nolan-young-demo-theme-002' ),
			'url'         => nydemo002_primary_menu_url( 'services', '/services/' ),
			'metric'      => __( 'Five specialties. One connected delivery team.', 'nolan-young-demo-theme-002' ),
			'items'       => array(
				array(
					'title'       => __( 'Website Development', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Fast, accessible websites built around clear content, confident interactions, and maintainable systems.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/services/#website-development' ),
					'links'       => array(
						__( 'WordPress Development', 'nolan-young-demo-theme-002' ),
						__( 'Custom Website Development', 'nolan-young-demo-theme-002' ),
						__( 'Headless CMS Development', 'nolan-young-demo-theme-002' ),
						__( 'React Development', 'nolan-young-demo-theme-002' ),
						__( 'Shopify Development', 'nolan-young-demo-theme-002' ),
						__( 'Landing Page Builds', 'nolan-young-demo-theme-002' ),
						__( 'Website Redesigns', 'nolan-young-demo-theme-002' ),
					),
					'code'        => '01',
					'visual'      => 'website',
					'image'       => 'images/generated/service-web.jpg',
				),
				array(
					'title'       => __( 'Plugin Development', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Purpose-built WordPress functionality that fits the editorial workflow instead of fighting it.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/services/#plugin-development' ),
					'links'       => array(
						__( 'SEO Plugins', 'nolan-young-demo-theme-002' ),
						__( 'Form Plugins', 'nolan-young-demo-theme-002' ),
						__( 'Menu Plugins', 'nolan-young-demo-theme-002' ),
						__( 'Custom WordPress Plugins', 'nolan-young-demo-theme-002' ),
						__( 'API Integration Plugins', 'nolan-young-demo-theme-002' ),
						__( 'Booking Plugins', 'nolan-young-demo-theme-002' ),
						__( 'Admin Dashboard Extensions', 'nolan-young-demo-theme-002' ),
					),
					'code'        => '02',
					'visual'      => 'plugin',
					'image'       => 'images/generated/service-plugin.jpg',
				),
				array(
					'title'       => __( 'SEO', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Search foundations and content signals that help the right audience discover—and trust—your expertise.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/services/#seo' ),
					'links'       => array(
						__( 'Technical SEO', 'nolan-young-demo-theme-002' ),
						__( 'On-Page SEO', 'nolan-young-demo-theme-002' ),
						__( 'Local SEO', 'nolan-young-demo-theme-002' ),
						__( 'Keyword Research', 'nolan-young-demo-theme-002' ),
						__( 'Content Optimization', 'nolan-young-demo-theme-002' ),
						__( 'Schema Markup', 'nolan-young-demo-theme-002' ),
						__( 'Site Speed Improvements', 'nolan-young-demo-theme-002' ),
					),
					'code'        => '03',
					'visual'      => 'seo',
					'image'       => 'images/generated/service-seo.jpg',
				),
				array(
					'title'       => __( 'Analytics', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Decision-ready measurement that turns noisy traffic and campaign data into a useful operating picture.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/services/#analytics' ),
					'links'       => array(
						__( 'GA4 Setup', 'nolan-young-demo-theme-002' ),
						__( 'Conversion Tracking', 'nolan-young-demo-theme-002' ),
						__( 'Dashboard Creation', 'nolan-young-demo-theme-002' ),
						__( 'Event Tracking', 'nolan-young-demo-theme-002' ),
						__( 'Funnel Analysis', 'nolan-young-demo-theme-002' ),
						__( 'Marketing Reports', 'nolan-young-demo-theme-002' ),
						__( 'Data Cleanup', 'nolan-young-demo-theme-002' ),
					),
					'code'        => '04',
					'visual'      => 'analytics',
					'image'       => 'images/generated/service-analytics.jpg',
				),
				array(
					'title'       => __( 'AI Development', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Practical AI tools and automations shaped around real workflows, useful guardrails, and human control.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/services/#ai-development' ),
					'links'       => array(
						__( 'AI Chatbots', 'nolan-young-demo-theme-002' ),
						__( 'Automation Workflows', 'nolan-young-demo-theme-002' ),
						__( 'AI-Powered Search', 'nolan-young-demo-theme-002' ),
						__( 'Content Generation Tools', 'nolan-young-demo-theme-002' ),
						__( 'Custom GPT Integrations', 'nolan-young-demo-theme-002' ),
						__( 'Lead Qualification Bots', 'nolan-young-demo-theme-002' ),
						__( 'Internal AI Assistants', 'nolan-young-demo-theme-002' ),
					),
					'code'        => '05',
					'visual'      => 'ai',
					'image'       => 'images/generated/service-ai.jpg',
				),
			),
		),
		'about'    => array(
			'label'       => __( 'About', 'nolan-young-demo-theme-002' ),
			'eyebrow'     => __( 'How the team works', 'nolan-young-demo-theme-002' ),
			'heading'     => __( 'Senior thinking, close collaboration.', 'nolan-young-demo-theme-002' ),
			'description' => __( 'Meet the people, principles, and experiments behind careful enterprise delivery.', 'nolan-young-demo-theme-002' ),
			'url'         => nydemo002_primary_menu_url( 'about', '/about-us/' ),
			'metric'      => __( 'One team from strategy through launch', 'nolan-young-demo-theme-002' ),
			'items'       => array(
				array(
					'title'       => __( 'About Us', 'nolan-young-demo-theme-002' ),
					'description' => __( 'The story, values, and approach behind the work.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/about-us/#story' ),
					'links'       => array( __( 'Our story', 'nolan-young-demo-theme-002' ), __( 'Values', 'nolan-young-demo-theme-002' ), __( 'Approach', 'nolan-young-demo-theme-002' ) ),
					'code'        => 'A1',
				),
				array(
					'title'       => __( 'Meet the Team', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Leadership, design, and engineering working as one unit.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/about-us/#team' ),
					'links'       => array( __( 'Leadership', 'nolan-young-demo-theme-002' ), __( 'Design', 'nolan-young-demo-theme-002' ), __( 'Engineering', 'nolan-young-demo-theme-002' ) ),
					'code'        => 'A2',
				),
				array(
					'title'       => __( 'Careers', 'nolan-young-demo-theme-002' ),
					'description' => __( 'A collaborative environment for thoughtful, standards-based work.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/about-us/#careers' ),
					'links'       => array( __( 'Open roles', 'nolan-young-demo-theme-002' ), __( 'Culture', 'nolan-young-demo-theme-002' ), __( 'Benefits', 'nolan-young-demo-theme-002' ) ),
					'code'        => 'A3',
				),
				array(
					'title'       => __( 'Future Work', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Research and experiments shaping the next delivery capability.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/about-us/#future' ),
					'links'       => array( __( 'Research', 'nolan-young-demo-theme-002' ), __( 'Experiments', 'nolan-young-demo-theme-002' ), __( 'Roadmap', 'nolan-young-demo-theme-002' ) ),
					'code'        => 'A4',
				),
			),
		),
		'work'     => array(
			'label'       => __( 'Work', 'nolan-young-demo-theme-002' ),
			'eyebrow'     => __( 'Evidence and outcomes', 'nolan-young-demo-theme-002' ),
			'heading'     => __( 'See what changed—not just what shipped.', 'nolan-young-demo-theme-002' ),
			'description' => __( 'Explore fictional enterprise cases organized around the business pressure, intervention, and measurable result.', 'nolan-young-demo-theme-002' ),
			'url'         => nydemo002_primary_menu_url( 'work', '/work/' ),
			'metric'      => __( 'Six cases across three capability tracks', 'nolan-young-demo-theme-002' ),
			'items'       => array(
				array(
					'title'       => __( 'Flagship case', 'nolan-young-demo-theme-002' ),
					'description' => __( 'A fragmented global platform becomes one confident customer system.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/work/#flagship-case' ),
					'links'       => array( __( 'Challenge', 'nolan-young-demo-theme-002' ), __( 'Intervention', 'nolan-young-demo-theme-002' ), __( 'Outcomes', 'nolan-young-demo-theme-002' ) ),
					'code'        => 'W1',
				),
				array(
					'title'       => __( 'Strategy work', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Positioning, portfolio, and decision systems built for alignment.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/work/#project-library' ),
					'links'       => array( __( 'Positioning', 'nolan-young-demo-theme-002' ), __( 'Roadmaps', 'nolan-young-demo-theme-002' ), __( 'Decision systems', 'nolan-young-demo-theme-002' ) ),
					'code'        => 'W2',
				),
				array(
					'title'       => __( 'Experience work', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Complex customer and employee journeys made clear and usable.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/work/#project-library' ),
					'links'       => array( __( 'Journey design', 'nolan-young-demo-theme-002' ), __( 'Prototypes', 'nolan-young-demo-theme-002' ), __( 'Accessibility', 'nolan-young-demo-theme-002' ) ),
					'code'        => 'W3',
				),
				array(
					'title'       => __( 'Platform work', 'nolan-young-demo-theme-002' ),
					'description' => __( 'Maintainable publishing and service platforms designed for ownership.', 'nolan-young-demo-theme-002' ),
					'url'         => home_url( '/work/#portfolio-results' ),
					'links'       => array( __( 'WordPress', 'nolan-young-demo-theme-002' ), __( 'Integrations', 'nolan-young-demo-theme-002' ), __( 'Release quality', 'nolan-young-demo-theme-002' ) ),
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
function nydemo002_render_services_panel( $data ) {
	$panel_id = 'nydemo002-mega-services';
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
					<?php esc_html_e( 'Explore every service', 'nolan-young-demo-theme-002' ); ?>
					<span aria-hidden="true"> ↗</span>
				</a>
			</div>
			<div class="mega-services content-wrap" data-service-tabs>
				<section class="mega-services__categories" aria-labelledby="nydemo002-services-heading">
					<div class="mega-services__intro">
						<p class="eyebrow"><?php echo esc_html( $data['eyebrow'] ); ?></p>
						<h2 id="nydemo002-services-heading"><?php echo esc_html( $data['heading'] ); ?></h2>
						<p><?php echo esc_html( $data['description'] ); ?></p>
					</div>
					<div class="mega-services__list" role="tablist" aria-label="<?php esc_attr_e( 'Service categories', 'nolan-young-demo-theme-002' ); ?>" aria-orientation="vertical">
						<?php foreach ( $data['items'] as $index => $item ) : ?>
							<?php
							$tab_id     = 'nydemo002-service-tab-' . sanitize_html_class( $item['visual'] );
							$content_id = 'nydemo002-service-panel-' . sanitize_html_class( $item['visual'] );
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
						$tab_id     = 'nydemo002-service-tab-' . sanitize_html_class( $item['visual'] );
						$content_id = 'nydemo002-service-panel-' . sanitize_html_class( $item['visual'] );
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
									<p class="eyebrow"><?php esc_html_e( 'Featured capability', 'nolan-young-demo-theme-002' ); ?></p>
									<h3><?php echo esc_html( $item['title'] ); ?></h3>
									<p><?php echo esc_html( $item['description'] ); ?></p>
								</div>
								<figure class="service-portrait">
									<img src="<?php echo esc_url( nydemo002_asset_url( $item['image'] ) ); ?>" alt="" width="180" height="180">
									<figcaption><?php echo esc_html( $item['code'] ); ?> · <?php esc_html_e( 'Made with care', 'nolan-young-demo-theme-002' ); ?></figcaption>
								</figure>
							</header>
							<div class="mega-service-panel__details">
								<span><?php esc_html_e( 'What we build', 'nolan-young-demo-theme-002' ); ?></span>
								<ul>
									<?php foreach ( $item['links'] as $link ) : ?>
										<li><span aria-hidden="true">✓</span><?php echo esc_html( $link ); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<a class="mega-service-panel__cta" href="<?php echo esc_url( $item['url'] ); ?>">
								<span><?php echo esc_html( sprintf( __( 'Explore %s', 'nolan-young-demo-theme-002' ), $item['title'] ) ); ?></span>
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
function nydemo002_render_mega_panel( $key, $data ) {
	$panel_id = 'nydemo002-mega-' . sanitize_html_class( $key );
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
					<?php esc_html_e( 'Explore the complete practice', 'nolan-young-demo-theme-002' ); ?>
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
						<?php esc_html_e( 'View overview', 'nolan-young-demo-theme-002' ); ?>
						<span aria-hidden="true">→</span>
					</a>
				</div>
				<div class="mega-panel__options" aria-label="<?php echo esc_attr( $data['label'] ); ?>">
					<span class="mega-panel__rail-label"><?php esc_html_e( 'Choose a direction', 'nolan-young-demo-theme-002' ); ?></span>
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
						<span><?php esc_html_e( 'Live capability view', 'nolan-young-demo-theme-002' ); ?></span>
						<span><?php esc_html_e( 'Available', 'nolan-young-demo-theme-002' ); ?></span>
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
				<a href="<?php echo esc_url( nydemo002_primary_menu_url( 'work', '/work/' ) ); ?>">
					<span><?php esc_html_e( 'See the evidence in our work', 'nolan-young-demo-theme-002' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a href="<?php echo esc_url( nydemo002_primary_menu_url( 'blog', '/journal/' ) ); ?>">
					<span><?php esc_html_e( 'Read the latest field notes', 'nolan-young-demo-theme-002' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a href="<?php echo esc_url( nydemo002_page_url( 'contact-us' ) ); ?>">
					<span><?php esc_html_e( 'Discuss the right first move', 'nolan-young-demo-theme-002' ); ?></span>
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
function nydemo002_render_blog_panel() {
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
		<button class="site-menu__trigger" type="button" aria-expanded="false" aria-controls="nydemo002-mega-blog" data-mega-trigger>
			<span><?php esc_html_e( 'Blog', 'nolan-young-demo-theme-002' ); ?></span>
			<svg viewBox="0 0 12 12" aria-hidden="true"><path d="M2 4.25 6 8l4-3.75"/></svg>
		</button>
		<div id="nydemo002-mega-blog" class="mega-panel mega-panel--blog" data-mega-panel>
			<div class="mega-panel__context content-wrap">
				<div>
					<strong><?php esc_html_e( 'Journal', 'nolan-young-demo-theme-002' ); ?></strong>
					<span><?php esc_html_e( 'Strategy, experience, engineering, and operations', 'nolan-young-demo-theme-002' ); ?></span>
				</div>
				<a href="<?php echo esc_url( nydemo002_primary_menu_url( 'blog', '/journal/' ) ); ?>">
					<?php esc_html_e( 'Open the editorial index', 'nolan-young-demo-theme-002' ); ?>
					<span aria-hidden="true"> ↗</span>
				</a>
			</div>
			<div class="mega-panel__blog content-wrap">
				<header>
					<div>
						<p class="eyebrow"><?php esc_html_e( 'Latest intelligence', 'nolan-young-demo-theme-002' ); ?></p>
						<h2><?php esc_html_e( 'Ideas for teams building what comes next.', 'nolan-young-demo-theme-002' ); ?></h2>
					</div>
					<a class="text-link" href="<?php echo esc_url( nydemo002_primary_menu_url( 'blog', '/journal/' ) ); ?>">
						<?php esc_html_e( 'View all articles', 'nolan-young-demo-theme-002' ); ?> <span aria-hidden="true">→</span>
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
									<span class="text-link"><?php esc_html_e( 'Read article', 'nolan-young-demo-theme-002' ); ?> →</span>
								</a>
							</article>
						<?php endwhile; ?>
					<?php else : ?>
						<article class="mega-blog-card mega-blog-card--empty">
							<span class="mega-blog-card__visual" aria-hidden="true">01</span>
							<p class="eyebrow"><?php esc_html_e( 'Journal', 'nolan-young-demo-theme-002' ); ?></p>
							<h3><?php esc_html_e( 'Publish the first insight to populate this live panel.', 'nolan-young-demo-theme-002' ); ?></h3>
						</article>
					<?php endif; ?>
				</div>
			</div>
			<div class="mega-panel__utility content-wrap">
				<a href="<?php echo esc_url( home_url( '/?s=strategy' ) ); ?>">
					<span><?php esc_html_e( 'Explore strategy', 'nolan-young-demo-theme-002' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a href="<?php echo esc_url( home_url( '/?s=wordpress' ) ); ?>">
					<span><?php esc_html_e( 'Explore WordPress', 'nolan-young-demo-theme-002' ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
				<a href="<?php echo esc_url( nydemo002_page_url( 'contact-us' ) ); ?>">
					<span><?php esc_html_e( 'Turn an idea into a working session', 'nolan-young-demo-theme-002' ); ?></span>
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
function nydemo002_primary_menu_fallback( $args = array() ) {
	$menu_class = isset( $args['menu_class'] ) ? (string) $args['menu_class'] : 'site-menu site-menu--native';
	?>
	<ul class="<?php echo esc_attr( $menu_class ); ?>">
		<li class="menu-item menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Services', 'nolan-young-demo-theme-002' ); ?></a>
			<ul class="sub-menu">
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#website-development' ) ); ?>"><?php esc_html_e( 'Website Development', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#plugin-development' ) ); ?>"><?php esc_html_e( 'Plugin Development', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#seo' ) ); ?>"><?php esc_html_e( 'SEO', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#analytics' ) ); ?>"><?php esc_html_e( 'Analytics', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/services/#ai-development' ) ); ?>"><?php esc_html_e( 'AI Development', 'nolan-young-demo-theme-002' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About', 'nolan-young-demo-theme-002' ); ?></a>
			<ul class="sub-menu">
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/about-us/#story' ) ); ?>"><?php esc_html_e( 'About Us', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/about-us/#team' ) ); ?>"><?php esc_html_e( 'Meet the Team', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/about-us/#careers' ) ); ?>"><?php esc_html_e( 'Careers', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/about-us/#future' ) ); ?>"><?php esc_html_e( 'Future Work', 'nolan-young-demo-theme-002' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/work/' ) ); ?>"><?php esc_html_e( 'Work', 'nolan-young-demo-theme-002' ); ?></a>
			<ul class="sub-menu">
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/work/#flagship-case' ) ); ?>"><?php esc_html_e( 'Flagship Case', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/work/#project-library' ) ); ?>"><?php esc_html_e( 'Project Library', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/work/#portfolio-results' ) ); ?>"><?php esc_html_e( 'Results', 'nolan-young-demo-theme-002' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/journal/' ) ); ?>"><?php esc_html_e( 'Blog', 'nolan-young-demo-theme-002' ); ?></a>
			<ul class="sub-menu">
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/journal/' ) ); ?>"><?php esc_html_e( 'Latest articles', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/?s=strategy' ) ); ?>"><?php esc_html_e( 'Strategy', 'nolan-young-demo-theme-002' ); ?></a></li>
				<li class="menu-item"><a href="<?php echo esc_url( home_url( '/?s=wordpress' ) ); ?>"><?php esc_html_e( 'WordPress', 'nolan-young-demo-theme-002' ); ?></a></li>
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
function nydemo002_primary_navigation() {
	$data = nydemo002_mega_menu_data();
	?>
	<nav id="site-navigation" class="site-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'nolan-young-demo-theme-002' ); ?>">
		<ul class="site-menu site-menu--enhanced">
			<?php nydemo002_render_services_panel( $data['services'] ); ?>
			<?php nydemo002_render_mega_panel( 'about', $data['about'] ); ?>
			<?php nydemo002_render_mega_panel( 'work', $data['work'] ); ?>
			<?php nydemo002_render_blog_panel(); ?>
		</ul>
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'site-menu site-menu--native',
				'depth'          => 2,
				'fallback_cb'    => 'nydemo002_primary_menu_fallback',
				'walker'         => new Walker_Nav_Menu(),
			)
		);
		?>
	</nav>
	<div class="mega-overlay" data-mega-overlay aria-hidden="true"></div>
	<?php
}
