<?php
namespace NYMegaMenu;

defined( 'ABSPATH' ) || exit;

class Admin {
	private $tabs = array(
		'general'  => 'General Settings',
		'menu-bar' => 'Menu Bar',
		'mega'     => 'Mega Menus',
		'flyout'   => 'Flyout Menus',
		'badges'   => 'Badges',
		'mobile'   => 'Mobile Menu',
		'custom'   => 'Custom Styling',
	);

	public function hooks() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_init', array( $this, 'settings' ) );
		add_action( 'admin_post_nymegamenu_theme_action', array( $this, 'theme_action' ) );
		add_action( 'admin_post_nymegamenu_clear_cache', array( $this, 'clear_cache' ) );
		add_action( 'admin_post_nymegamenu_delete_data', array( $this, 'delete_data' ) );
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'item_fields' ), 10, 5 );
		add_action( 'wp_update_nav_menu_item', array( $this, 'save_item' ), 10, 3 );
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
	}
	public function menu() {
		add_menu_page( __( 'NY Mega Menu', 'nymegamenu' ), __( 'NY Mega Menu', 'nymegamenu' ), 'edit_theme_options', 'nymegamenu', array( $this, 'locations_page_v2' ), 'dashicons-menu', 61 );
		foreach ( array(
			'nymegamenu'         => array( __( 'Menu Locations', 'nymegamenu' ), 'locations_page_v2' ),
			'nymegamenu-themes'  => array( __( 'Menu Themes', 'nymegamenu' ), 'themes_page' ),
			'nymegamenu-general' => array( __( 'General Settings', 'nymegamenu' ), 'general_page' ),
			'nymegamenu-tools'   => array( __( 'Tools', 'nymegamenu' ), 'tools_page' ),
			'nymegamenu-license' => array( __( 'License', 'nymegamenu' ), 'license_page' ),
		) as $slug => $page ) {
			add_submenu_page( 'nymegamenu', $page[0], $page[0], 'edit_theme_options', $slug, array( $this, $page[1] ) ); } }
	public function settings() {
		register_setting( 'nymegamenu', Settings::OPTION, array( 'sanitize_callback' => array( 'NYMegaMenu\\Settings', 'sanitize' ) ) ); }
	public function assets( $hook ) {
		if ( false === strpos( $hook, 'nav-menus' ) && false === strpos( $hook, 'nymegamenu' ) ) {
			return; }
		wp_enqueue_style( 'nymegamenu-admin', NYMEGAMENU_URL . 'assets/admin.css', array(), NYMEGAMENU_VERSION );
		wp_enqueue_script( 'nymegamenu-admin', NYMEGAMENU_URL . 'assets/admin.js', array(), NYMEGAMENU_VERSION, true );
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This non-mutating value selects an admin editor tab.
		if ( false === strpos( $hook, 'nymegamenu-themes' ) || 'custom' !== sanitize_key( wp_unslash( $_GET['tab'] ?? '' ) ) ) {
			return; }
		$editor = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );
		if ( $editor ) {
			wp_localize_script( 'nymegamenu-admin', 'nymegaCustomEditor', $editor ); }
	}
	private function allowed() {
		return current_user_can( 'edit_theme_options' ); }
	private function page_url( $slug, $args = array() ) {
		return add_query_arg( $args, admin_url( 'admin.php?page=' . $slug ) ); }
	private function notice() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This non-mutating value selects a predefined notice.
		$notice   = sanitize_key( wp_unslash( $_GET['nymega_notice'] ?? '' ) );
		$messages = array(
			'cache-cleared'        => array( 'success', __( 'Legacy generated CSS files were removed.', 'nymegamenu' ) ),
			'data-deleted'         => array( 'success', __( 'NY Mega Menu settings and menu-item data were deleted.', 'nymegamenu' ) ),
			'theme-import-invalid' => array( 'error', __( 'The theme import must be a valid JSON file no larger than 1 MB.', 'nymegamenu' ) ),
			'theme-action-failed'  => array( 'error', __( 'The requested theme action could not be completed.', 'nymegamenu' ) ),
			'theme-in-use'         => array( 'error', __( 'Assign locations to another theme before deleting this theme.', 'nymegamenu' ) ),
		);
		if ( ! isset( $messages[ $notice ] ) ) {
			return;
		}

		printf( '<div class="notice notice-%1$s is-dismissible"><p>%2$s</p></div>', esc_attr( $messages[ $notice ][0] ), esc_html( $messages[ $notice ][1] ) );
	}
	private function shell( $active, $title, $description = '' ) {
		$pages = array(
			'nymegamenu'         => array( 'Menu Locations', 'dashicons-location' ),
			'nymegamenu-themes'  => array( 'Menu Themes', 'dashicons-art' ),
			'nymegamenu-general' => array( 'General Settings', 'dashicons-admin-generic' ),
			'nymegamenu-tools'   => array( 'Tools', 'dashicons-admin-tools' ),
			'nymegamenu-license' => array( 'License', 'dashicons-admin-network' ),
		); ?><div class="nymega-admin"><header class="nymega-admin__header"><div class="nymega-admin__brand"><span class="dashicons dashicons-menu"></span><strong><?php esc_html_e( 'NY Mega Menu', 'nymegamenu' ); ?></strong></div></header><div class="nymega-admin__layout"><aside class="nymega-admin__sidebar">
		<?php
		foreach ( $pages as $slug => $page ) :
			?>
		<a class="<?php echo $active === $slug ? 'is-active' : ''; ?>" href="<?php echo esc_url( $this->page_url( $slug ) ); ?>"><span class="dashicons <?php echo esc_attr( $page[1] ); ?>"></span><?php echo esc_html( $page[0] ); ?></a><?php endforeach; ?></aside><main class="nymega-admin__content"><h1><?php echo esc_html( $title ); ?></h1>
		<?php
		if ( $description ) :
			?>
	<p class="nymega-admin__intro"><?php echo esc_html( $description ); ?></p><?php endif; ?>
		<?php
	}
	private function close_shell() {
		echo '</main></div></div>'; }
	private function setting( $name, $value, $type = 'text' ) {
		printf( '<input type="%1$s" name="%2$s" value="%3$s">', esc_attr( $type ), esc_attr( $name ), esc_attr( $value ) ); }
	private function field( $label, $description, $control ) {

		?>
	<div class="nymega-form-row"><div><h2><?php echo esc_html( $label ); ?></h2><p><?php echo esc_html( $description ); ?></p></div><div class="nymega-field-control"><?php echo $control; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Controls are assembled from escaped values. ?></div></div>
		<?php
	}

	public function locations_page_v2() {
		if ( ! $this->allowed() ) {
			return; }
		$settings  = Settings::all();
		$locations = get_registered_nav_menus();
		$this->shell( 'nymegamenu', __( 'Menu Locations', 'nymegamenu' ) );
		?>
		<section class="nymega-locations-v2">
			<p class="nymega-admin__intro"><?php esc_html_e( 'This is an overview of the menu locations registered by your theme. Assign a menu under Appearance → Menus, then enable and configure NY Mega Menu for that location.', 'nymegamenu' ); ?></p>
			<p class="nymega-admin__intro"><?php esc_html_e( 'Use the toggle to enable a menu location. Select a location card to configure its desktop, mobile, theme, and display options.', 'nymegamenu' ); ?></p>
			<form method="post" action="options.php" class="nymega-location-form"><?php settings_fields( 'nymegamenu' ); ?>
				<div class="nymega-location-grid nymega-location-grid--summary">
				<?php
				foreach ( $locations as $key => $label ) :
					$profile  = Settings::location( $key );
					$menu     = get_nav_menu_locations();
					$assigned = ! empty( $menu[ $key ] ) ? wp_get_nav_menu_object( $menu[ $key ] ) : false;
					?>
					<article class="nymega-location-card">
						<button type="button" class="nymega-location-card__open" data-nymega-location-open="<?php echo esc_attr( $key ); ?>" aria-controls="nymega-location-modal-<?php echo esc_attr( $key ); ?>" aria-haspopup="dialog"><span class="screen-reader-text"><?php esc_html_e( 'Configure', 'nymegamenu' ); ?> </span><span><span class="dashicons dashicons-location" aria-hidden="true"></span><?php echo esc_html( $label ); ?></span><span><?php esc_html_e( 'Assigned menu:', 'nymegamenu' ); ?> <strong><?php echo esc_html( $assigned ? $assigned->name : __( 'None assigned', 'nymegamenu' ) ); ?></strong></span></button>
						<?php /* translators: %s: registered menu location label. */ ?>
						<label class="nymega-switch" aria-label="<?php echo esc_attr( sprintf( __( 'Enable %s', 'nymegamenu' ), $label ) ); ?>"><input type="checkbox" name="nymegamenu_settings[locations][<?php echo esc_attr( $key ); ?>][enabled]" value="1" <?php checked( ! empty( $profile['enabled'] ) ); ?>><span></span></label>
					</article>
					<?php $this->location_modal( $key, $label, $profile, $settings['themes'], $assigned ); ?>
				<?php endforeach; ?>
				</div>
				<footer class="nymega-location-savebar"><button type="submit" class="button button-primary nymega-button"><?php esc_html_e( 'Save Menu Locations', 'nymegamenu' ); ?></button></footer>
			</form>
		</section>
		<?php
		$this->close_shell();
	}

	private function location_modal( $key, $label, $profile, $themes, $assigned ) {
		$base = 'nymegamenu_settings[locations][' . $key . ']';
		$tabs = array(
			'desktop'  => array( 'Desktop', 'dashicons-desktop' ),
			'mobile'   => array( 'Mobile', 'dashicons-smartphone' ),
			'theme'    => array( 'Theme', 'dashicons-admin-appearance' ),
			'sticky'   => array( 'Sticky', 'dashicons-admin-links' ),
			'overlay'  => array( 'Page Overlay', 'dashicons-fullscreen-alt' ),
			'advanced' => array( 'Advanced', 'dashicons-admin-tools' ),
			'display'  => array( 'Display Options', 'dashicons-visibility' ),
		);
		?>
		<div id="nymega-location-modal-<?php echo esc_attr( $key ); ?>" class="nymega-location-modal" hidden>
			<div class="nymega-location-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="nymega-location-title-<?php echo esc_attr( $key ); ?>">
				<header class="nymega-location-modal__header"><div><h2 id="nymega-location-title-<?php echo esc_attr( $key ); ?>"><span class="dashicons dashicons-location"></span><?php echo esc_html( $label ); ?></h2><p><?php esc_html_e( 'Assigned menu:', 'nymegamenu' ); ?> <strong><?php echo esc_html( $assigned ? $assigned->name : __( 'None assigned', 'nymegamenu' ) ); ?></strong></p></div><button type="button" class="nymega-location-modal__close" data-nymega-location-close aria-label="<?php esc_attr_e( 'Close settings', 'nymegamenu' ); ?>">×</button></header>
				<div class="nymega-location-modal__body"><nav class="nymega-location-modal__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Location settings', 'nymegamenu' ); ?>">
				<?php
				foreach ( $tabs as $tab => $tab_data ) :
					?>
					<button type="button" id="nymega-location-tab-<?php echo esc_attr( $key . '-' . $tab ); ?>" class="<?php echo 'desktop' === $tab ? 'is-active' : ''; ?>" role="tab" data-nymega-location-tab="<?php echo esc_attr( $tab ); ?>" aria-controls="nymega-location-panel-<?php echo esc_attr( $key . '-' . $tab ); ?>" aria-selected="<?php echo 'desktop' === $tab ? 'true' : 'false'; ?>" tabindex="<?php echo 'desktop' === $tab ? '0' : '-1'; ?>"><span class="dashicons <?php echo esc_attr( $tab_data[1] ); ?>" aria-hidden="true"></span><?php echo esc_html( $tab_data[0] ); ?></button><?php endforeach; ?></nav>
					<div class="nymega-location-modal__panels">
						<section id="nymega-location-panel-<?php echo esc_attr( $key ); ?>-desktop" data-nymega-location-panel="desktop" class="is-active" role="tabpanel" aria-labelledby="nymega-location-tab-<?php echo esc_attr( $key ); ?>-desktop">
						<?php
						$this->location_select(
							$base . '[trigger]',
							__( 'Event', 'nymegamenu' ),
							__( 'Select the event to trigger sub menus.', 'nymegamenu' ),
							$profile['trigger'],
							array(
								'click'        => 'Click',
								'hover'        => 'Hover',
								'hover-intent' => 'Hover Intent',
							)
						);
																						$this->location_select(
																							$base . '[desktop_effect]',
																							__( 'Sub Menu Effect', 'nymegamenu' ),
																							__( 'Select the desktop sub menu animation type.', 'nymegamenu' ),
																							$profile['desktop_effect'],
																							array(
																								'fade'  => 'Fade Up',
																								'slide' => 'Slide Down',
																								'none'  => 'None',
																							),
																							$base . '[desktop_speed]',
																							__( 'Speed', 'nymegamenu' ),
																							$profile['desktop_speed'],
																							array(
																								'fast'   => 'Fast',
																								'medium' => 'Medium',
																								'slow'   => 'Slow',
																							)
																						);
																						$this->location_select(
																							$base . '[layout]',
																							__( 'Orientation', 'nymegamenu' ),
																							__( 'Choose how top-level menu items are arranged.', 'nymegamenu' ),
																							$profile['layout'],
																							array(
																								'horizontal' => 'Horizontal',
																								'vertical'   => 'Vertical',
																								'accordion'  => 'Accordion',
																							)
																						);
						?>
																						</section>
						<section id="nymega-location-panel-<?php echo esc_attr( $key ); ?>-mobile" data-nymega-location-panel="mobile" role="tabpanel" aria-labelledby="nymega-location-tab-<?php echo esc_attr( $key ); ?>-mobile" hidden>
						<?php
						$this->location_select(
							$base . '[mobile_type]',
							__( 'Mobile Menu', 'nymegamenu' ),
							__( 'Choose how this menu opens below the responsive breakpoint.', 'nymegamenu' ),
							$profile['mobile_type'],
							array(
								'show-hide'  => 'Show / Hide',
								'slide-down' => 'Slide Down',
								'offcanvas'  => 'Off Canvas',
							),
							$base . '[mobile_speed]',
							__( 'Speed', 'nymegamenu' ),
							$profile['mobile_speed'],
							array(
								'fast'   => 'Fast',
								'medium' => 'Medium',
								'slow'   => 'Slow',
							)
						);
																			$this->location_select(
																				$base . '[mobile_behavior]',
																				__( 'Accordion Behaviour', 'nymegamenu' ),
																				__( 'Choose whether one or multiple mobile submenus can stay open.', 'nymegamenu' ),
																				$profile['mobile_behavior'],
																				array(
																					'accordion' => 'Standard — open one submenu at a time',
																					'multiple'  => 'Multiple — allow several submenus',
																				)
																			);
																			$this->location_select(
																				$base . '[mobile_default_state]',
																				__( 'Sub Menu Default State', 'nymegamenu' ),
																				__( 'Define the default submenu state when the mobile menu is first visible.', 'nymegamenu' ),
																				$profile['mobile_default_state'],
																				array(
																					'collapsed' => 'Collapse all',
																					'expanded'  => 'Expand all',
																				)
																			);
						?>
																			</section>
						<section id="nymega-location-panel-<?php echo esc_attr( $key ); ?>-theme" data-nymega-location-panel="theme" role="tabpanel" aria-labelledby="nymega-location-tab-<?php echo esc_attr( $key ); ?>-theme" hidden><?php $this->location_select( $base . '[theme]', __( 'Menu Theme', 'nymegamenu' ), __( 'Choose a menu theme to be applied to this menu location.', 'nymegamenu' ), $profile['theme'], wp_list_pluck( $themes, 'name' ) ); ?><p class="nymega-location-help"><a href="<?php echo esc_url( $this->page_url( 'nymegamenu-themes', array( 'theme' => $profile['theme'] ) ) ); ?>"><?php esc_html_e( 'Open this theme in the theme editor', 'nymegamenu' ); ?> ↗</a></p></section>
						<section id="nymega-location-panel-<?php echo esc_attr( $key ); ?>-sticky" data-nymega-location-panel="sticky" role="tabpanel" aria-labelledby="nymega-location-tab-<?php echo esc_attr( $key ); ?>-sticky" hidden><?php $this->location_switch( $base . '[sticky]', __( 'Enabled', 'nymegamenu' ), __( 'Stick the menu for this location as the page scrolls.', 'nymegamenu' ), $profile['sticky'] ); ?></section>
						<section id="nymega-location-panel-<?php echo esc_attr( $key ); ?>-overlay" data-nymega-location-panel="overlay" role="tabpanel" aria-labelledby="nymega-location-tab-<?php echo esc_attr( $key ); ?>-overlay" hidden>
						<?php
						$this->location_switch( $base . '[overlay_desktop]', __( 'Desktop', 'nymegamenu' ), __( 'Dim the page background when the desktop menu is open. The overlay color is set in Menu Themes → General Settings.', 'nymegamenu' ), $profile['overlay_desktop'] );
						$this->location_switch( $base . '[overlay_mobile]', __( 'Mobile', 'nymegamenu' ), __( 'Dim the page background when the mobile menu is open.', 'nymegamenu' ), $profile['overlay_mobile'] );
						?>
						</section>
						<section id="nymega-location-panel-<?php echo esc_attr( $key ); ?>-advanced" data-nymega-location-panel="advanced" role="tabpanel" aria-labelledby="nymega-location-tab-<?php echo esc_attr( $key ); ?>-advanced" hidden>
						<?php
						$this->location_select(
							$base . '[click_behavior]',
							__( 'Click Event Behaviour', 'nymegamenu' ),
							__( 'Define how a desktop parent link with a submenu behaves.', 'nymegamenu' ),
							$profile['click_behavior'],
							array(
								'toggle-close'  => 'Use the parent link to open and close its submenu.',
								'toggle-follow' => 'First parent-link click opens; the next follows its URL.',
								'follow'        => 'Always follow the parent-link URL.',
							)
						);
						?>
																				</section>
						<section id="nymega-location-panel-<?php echo esc_attr( $key ); ?>-display" data-nymega-location-panel="display" role="tabpanel" aria-labelledby="nymega-location-tab-<?php echo esc_attr( $key ); ?>-display" hidden><div class="nymega-location-notice"><?php esc_html_e( 'This menu location is registered by your theme. Your theme already includes the code required to display this location.', 'nymegamenu' ); ?></div><dl class="nymega-display-list"><dt><?php esc_html_e( 'Block (Gutenberg)', 'nymegamenu' ); ?></dt><dd><?php esc_html_e( 'Add the NY Mega Menu block to any block-enabled area.', 'nymegamenu' ); ?></dd><dt><?php esc_html_e( 'PHP Function', 'nymegamenu' ); ?></dt><dd><code>&lt;?php nymegamenu_render_menu( array( 'theme_location' =&gt; '<?php echo esc_html( $key ); ?>' ) ); ?&gt;</code></dd><dt><?php esc_html_e( 'Shortcode', 'nymegamenu' ); ?></dt><dd><code>[nymegamenu location=<?php echo esc_html( $key ); ?>]</code></dd><dt><?php esc_html_e( 'Widget', 'nymegamenu' ); ?></dt><dd><?php esc_html_e( 'Add the NY Mega Menu widget to a widget area.', 'nymegamenu' ); ?></dd></dl></section>
					</div>
				</div>
				<footer class="nymega-location-modal__footer"><button type="button" class="button button-primary nymega-location-modal__save" data-nymega-location-save><?php esc_html_e( 'Save', 'nymegamenu' ); ?></button></footer>
			</div>
		</div>
		<?php
	}

	private function location_select( $name, $title, $description, $value, $options, $secondary_name = '', $secondary_title = '', $secondary_value = '', $secondary_options = array() ) {

		?>
	<div class="nymega-location-field"><div><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $description ); ?></p></div><div class="nymega-location-field__controls"><select name="<?php echo esc_attr( $name ); ?>">
		<?php
		foreach ( $options as $option => $option_label ) :
			?>
	<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $value, $option ); ?>><?php echo esc_html( $option_label ); ?></option><?php endforeach; ?></select>
		<?php
		if ( $secondary_name ) :
			?>
	<label><span><?php echo esc_html( $secondary_title ); ?></span><select name="<?php echo esc_attr( $secondary_name ); ?>">
			<?php
			foreach ( $secondary_options as $option => $option_label ) :
				?>
	<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $secondary_value, $option ); ?>><?php echo esc_html( $option_label ); ?></option><?php endforeach; ?></select></label><?php endif; ?></div></div>
		<?php
	}
	private function location_switch( $name, $title, $description, $checked ) {

		?>
	<div class="nymega-location-field"><div><h3><?php echo esc_html( $title ); ?></h3><p><?php echo esc_html( $description ); ?></p></div><label class="nymega-switch"><input type="checkbox" name="<?php echo esc_attr( $name ); ?>" value="1" <?php checked( $checked ); ?>><span></span></label></div>
		<?php
	}

	public function themes_page() {
		if ( ! $this->allowed() ) {
			return;
		} $settings = Settings::all();
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This non-mutating value selects an editor theme.
		$selected = sanitize_key( wp_unslash( $_GET['theme'] ?? 'default' ) );
		if ( ! isset( $settings['themes'][ $selected ] ) ) {
			$selected = array_key_first( $settings['themes'] );
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- This non-mutating value selects an editor tab.
		} $tab = sanitize_key( wp_unslash( $_GET['tab'] ?? 'general' ) );
		if ( ! isset( $this->tabs[ $tab ] ) ) {
			$tab = 'general';
		} $theme = $settings['themes'][ $selected ];
		$base    = 'nymegamenu_settings[themes][' . $selected . ']';
		$this->shell( 'nymegamenu-themes', __( 'Menu Themes', 'nymegamenu' ), __( 'Every control below is saved to the selected theme and converted to scoped frontend CSS.', 'nymegamenu' ) );
		$this->notice();
		?>
		<div class="nymega-theme-toolbar"><label><?php esc_html_e( 'Select theme to edit', 'nymegamenu' ); ?><select onchange="window.location=this.value">
		<?php
		foreach ( $settings['themes'] as $key => $saved ) :
			?>
			<option value="
			<?php
			echo esc_url(
				$this->page_url(
					'nymegamenu-themes',
					array(
						'theme' => $key,
						'tab'   => $tab,
					)
				)
			);
			?>
			" <?php selected( $selected, $key ); ?>><?php echo esc_html( $saved['name'] ); ?></option><?php endforeach; ?></select></label><div class="nymega-actions"><a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nymegamenu_theme_action&operation=create' ), 'nymegamenu_theme_action' ) ); ?>">New</a><a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nymegamenu_theme_action&operation=duplicate&theme=' . $selected ), 'nymegamenu_theme_action' ) ); ?>">Duplicate</a><a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nymegamenu_theme_action&operation=export&theme=' . $selected ), 'nymegamenu_theme_action' ) ); ?>">Export</a>
		<?php
		if ( 'default' !== $selected ) :
			?>
			<a class="button button-link-delete" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=nymegamenu_theme_action&operation=delete&theme=' . $selected ), 'nymegamenu_theme_action' ) ); ?>">Delete</a><?php endif; ?></div></div><form class="nymega-theme-editor-form" method="post" action="options.php" data-preview-url="<?php echo esc_url( home_url( '/' ) ); ?>"><?php settings_fields( 'nymegamenu' ); ?><input type="hidden" name="<?php echo esc_attr( $base . '[name]' ); ?>" value="<?php echo esc_attr( $theme['name'] ); ?>"><nav class="nymega-tabs">
			<?php
			foreach ( $this->tabs as $key => $label ) :
				?>
	<a class="<?php echo $tab === $key ? 'is-active' : ''; ?>" href="
				<?php
				echo esc_url(
					$this->page_url(
						'nymegamenu-themes',
						array(
							'theme' => $selected,
							'tab'   => $key,
						)
					)
				);
				?>
	"><?php echo esc_html( $label ); ?></a><?php endforeach; ?></nav><section class="nymega-settings-panel"><?php $this->theme_tab( $tab, $base, $theme ); ?></section><footer class="nymega-theme-savebar"><button type="submit" class="button button-primary nymega-button"><?php esc_html_e( 'Save', 'nymegamenu' ); ?></button><label class="nymega-switch"><input type="checkbox" name="nymegamenu_open_preview" value="1"><span></span></label><span><?php esc_html_e( 'Open preview after saving', 'nymegamenu' ); ?></span></footer></form><form class="nymega-import" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data"><input type="hidden" name="action" value="nymegamenu_theme_action"><input type="hidden" name="operation" value="import"><?php wp_nonce_field( 'nymegamenu_theme_action' ); ?><label><?php esc_html_e( 'Import theme JSON', 'nymegamenu' ); ?><input type="file" name="theme_file" accept="application/json,.json" required></label><button class="button">Import</button></form>
		<?php
		$this->close_shell();
	}

	private function theme_tab( $tab, $base, $theme ) {
		$input = function ( $path, $value, $type = 'text' ) use ( $base ) {
			return '<input type="' . esc_attr( $type ) . '" name="' . esc_attr( $base . $path ) . '" value="' . esc_attr( $value ) . '">';
		};
		if ( 'general' === $tab ) {
			$this->general_tab( $base, $theme ); }
		if ( 'menu-bar' === $tab ) {
			$this->menu_bar_tab( $base, $theme['menu_bar'] ); }
		if ( 'mega' === $tab ) {
			$this->mega_tab( $base, $theme['mega'] ); }
		if ( 'flyout' === $tab ) {
			$this->flyout_tab( $base, $theme['flyout'] ); }
		if ( 'badges' === $tab ) {
			$this->badges_tab( $base, $theme['badges'] ); }
		if ( 'mobile' === $tab ) {
			$this->mobile_tab( $base, $theme['mobile'] ); }
		if ( 'custom' === $tab ) {
			$this->custom_styling_tab( $base, $theme['custom_css'] ); }
	}
	private function general_tab( $base, $theme ) {
		$general = $theme['general'];
		$name    = function ( $key ) use ( $base ) {
			return $base . '[general][' . $key . ']';
		};
		$text    = function ( $key ) use ( $general, $name ) {
			return '<input type="text" name="' . esc_attr( $name( $key ) ) . '" value="' . esc_attr( $general[ $key ] ) . '">';
		};
		$check   = function ( $key ) use ( $general, $name ) {
			return '<input type="hidden" name="' . esc_attr( $name( $key ) ) . '" value="0"><input type="checkbox" name="' . esc_attr( $name( $key ) ) . '" value="1" ' . checked( $general[ $key ], 1, false ) . '>';
		};
		$control = function ( $label, $value ) {
			return $this->menu_bar_control( $label, $value );
		};
		$this->menu_bar_row( __( 'Theme Title', 'nymegamenu' ), __( 'The reusable name shown when assigning this theme to a menu location.', 'nymegamenu' ), $control( '', '<input type="text" name="' . esc_attr( $base . '[name]' ) . '" value="' . esc_attr( $theme['name'] ) . '">' ) );
		$arrow_options = array(
			'disabled' => __( 'Disabled', 'nymegamenu' ),
			'chevron'  => '⌄ ' . __( 'Chevron', 'nymegamenu' ),
			'caret'    => '▾ ' . __( 'Caret', 'nymegamenu' ),
			'arrow'    => '↓ ' . __( 'Arrow', 'nymegamenu' ),
			'plus'     => '+ ' . __( 'Plus', 'nymegamenu' ),
		);
		$arrow         = '<select class="nymega-arrow-picker" name="' . esc_attr( $name( 'arrow_icon' ) ) . '">';
		foreach ( $arrow_options as $value => $label ) {
			$arrow .= '<option value="' . esc_attr( $value ) . '" ' . selected( $general['arrow_icon'], $value, false ) . '>' . esc_html( $label ) . '</option>';
		} $arrow .= '</select>';
		$this->menu_bar_row( __( 'Arrows', 'nymegamenu' ), __( 'Select the arrow style used for menu items with a submenu.', 'nymegamenu' ), $control( __( 'Icon Set', 'nymegamenu' ), $arrow ) . $control( __( 'Rotate', 'nymegamenu' ), $check( 'arrow_rotate' ) ) );
		$font_options = array(
			'inherit'                      => __( 'Theme Default', 'nymegamenu' ),
			'system-ui, sans-serif'        => __( 'System UI', 'nymegamenu' ),
			'Arial, Helvetica, sans-serif' => 'Arial',
			'Georgia, serif'               => 'Georgia',
			'"Trebuchet MS", sans-serif'   => 'Trebuchet MS',
			'"Times New Roman", serif'     => 'Times New Roman',
			'monospace'                    => __( 'Monospace', 'nymegamenu' ),
		);
		$font_select  = '<select class="nymega-select" name="' . esc_attr( $name( 'font_family' ) ) . '">';
		foreach ( $font_options as $value => $label ) {
			$font_select .= '<option value="' . esc_attr( $value ) . '" ' . selected( $general['font_family'], $value, false ) . '>' . esc_html( $label ) . '</option>';
		} $font_select .= '</select>';
		$this->menu_bar_row( __( 'Menu Font Family', 'nymegamenu' ), __( 'Set the font family for the entire menu.', 'nymegamenu' ), $control( '', $font_select ) );
		$this->menu_bar_row( __( 'Line Height', 'nymegamenu' ), __( 'Set the general line height to use in submenu contents.', 'nymegamenu' ), $control( '', $text( 'line_height' ) ) );
		$this->menu_bar_row( __( 'Z Index', 'nymegamenu' ), __( 'Set the z-index to ensure submenus appear above other content.', 'nymegamenu' ), $control( '', '<input type="number" min="0" max="99999" name="' . esc_attr( $name( 'z_index' ) ) . '" value="' . esc_attr( $general['z_index'] ) . '">' ) );
		$this->menu_bar_row( __( 'Shadow', 'nymegamenu' ), __( 'Apply a shadow to mega and flyout menus.', 'nymegamenu' ), $control( __( 'Enabled', 'nymegamenu' ), $check( 'shadow_enabled' ) ) . $control( __( 'Horizontal', 'nymegamenu' ), $text( 'shadow_horizontal' ) ) . $control( __( 'Vertical', 'nymegamenu' ), $text( 'shadow_vertical' ) ) . $control( __( 'Blur', 'nymegamenu' ), $text( 'shadow_blur' ) ) . $control( __( 'Spread', 'nymegamenu' ), $text( 'shadow_spread' ) ) . $control( __( 'Color', 'nymegamenu' ), $this->menu_bar_color( $name( 'shadow_color' ), $general['shadow_color'] ) ) );
		$this->menu_bar_row( __( 'Keyboard Highlight Outline', 'nymegamenu' ), __( 'Set the outline style for menu items when they receive keyboard focus.', 'nymegamenu' ), $control( __( 'Color', 'nymegamenu' ), $this->menu_bar_color( $name( 'focus_color' ), $general['focus_color'] ) ) . $control( __( 'Width', 'nymegamenu' ), $text( 'focus_width' ) ) . $control( __( 'Offset', 'nymegamenu' ), $text( 'focus_offset' ) ) );
		$this->menu_bar_row( __( 'Page Overlay', 'nymegamenu' ), __( 'Set the page overlay color used when an enabled mobile drawer opens.', 'nymegamenu' ), $control( __( 'Color', 'nymegamenu' ), $this->menu_bar_color( $name( 'overlay_color' ), $general['overlay_color'] ) ) );
		$this->menu_bar_row( __( 'Hover Transitions', 'nymegamenu' ), __( 'Apply hover transitions to menu items.', 'nymegamenu' ), $control( __( 'Enabled', 'nymegamenu' ), $check( 'hover_transitions' ) ) );
		$this->menu_bar_row( __( 'Reset Widget Styling', 'nymegamenu' ), __( 'Reset inherited widget spacing inside mega panels.', 'nymegamenu' ), $control( __( 'Enabled', 'nymegamenu' ), $check( 'reset_widgets' ) ) );
	}
	private function custom_styling_tab( $base, $custom_css ) {

		?>
		<div class="nymega-custom-styling">
			<div class="nymega-custom-styling__intro"><h2><?php esc_html_e( 'CSS Editor', 'nymegamenu' ); ?></h2><p><?php esc_html_e( 'Define custom CSS for menus using this theme. Standard CSS and the documented NY Mega Menu tokens are supported.', 'nymegamenu' ); ?></p></div>
			<div class="nymega-custom-styling__editor"><textarea id="nymega-custom-css" name="<?php echo esc_attr( $base . '[custom_css]' ); ?>" rows="14" spellcheck="false" aria-describedby="nymega-custom-css-tips"><?php echo esc_textarea( $custom_css ); ?></textarea></div>
		</div>
		<section class="nymega-custom-tips" id="nymega-custom-css-tips">
			<h2><?php esc_html_e( 'Custom Styling Tips', 'nymegamenu' ); ?></h2>
			<p><?php esc_html_e( 'The editor stores CSS with the selected reusable theme. It is converted to the active menu location when WordPress generates frontend styles.', 'nymegamenu' ); ?></p>
			<ul>
				<li><code>#{$wrap}</code> <?php esc_html_e( 'targets the current menu wrapper.', 'nymegamenu' ); ?></li>
				<li><code>#{$menu}</code> <?php esc_html_e( 'targets the current menu list.', 'nymegamenu' ); ?></li>
				<li><code>@include mobile { ... }</code> <?php esc_html_e( 'wraps rules at each assigned location’s responsive breakpoint.', 'nymegamenu' ); ?></li>
				<li><code>@include desktop { ... }</code> <?php esc_html_e( 'applies rules above each assigned location’s responsive breakpoint.', 'nymegamenu' ); ?></li>
				<li><?php esc_html_e( 'The legacy {{wrapper}} and {{menu}} tokens continue to work.', 'nymegamenu' ); ?></li>
			</ul>
			<p><strong><?php esc_html_e( 'Example CSS', 'nymegamenu' ); ?></strong></p>
			<pre><code>/** All menu sizes */
			#{$wrap} #{$menu} &gt; .nymegamenu__item &gt; .nymegamenu__link {
				text-shadow: 1px 1px #000000;
			}

			/** Desktop only */
			@include desktop {
				#{$wrap} #{$menu} { gap: 1rem; }
			}</code></pre>
		</section>
		<?php
	}
	private function menu_bar_row( $title, $description, $controls, $row_class = '' ) {

		?>
	<div class="nymega-reference-row <?php echo esc_attr( $row_class ); ?>"><div class="nymega-reference-row__name"><h2><?php echo esc_html( $title ); ?></h2><p><?php echo esc_html( $description ); ?></p></div><div class="nymega-reference-row__value"><?php echo $controls; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Controls are assembled from escaped values. ?></div></div>
		<?php
	}
	private function menu_bar_control( $label, $control ) {
		return '<label class="nymega-reference-control"><span>' . esc_html( $label ) . '</span>' . $control . '</label>'; }
	private function menu_bar_color( $name, $value ) {
		return '<span class="nymega-color-control"><button type="button" class="nymega-color-swatch" data-nymega-color aria-label="' . esc_attr__( 'Choose color', 'nymegamenu' ) . '"><i style="background:' . esc_attr( $value ) . '"></i></button><input type="text" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" aria-label="' . esc_attr__( 'Color value', 'nymegamenu' ) . '"></span>'; }
	private function menu_bar_tab( $base, $bar ) {
		$name   = function ( $key ) use ( $base ) {
			return $base . '[menu_bar][' . $key . ']';
		};
		$text   = function ( $key ) use ( $bar, $name ) {
			return '<input type="text" name="' . esc_attr( $name( $key ) ) . '" value="' . esc_attr( $bar[ $key ] ) . '">';
		};
		$check  = function ( $key ) use ( $bar, $name ) {
			return '<input type="hidden" name="' . esc_attr( $name( $key ) ) . '" value="0"><input type="checkbox" name="' . esc_attr( $name( $key ) ) . '" value="1" ' . checked( $bar[ $key ], 1, false ) . '>';
		};
		$select = function ( $key, $options ) use ( $bar, $name ) {
			$html = '<select class="nymega-select" name="' . esc_attr( $name( $key ) ) . '">';
			foreach ( $options as $value => $label ) {
				$html .= '<option value="' . esc_attr( $value ) . '" ' . selected( $bar[ $key ], $value, false ) . '>' . esc_html( $label ) . '</option>';
			} return $html . '</select>';
		};

		$this->menu_bar_row( __( 'Menu Height', 'nymegamenu' ), __( 'Define the height of each top level menu item link. This value plus the Menu Padding (top and bottom) settings define the overall height of the menu bar.', 'nymegamenu' ), $this->menu_bar_control( '', $text( 'height' ) ) );
		$this->menu_bar_row( __( 'Menu Height (Sticky)', 'nymegamenu' ), __( 'The height used after a location configured as sticky reaches the top of the viewport.', 'nymegamenu' ), $this->menu_bar_control( __( 'Height', 'nymegamenu' ), $text( 'sticky_height' ) ) . $this->menu_bar_control( __( 'Transition', 'nymegamenu' ), $check( 'sticky_transition' ) ) );
		$this->menu_bar_row( __( 'Menu Background', 'nymegamenu' ), __( 'The background color for the main menu bar. Set each value to transparent for a button style menu.', 'nymegamenu' ), $this->menu_bar_control( __( 'From', 'nymegamenu' ), $this->menu_bar_color( $name( 'background_from' ), $bar['background_from'] ) ) . '<span class="nymega-copy-arrow" aria-hidden="true">→</span>' . $this->menu_bar_control( __( 'To', 'nymegamenu' ), $this->menu_bar_color( $name( 'background_to' ), $bar['background_to'] ) ) );
		$this->menu_bar_row( __( 'Menu Padding', 'nymegamenu' ), __( 'Padding for the main menu bar.', 'nymegamenu' ), $this->menu_bar_control( __( 'Top', 'nymegamenu' ), $text( 'padding_top' ) ) . $this->menu_bar_control( __( 'Right', 'nymegamenu' ), $text( 'padding_right' ) ) . $this->menu_bar_control( __( 'Bottom', 'nymegamenu' ), $text( 'padding_bottom' ) ) . $this->menu_bar_control( __( 'Left', 'nymegamenu' ), $text( 'padding_left' ) ) );
		$this->menu_bar_row( __( 'Menu Border Radius', 'nymegamenu' ), __( 'Set a border radius on the main menu bar.', 'nymegamenu' ), $this->menu_bar_control( __( 'Top Left', 'nymegamenu' ), $text( 'radius_top_left' ) ) . $this->menu_bar_control( __( 'Top Right', 'nymegamenu' ), $text( 'radius_top_right' ) ) . $this->menu_bar_control( __( 'Bottom Right', 'nymegamenu' ), $text( 'radius_bottom_right' ) ) . $this->menu_bar_control( __( 'Bottom Left', 'nymegamenu' ), $text( 'radius_bottom_left' ) ) );
		echo '<h2 class="nymega-reference-section">' . esc_html__( 'Top Level Menu Items', 'nymegamenu' ) . '</h2>';
		$this->menu_bar_row(
			__( 'Menu Items Align', 'nymegamenu' ),
			__( 'Align all menu items to the left (default), centrally or to the right.', 'nymegamenu' ),
			$this->menu_bar_control(
				'',
				$select(
					'items_align',
					array(
						'left'   => __( 'Left', 'nymegamenu' ),
						'center' => __( 'Center', 'nymegamenu' ),
						'right'  => __( 'Right', 'nymegamenu' ),
					)
				)
			) . '<p class="nymega-reference-info">ⓘ ' . esc_html__(
				'This option applies to all menu items. To align one item to the right, edit that menu item in Appearance → Menus.',
				'nymegamenu'
			) . '</p>'
		);
		$this->menu_bar_row(
			__( 'Item Font', 'nymegamenu' ),
			__( 'The font to use for each top level menu item.', 'nymegamenu' ),
			$this->menu_bar_control( __( 'Color', 'nymegamenu' ), $this->menu_bar_color( $name( 'item_color' ), $bar['item_color'] ) ) . $this->menu_bar_control( __( 'Size', 'nymegamenu' ), $text( 'item_font_size' ) ) . $this->menu_bar_control( __( 'Family', 'nymegamenu' ), $text( 'item_font_family' ) ) . $this->menu_bar_control(
				__( 'Transform', 'nymegamenu' ),
				$select(
					'item_text_transform',
					array(
						'none'       => __( 'Normal', 'nymegamenu' ),
						'uppercase'  => __( 'UPPERCASE', 'nymegamenu' ),
						'lowercase'  => __( 'lowercase', 'nymegamenu' ),
						'capitalize' => __( 'Capitalize', 'nymegamenu' ),
					)
				)
			) . $this->menu_bar_control(
				__( 'Weight', 'nymegamenu' ),
				$select(
					'item_font_weight',
					array(
						'normal' => __( 'Normal (400)', 'nymegamenu' ),
						'300'    => __( 'Light (300)', 'nymegamenu' ),
						'bold'   => __( 'Bold (700)', 'nymegamenu' ),
					)
				)
			) . $this->menu_bar_control(
				__( 'Decoration', 'nymegamenu' ),
				$select(
					'item_text_decoration',
					array(
						'none'      => __( 'None', 'nymegamenu' ),
						'underline' => __( 'Underline', 'nymegamenu' ),
					)
				)
			) . $this->menu_bar_control(
				__( 'Align', 'nymegamenu' ),
				$select(
					'item_text_align',
					array(
						'left'   => __( 'Left', 'nymegamenu' ),
						'center' => __( 'Center', 'nymegamenu' ),
						'right'  => __( 'Right', 'nymegamenu' ),
					)
				)
			)
		);
		$this->menu_bar_row(
			__( 'Item Font (Hover)', 'nymegamenu' ),
			__( 'Set the font to use for each top level menu item (on hover).', 'nymegamenu' ),
			$this->menu_bar_control( __( 'Color', 'nymegamenu' ), $this->menu_bar_color( $name( 'item_hover_color' ), $bar['item_hover_color'] ) ) . $this->menu_bar_control(
				__( 'Weight', 'nymegamenu' ),
				$select(
					'item_hover_font_weight',
					array(
						'normal' => __( 'Normal (400)', 'nymegamenu' ),
						'300'    => __( 'Light (300)', 'nymegamenu' ),
						'bold'   => __( 'Bold (700)', 'nymegamenu' ),
					)
				)
			) . $this->menu_bar_control(
				__( 'Decoration', 'nymegamenu' ),
				$select(
					'item_hover_text_decoration',
					array(
						'none'      => __( 'None', 'nymegamenu' ),
						'underline' => __( 'Underline', 'nymegamenu' ),
					)
				)
			)
		);
		$this->menu_bar_row( __( 'Item Background', 'nymegamenu' ), __( 'The background color for each top level menu item. Set these values to transparent if you have already set a background color on the menu bar.', 'nymegamenu' ), $this->menu_bar_control( __( 'From', 'nymegamenu' ), $this->menu_bar_color( $name( 'item_background_from' ), $bar['item_background_from'] ) ) . '<span class="nymega-copy-arrow" aria-hidden="true">→</span>' . $this->menu_bar_control( __( 'To', 'nymegamenu' ), $this->menu_bar_color( $name( 'item_background_to' ), $bar['item_background_to'] ) ) );
		$this->menu_bar_row( __( 'Item Background (Hover)', 'nymegamenu' ), __( 'The background color for a top level menu item (on hover).', 'nymegamenu' ), $this->menu_bar_control( __( 'From', 'nymegamenu' ), $this->menu_bar_color( $name( 'item_hover_background_from' ), $bar['item_hover_background_from'] ) ) . '<span class="nymega-copy-arrow" aria-hidden="true">→</span>' . $this->menu_bar_control( __( 'To', 'nymegamenu' ), $this->menu_bar_color( $name( 'item_hover_background_to' ), $bar['item_hover_background_to'] ) ) );
		$this->menu_bar_row( __( 'Item Spacing', 'nymegamenu' ), __( 'Define the size of the gap between each top level menu item.', 'nymegamenu' ), $this->menu_bar_control( '', $text( 'item_spacing' ) ) );
		$this->menu_bar_row( __( 'Item Padding', 'nymegamenu' ), __( 'Set the padding for each top level menu item.', 'nymegamenu' ), $this->menu_bar_control( __( 'Top', 'nymegamenu' ), $text( 'item_padding_top' ) ) . $this->menu_bar_control( __( 'Right', 'nymegamenu' ), $text( 'item_padding_right' ) ) . $this->menu_bar_control( __( 'Bottom', 'nymegamenu' ), $text( 'item_padding_bottom' ) ) . $this->menu_bar_control( __( 'Left', 'nymegamenu' ), $text( 'item_padding_left' ) ) . '<p class="nymega-reference-info">ⓘ ' . esc_html__( 'Use Menu Height to determine the height of top level menu items.', 'nymegamenu' ) . '</p>' );
		$this->menu_bar_row( __( 'Item Border', 'nymegamenu' ), __( 'Set the border to display on each top level menu item.', 'nymegamenu' ), $this->menu_bar_control( __( 'Color', 'nymegamenu' ), $this->menu_bar_color( $name( 'item_border_color' ), $bar['item_border_color'] ) ) . $this->menu_bar_control( __( 'Color (Hover)', 'nymegamenu' ), $this->menu_bar_color( $name( 'item_hover_border_color' ), $bar['item_hover_border_color'] ) ) . $this->menu_bar_control( __( 'Top', 'nymegamenu' ), $text( 'item_border_top' ) ) . $this->menu_bar_control( __( 'Right', 'nymegamenu' ), $text( 'item_border_right' ) ) . $this->menu_bar_control( __( 'Bottom', 'nymegamenu' ), $text( 'item_border_bottom' ) ) . $this->menu_bar_control( __( 'Left', 'nymegamenu' ), $text( 'item_border_left' ) ) );
		$this->menu_bar_row( __( 'Item Border Radius', 'nymegamenu' ), __( 'Set rounded corners for each top level menu item.', 'nymegamenu' ), $this->menu_bar_control( __( 'Top Left', 'nymegamenu' ), $text( 'item_radius_top_left' ) ) . $this->menu_bar_control( __( 'Top Right', 'nymegamenu' ), $text( 'item_radius_top_right' ) ) . $this->menu_bar_control( __( 'Bottom Right', 'nymegamenu' ), $text( 'item_radius_bottom_right' ) ) . $this->menu_bar_control( __( 'Bottom Left', 'nymegamenu' ), $text( 'item_radius_bottom_left' ) ) );
		$this->menu_bar_row( __( 'Item Divider', 'nymegamenu' ), __( 'Show a small divider bar between each menu item.', 'nymegamenu' ), $this->menu_bar_control( __( 'Enabled', 'nymegamenu' ), $check( 'divider' ) ) . $this->menu_bar_control( __( 'Color', 'nymegamenu' ), $this->menu_bar_color( $name( 'divider_color' ), $bar['divider_color'] ) ) . $this->menu_bar_control( __( 'Glow Opacity', 'nymegamenu' ), $text( 'divider_glow_opacity' ) ) );
		$this->menu_bar_row( __( 'Highlight Current Item', 'nymegamenu' ), __( "Apply the 'hover' styling to current menu items. Applies to top level menu items only.", 'nymegamenu' ), $this->menu_bar_control( __( 'Enabled', 'nymegamenu' ), $check( 'current_item' ) ) . '<p class="nymega-reference-info">ⓘ ' . esc_html__( 'The hover color, background, border, and typography are used for the active item.', 'nymegamenu' ) . '</p>' );
	}
	private function mobile_tab( $base, $mobile ) {
		$n   = function ( $k ) use ( $base ) {
			return $base . '[mobile][' . $k . ']';
		};
		$t   = function ( $k ) use ( $n, $mobile ) {
			return '<input type="text" name="' . esc_attr( $n( $k ) ) . '" value="' . esc_attr( $mobile[ $k ] ) . '">';
		};
		$c   = function ( $k ) use ( $n, $mobile ) {
			return $this->menu_bar_color( $n( $k ), $mobile[ $k ] );
		};
		$x   = function ( $k ) use ( $n, $mobile ) {
			return '<input type="hidden" name="' . esc_attr( $n( $k ) ) . '" value="0"><input type="checkbox" name="' . esc_attr( $n( $k ) ) . '" value="1" ' . checked( $mobile[ $k ], 1, false ) . '>';
		};
		$q   = function ( $l, $v ) {
			return $this->menu_bar_control( $l, $v );
		};
		$box = function ( $p ) use ( $q, $t ) {
			return $q( __( 'Top', 'nymegamenu' ), $t( $p . 'top' ) ) . $q( __( 'Right', 'nymegamenu' ), $t( $p . 'right' ) ) . $q( __( 'Bottom', 'nymegamenu' ), $t( $p . 'bottom' ) ) . $q( __( 'Left', 'nymegamenu' ), $t( $p . 'left' ) );
		};
		echo '<h2 class="nymega-reference-section">' . esc_html__( 'Mobile Toggle Bar', 'nymegamenu' ) . '</h2>';
		$this->menu_bar_row( __( 'Toggle Bar Designer', 'nymegamenu' ), __( 'Configure the mobile toggle label. The default submenu state is configured per menu location.', 'nymegamenu' ), $q( __( 'Label', 'nymegamenu' ), $t( 'toggle_label' ) ) );
		$this->menu_bar_row( __( 'Toggle Bar Background', 'nymegamenu' ), __( 'Set the background color for the mobile menu toggle bar.', 'nymegamenu' ), $q( __( 'From', 'nymegamenu' ), $c( 'toggle_background_from' ) ) . '<span class="nymega-copy-arrow">→</span>' . $q( __( 'To', 'nymegamenu' ), $c( 'toggle_background_to' ) ) );
		$this->menu_bar_row( __( 'Toggle Bar Height', 'nymegamenu' ), __( 'Set the height of the mobile menu toggle bar.', 'nymegamenu' ), $q( '', $t( 'toggle_height' ) ) );
		$this->menu_bar_row( __( 'Toggle Bar Border Radius', 'nymegamenu' ), __( 'Set a border radius on the mobile toggle bar.', 'nymegamenu' ), $q( __( 'Top Left', 'nymegamenu' ), $t( 'toggle_radius_top_left' ) ) . $q( __( 'Top Right', 'nymegamenu' ), $t( 'toggle_radius_top_right' ) ) . $q( __( 'Bottom Right', 'nymegamenu' ), $t( 'toggle_radius_bottom_right' ) ) . $q( __( 'Bottom Left', 'nymegamenu' ), $t( 'toggle_radius_bottom_left' ) ) );
		echo '<h2 class="nymega-reference-section">' . esc_html__( 'Mobile Sub Menu', 'nymegamenu' ) . '</h2>';
		$this->menu_bar_row( __( 'Menu Padding', 'nymegamenu' ), __( 'Padding for the mobile sub menu.', 'nymegamenu' ), $box( 'drawer_padding_' ) );
		$this->menu_bar_row( __( 'Menu Background', 'nymegamenu' ), __( 'The background color for the mobile menu.', 'nymegamenu' ), $q( __( 'From', 'nymegamenu' ), $c( 'drawer_background_from' ) ) . $q( __( 'To', 'nymegamenu' ), $c( 'drawer_background_to' ) ) );
		$this->menu_bar_row( __( 'Menu Item Background (Active)', 'nymegamenu' ), __( 'The background color when the submenu is open.', 'nymegamenu' ), $q( __( 'From', 'nymegamenu' ), $c( 'active_background_from' ) ) . $q( __( 'To', 'nymegamenu' ), $c( 'active_background_to' ) ) );
		$this->menu_bar_row( __( 'Font', 'nymegamenu' ), __( 'The font for each top-level mobile menu item.', 'nymegamenu' ), $q( __( 'Color', 'nymegamenu' ), $c( 'item_color' ) ) . $q( __( 'Size', 'nymegamenu' ), $t( 'item_size' ) ) . $q( __( 'Align', 'nymegamenu' ), $t( 'item_align' ) ) );
		$this->menu_bar_row( __( 'Font (Active)', 'nymegamenu' ), __( 'The font color when the submenu is open.', 'nymegamenu' ), $q( __( 'Color', 'nymegamenu' ), $c( 'item_active_color' ) ) );
		echo '<h2 class="nymega-reference-section">' . esc_html__( 'Mobile Sub Menu Position', 'nymegamenu' ) . '</h2>';
		$this->menu_bar_row( __( 'Drawer Positioning', 'nymegamenu' ), __( 'Position the compact drawer over page content instead of in the normal document flow. Enable the mobile location overlay separately when a page backdrop is required.', 'nymegamenu' ), $q( __( 'Overlay content', 'nymegamenu' ), $x( 'overlay_content' ) ) );
		$this->menu_bar_row( __( 'Force Full Width', 'nymegamenu' ), __( 'Match the mobile menu to the viewport width.', 'nymegamenu' ), $q( __( 'Enabled', 'nymegamenu' ), $x( 'force_full_width' ) ) );
		echo '<h2 class="nymega-reference-section">' . esc_html__( 'Off Canvas Settings', 'nymegamenu' ) . '</h2>';
		$this->menu_bar_row( __( 'Off Canvas Width', 'nymegamenu' ), __( 'The drawer width when using the off-canvas mobile menu.', 'nymegamenu' ), $q( '', $t( 'offcanvas_width' ) ) );
		$this->menu_bar_row( __( 'Mega Menu Columns', 'nymegamenu' ), __( 'Collapse mega menu content into this many columns on mobile.', 'nymegamenu' ), $q( '', $t( 'mega_columns' ) ) );
	}
	private function badges_tab( $base, $badges ) {
		$name    = function ( $key ) use ( $base ) {
			return $base . '[badges][' . $key . ']';
		};
		$text    = function ( $key ) use ( $badges, $name ) {
			return '<input type="text" name="' . esc_attr( $name( $key ) ) . '" value="' . esc_attr( $badges[ $key ] ) . '">';
		};
		$color   = function ( $key ) use ( $name, $badges ) {
			return $this->menu_bar_color( $name( $key ), $badges[ $key ] );
		};
		$control = function ( $label, $html ) {
			return $this->menu_bar_control( $label, $html );
		};
		echo '<h2 class="nymega-reference-section">' . esc_html__( 'General Badge Styling', 'nymegamenu' ) . '</h2><p class="nymega-reference-info">' . esc_html__( 'These styles apply to all badges.', 'nymegamenu' ) . '</p>';
		$this->menu_bar_row( __( 'Badge Border Radius', 'nymegamenu' ), __( 'Set rounded corners for badges.', 'nymegamenu' ), $control( __( 'Top Left', 'nymegamenu' ), $text( 'radius_top_left' ) ) . $control( __( 'Top Right', 'nymegamenu' ), $text( 'radius_top_right' ) ) . $control( __( 'Bottom Right', 'nymegamenu' ), $text( 'radius_bottom_right' ) ) . $control( __( 'Bottom Left', 'nymegamenu' ), $text( 'radius_bottom_left' ) ) );
		$this->menu_bar_row( __( 'Badge Padding', 'nymegamenu' ), __( 'Set the padding around text within badges.', 'nymegamenu' ), $control( __( 'Top', 'nymegamenu' ), $text( 'padding_top' ) ) . $control( __( 'Right', 'nymegamenu' ), $text( 'padding_right' ) ) . $control( __( 'Bottom', 'nymegamenu' ), $text( 'padding_bottom' ) ) . $control( __( 'Left', 'nymegamenu' ), $text( 'padding_left' ) ) );
		$this->menu_bar_row( __( 'Badge Vertical Offset', 'nymegamenu' ), __( 'Move badges vertically relative to the menu item text.', 'nymegamenu' ), $control( __( 'Offset', 'nymegamenu' ), $text( 'vertical_offset' ) ) );
		foreach ( array( 1, 2, 3, 4 ) as $style ) {
			/* translators: %s: badge style name. */
			echo '<h2 class="nymega-reference-section">' . esc_html( sprintf( __( 'Badge Style %s', 'nymegamenu' ), array( '', 'One', 'Two', 'Three', 'Four' )[ $style ] ) ) . '</h2>';
			/* translators: %d: badge style number. */
			$this->menu_bar_row( __( 'Background', 'nymegamenu' ), sprintf( __( 'Set the background color for badge style %d.', 'nymegamenu' ), $style ), $control( __( 'From', 'nymegamenu' ), $color( 'style_' . $style . '_background_from' ) ) . '<span class="nymega-copy-arrow">→</span>' . $control( __( 'To', 'nymegamenu' ), $color( 'style_' . $style . '_background_to' ) ) );
			/* translators: %d: badge style number. */
			$this->menu_bar_row( __( 'Font', 'nymegamenu' ), sprintf( __( 'Set the font for badge style %d.', 'nymegamenu' ), $style ), $control( __( 'Color', 'nymegamenu' ), $color( 'style_' . $style . '_color' ) ) . $control( __( 'Size', 'nymegamenu' ), $text( 'font_size' ) ) . $control( __( 'Family', 'nymegamenu' ), $text( 'font_family' ) ) . $control( __( 'Transform', 'nymegamenu' ), $text( 'font_transform' ) ) . $control( __( 'Weight', 'nymegamenu' ), $text( 'font_weight' ) ) . $control( __( 'Decoration', 'nymegamenu' ), $text( 'font_decoration' ) ) ); }
	}
	private function flyout_tab( $base, $flyout ) {
		$name        = function ( $key ) use ( $base ) {
			return $base . '[flyout][' . $key . ']';
		};
		$text        = function ( $key ) use ( $flyout, $name ) {
			return '<input type="text" name="' . esc_attr( $name( $key ) ) . '" value="' . esc_attr( $flyout[ $key ] ) . '">';
		};
		$check       = function ( $key ) use ( $flyout, $name ) {
			return '<input type="hidden" name="' . esc_attr( $name( $key ) ) . '" value="0"><input type="checkbox" name="' . esc_attr( $name( $key ) ) . '" value="1" ' . checked( $flyout[ $key ], 1, false ) . '>';
		};
		$select      = function ( $key, $options ) use ( $flyout, $name ) {
			$html = '<select name="' . esc_attr( $name( $key ) ) . '">';
			foreach ( $options as $value => $label ) {
				$html .= '<option value="' . esc_attr( $value ) . '" ' . selected( $flyout[ $key ], $value, false ) . '>' . esc_html( $label ) . '</option>';
			} return $html . '</select>';
		};
		$control     = function ( $label, $html ) {
			return $this->menu_bar_control( $label, $html );
		};
		$color       = function ( $key ) use ( $name, $flyout ) {
			return $this->menu_bar_color( $name( $key ), $flyout[ $key ] );
		};
		$box         = function ( $prefix ) use ( $control, $text ) {
			return $control( __( 'Top', 'nymegamenu' ), $text( $prefix . 'top' ) ) . $control( __( 'Right', 'nymegamenu' ), $text( $prefix . 'right' ) ) . $control( __( 'Bottom', 'nymegamenu' ), $text( $prefix . 'bottom' ) ) . $control( __( 'Left', 'nymegamenu' ), $text( $prefix . 'left' ) );
		};
		$weights     = array(
			'normal' => __( 'Normal (400)', 'nymegamenu' ),
			'300'    => __( 'Light (300)', 'nymegamenu' ),
			'bold'   => __( 'Bold (700)', 'nymegamenu' ),
		);
		$decorations = array(
			'none'      => __( 'None', 'nymegamenu' ),
			'underline' => __( 'Underline', 'nymegamenu' ),
		);
		$this->menu_bar_row( __( 'Sub Menu Background', 'nymegamenu' ), __( 'Set the background color for the flyout menu.', 'nymegamenu' ), $control( __( 'From', 'nymegamenu' ), $color( 'background_from' ) ) . '<span class="nymega-copy-arrow">→</span>' . $control( __( 'To', 'nymegamenu' ), $color( 'background_to' ) ) );
		$this->menu_bar_row( __( 'Sub Menu Width', 'nymegamenu' ), __( 'The width of each flyout menu.', 'nymegamenu' ), $control( '', $text( 'width' ) ) . '<p class="nymega-reference-info">ⓘ ' . esc_html__( 'Use max-content for a flexible width, or a value such as 250px, 15rem, or 10vw for a fixed width.', 'nymegamenu' ) . '</p>' );
		$this->menu_bar_row( __( 'Sub Menu Padding', 'nymegamenu' ), __( 'Set the padding for the whole flyout menu.', 'nymegamenu' ), $box( 'padding_' ) . '<p class="nymega-reference-info">ⓘ ' . esc_html__( 'For multi-level flyouts, set these values to 0.', 'nymegamenu' ) . '</p>' );
		$this->menu_bar_row( __( 'Sub Menu Border', 'nymegamenu' ), __( 'Set the border for the flyout menu.', 'nymegamenu' ), $control( __( 'Color', 'nymegamenu' ), $color( 'border_color' ) ) . $box( 'border_' ) );
		$this->menu_bar_row( __( 'Sub Menu Border Radius', 'nymegamenu' ), __( 'Set rounded corners for flyout menus. Rounded corners are applied to all flyout menu levels.', 'nymegamenu' ), $control( __( 'Top Left', 'nymegamenu' ), $text( 'radius_top_left' ) ) . $control( __( 'Top Right', 'nymegamenu' ), $text( 'radius_top_right' ) ) . $control( __( 'Bottom Right', 'nymegamenu' ), $text( 'radius_bottom_right' ) ) . $control( __( 'Bottom Left', 'nymegamenu' ), $text( 'radius_bottom_left' ) ) );
		$this->menu_bar_row( __( 'Menu Item Background', 'nymegamenu' ), __( 'Set the background color for a flyout menu item.', 'nymegamenu' ), $control( __( 'From', 'nymegamenu' ), $color( 'item_background_from' ) ) . '<span class="nymega-copy-arrow">→</span>' . $control( __( 'To', 'nymegamenu' ), $color( 'item_background_to' ) ) );
		$this->menu_bar_row( __( 'Menu Item Background (Hover)', 'nymegamenu' ), __( 'Set the background color for a flyout menu item on hover.', 'nymegamenu' ), $control( __( 'From', 'nymegamenu' ), $color( 'item_hover_background_from' ) ) . '<span class="nymega-copy-arrow">→</span>' . $control( __( 'To', 'nymegamenu' ), $color( 'item_hover_background_to' ) ) );
		$this->menu_bar_row( __( 'Menu Item Height', 'nymegamenu' ), __( 'The height of each flyout menu item.', 'nymegamenu' ), $control( '', $text( 'item_height' ) ) );
		$this->menu_bar_row( __( 'Menu Item Padding', 'nymegamenu' ), __( 'Set the padding for each flyout menu item.', 'nymegamenu' ), $box( 'item_padding_' ) );
		$this->menu_bar_row(
			__( 'Menu Item Font', 'nymegamenu' ),
			__( 'Set the font for the flyout menu items.', 'nymegamenu' ),
			$control( __( 'Color', 'nymegamenu' ), $color( 'item_color' ) ) . $control( __( 'Size', 'nymegamenu' ), $text( 'item_size' ) ) . $control( __( 'Family', 'nymegamenu' ), $text( 'item_family' ) ) . $control(
				__( 'Transform', 'nymegamenu' ),
				$select(
					'item_transform',
					array(
						'none'      => __( 'Normal', 'nymegamenu' ),
						'uppercase' => __( 'UPPERCASE', 'nymegamenu' ),
						'lowercase' => __( 'lowercase', 'nymegamenu' ),
					)
				)
			) . $control(
				__(
					'Weight',
					'nymegamenu'
				),
				$select( 'item_weight', $weights )
			) . $control(
				__(
					'Decoration',
					'nymegamenu'
				),
				$select( 'item_decoration', $decorations )
			)
		);
		$this->menu_bar_row( __( 'Menu Item Font (Hover)', 'nymegamenu' ), __( 'Set the font for flyout menu items on hover.', 'nymegamenu' ), $control( __( 'Color', 'nymegamenu' ), $color( 'item_hover_color' ) ) . $control( __( 'Weight', 'nymegamenu' ), $select( 'item_hover_weight', $weights ) ) . $control( __( 'Decoration', 'nymegamenu' ), $select( 'item_hover_decoration', $decorations ) ) );
		$this->menu_bar_row( __( 'Menu Item Divider', 'nymegamenu' ), __( 'Show a line divider below each menu item.', 'nymegamenu' ), $control( __( 'Enabled', 'nymegamenu' ), $check( 'item_divider' ) ) . $control( __( 'Color', 'nymegamenu' ), $color( 'item_divider_color' ) ) );
	}
	private function mega_tab( $base, $mega ) {
		$name               = function ( $key ) use ( $base ) {
			return $base . '[mega][' . $key . ']';
		};
		$text               = function ( $key ) use ( $mega, $name ) {
			return '<input type="text" name="' . esc_attr( $name( $key ) ) . '" value="' . esc_attr( $mega[ $key ] ) . '">';
		};
		$check              = function ( $key ) use ( $mega, $name ) {
			return '<input type="hidden" name="' . esc_attr( $name( $key ) ) . '" value="0"><input type="checkbox" name="' . esc_attr( $name( $key ) ) . '" value="1" ' . checked( $mega[ $key ], 1, false ) . '>';
		};
		$select             = function ( $key, $options ) use ( $mega, $name ) {
			$html = '<select name="' . esc_attr( $name( $key ) ) . '">';
			foreach ( $options as $value => $label ) {
				$html .= '<option value="' . esc_attr( $value ) . '" ' . selected( $mega[ $key ], $value, false ) . '>' . esc_html( $label ) . '</option>';
			} return $html . '</select>';
		};
		$control            = function ( $label, $html ) {
			return $this->menu_bar_control( $label, $html );
		};
		$box                = function ( $prefix, $labels ) use ( $control, $text ) {
			$html = '';
			foreach ( $labels as $suffix => $label ) {
				$html .= $control( $label, $text( $prefix . $suffix ) );
			} return $html;
		};
		$color              = function ( $key ) use ( $name, $mega ) {
			return $this->menu_bar_color( $name( $key ), $mega[ $key ] );
		};
		$font_options       = array(
			'inherit'                      => __( 'Menu Font Family', 'nymegamenu' ),
			'Arial, Helvetica, sans-serif' => 'Arial',
			'Georgia, serif'               => 'Georgia',
			'system-ui, sans-serif'        => __( 'System UI', 'nymegamenu' ),
		);
		$transform_options  = array(
			'none'       => __( 'Normal', 'nymegamenu' ),
			'uppercase'  => __( 'UPPERCASE', 'nymegamenu' ),
			'lowercase'  => __( 'lowercase', 'nymegamenu' ),
			'capitalize' => __( 'Capitalize', 'nymegamenu' ),
		);
		$weight_options     = array(
			'normal' => __( 'Normal (400)', 'nymegamenu' ),
			'300'    => __( 'Light (300)', 'nymegamenu' ),
			'bold'   => __( 'Bold (700)', 'nymegamenu' ),
		);
		$decoration_options = array(
			'none'      => __( 'None', 'nymegamenu' ),
			'underline' => __( 'Underline', 'nymegamenu' ),
		);
		$this->menu_bar_row( __( 'Panel Width', 'nymegamenu' ), __( 'Configure the width of the sub menu.', 'nymegamenu' ), $control( __( 'Outer Width', 'nymegamenu' ), $text( 'outer_width' ) ) . $control( __( 'Inner Width', 'nymegamenu' ), $text( 'inner_width' ) ) . '<p class="nymega-reference-info">ⓘ ' . esc_html__( 'Use 100vw for a full-width panel, 100% for the menu width, or body to align it with the viewport.', 'nymegamenu' ) . '</p>' );
		$this->menu_bar_row( __( 'Panel Background', 'nymegamenu' ), __( 'Set a background color for the whole sub menu.', 'nymegamenu' ), $control( __( 'From', 'nymegamenu' ), $color( 'background_from' ) ) . '<span class="nymega-copy-arrow">→</span>' . $control( __( 'To', 'nymegamenu' ), $color( 'background_to' ) ) );
		$this->menu_bar_row(
			__( 'Panel Padding', 'nymegamenu' ),
			__( 'Set the padding for the whole sub menu. Set these values to 0 if you wish the content to go edge-to-edge.', 'nymegamenu' ),
			$box(
				'padding_',
				array(
					'top'    => __( 'Top', 'nymegamenu' ),
					'right'  => __( 'Right', 'nymegamenu' ),
					'bottom' => __( 'Bottom', 'nymegamenu' ),
					'left'   => __( 'Left', 'nymegamenu' ),
				)
			)
		);
		$this->menu_bar_row(
			__( 'Panel Border', 'nymegamenu' ),
			__( 'Set the border to display on the sub menu.', 'nymegamenu' ),
			$control( __( 'Color', 'nymegamenu' ), $color( 'border_color' ) ) . $box(
				'border_',
				array(
					'top'    => __( 'Top', 'nymegamenu' ),
					'right'  => __( 'Right', 'nymegamenu' ),
					'bottom' => __( 'Bottom', 'nymegamenu' ),
					'left'   => __( 'Left', 'nymegamenu' ),
				)
			)
		);
		$this->menu_bar_row(
			__( 'Panel Border Radius', 'nymegamenu' ),
			__( 'Set rounded corners for the sub menu.', 'nymegamenu' ),
			$box(
				'radius_',
				array(
					'top_left'     => __( 'Top Left', 'nymegamenu' ),
					'top_right'    => __( 'Top Right', 'nymegamenu' ),
					'bottom_right' => __( 'Bottom Right', 'nymegamenu' ),
					'bottom_left'  => __( 'Bottom Left', 'nymegamenu' ),
				)
			)
		);
		$this->menu_bar_row(
			__( 'Column Padding', 'nymegamenu' ),
			__( 'Define the space around each widget or set of menu items within the sub menu.', 'nymegamenu' ),
			$box(
				'column_padding_',
				array(
					'top'    => __( 'Top', 'nymegamenu' ),
					'right'  => __( 'Right', 'nymegamenu' ),
					'bottom' => __( 'Bottom', 'nymegamenu' ),
					'left'   => __( 'Left', 'nymegamenu' ),
				)
			)
		);
		echo '<h2 class="nymega-reference-section">' . esc_html__( 'Widgets', 'nymegamenu' ) . '</h2>';
		$this->menu_bar_row(
			__( 'Title Font', 'nymegamenu' ),
			__( 'Set the font to use for widget headers in the mega menu.', 'nymegamenu' ),
			$control( __( 'Color', 'nymegamenu' ), $color( 'widget_title_color' ) ) . $control( __( 'Size', 'nymegamenu' ), $text( 'widget_title_size' ) ) . $control( __( 'Family', 'nymegamenu' ), $select( 'widget_title_family', $font_options ) ) . $control( __( 'Transform', 'nymegamenu' ), $select( 'widget_title_transform', $transform_options ) ) . $control( __( 'Weight', 'nymegamenu' ), $select( 'widget_title_weight', $weight_options ) ) . $control( __( 'Decoration', 'nymegamenu' ), $select( 'widget_title_decoration', $decoration_options ) ) . $control(
				__( 'Align', 'nymegamenu' ),
				$select(
					'widget_title_align',
					array(
						'left'   => __( 'Left', 'nymegamenu' ),
						'center' => __( 'Center', 'nymegamenu' ),
						'right'  => __( 'Right', 'nymegamenu' ),
					)
				)
			)
		);
		$this->menu_bar_row(
			__( 'Title Padding', 'nymegamenu' ),
			__( 'Set the padding for the widget headings.', 'nymegamenu' ),
			$box(
				'widget_title_padding_',
				array(
					'top'    => __( 'Top', 'nymegamenu' ),
					'right'  => __( 'Right', 'nymegamenu' ),
					'bottom' => __( 'Bottom', 'nymegamenu' ),
					'left'   => __( 'Left', 'nymegamenu' ),
				)
			)
		);
		$this->menu_bar_row(
			__( 'Title Margin', 'nymegamenu' ),
			__( 'Set the margin for the widget headings.', 'nymegamenu' ),
			$box(
				'widget_title_margin_',
				array(
					'top'    => __( 'Top', 'nymegamenu' ),
					'right'  => __( 'Right', 'nymegamenu' ),
					'bottom' => __( 'Bottom', 'nymegamenu' ),
					'left'   => __( 'Left', 'nymegamenu' ),
				)
			)
		);
		$this->menu_bar_row(
			__( 'Title Border', 'nymegamenu' ),
			__( 'Set the border for the widget headings.', 'nymegamenu' ),
			$control( __( 'Color', 'nymegamenu' ), $color( 'widget_title_border_color' ) ) . $control( __( 'Color (Hover)', 'nymegamenu' ), $color( 'widget_title_hover_border_color' ) ) . $box(
				'widget_title_border_',
				array(
					'top'    => __( 'Top', 'nymegamenu' ),
					'right'  => __( 'Right', 'nymegamenu' ),
					'bottom' => __( 'Bottom', 'nymegamenu' ),
					'left'   => __( 'Left', 'nymegamenu' ),
				)
			)
		);
		$this->menu_bar_row( __( 'Content Font', 'nymegamenu' ), __( 'Set the font to use for panel contents.', 'nymegamenu' ), $control( __( 'Color', 'nymegamenu' ), $color( 'content_color' ) ) . $control( __( 'Size', 'nymegamenu' ), $text( 'content_size' ) ) . $control( __( 'Family', 'nymegamenu' ), $select( 'content_family', $font_options ) ) );
		$this->mega_level_fields( __( 'Second Level Menu Items', 'nymegamenu' ), 'second', $mega, $text, $select, $control, $color, $box, $font_options, $transform_options, $weight_options, $decoration_options );
		$this->mega_level_fields( __( 'Third Level Menu Items', 'nymegamenu' ), 'third', $mega, $text, $select, $control, $color, $box, $font_options, $transform_options, $weight_options, $decoration_options );
	}
	private function mega_level_fields( $heading, $prefix, $mega, $text, $select, $control, $color, $box, $font_options, $transform_options, $weight_options, $decoration_options ) {
		echo '<h2 class="nymega-reference-section">' . esc_html( $heading ) . '</h2>';
		$this->menu_bar_row(
			__( 'Item Font', 'nymegamenu' ),
			/* translators: %s: menu level heading. */
			sprintf( __( 'Set the font for %s.', 'nymegamenu' ), strtolower( $heading ) ),
			$control( __( 'Color', 'nymegamenu' ), $color( $prefix . '_color' ) ) . $control( __( 'Size', 'nymegamenu' ), $text( $prefix . '_size' ) ) . $control( __( 'Family', 'nymegamenu' ), $select( $prefix . '_family', $font_options ) ) . $control( __( 'Transform', 'nymegamenu' ), $select( $prefix . '_transform', $transform_options ) ) . $control( __( 'Weight', 'nymegamenu' ), $select( $prefix . '_weight', $weight_options ) ) . $control( __( 'Decoration', 'nymegamenu' ), $select( $prefix . '_decoration', $decoration_options ) ) . $control(
				__( 'Align', 'nymegamenu' ),
				$select(
					$prefix . '_align',
					array(
						'left'   => __( 'Left', 'nymegamenu' ),
						'center' => __( 'Center', 'nymegamenu' ),
						'right'  => __( 'Right', 'nymegamenu' ),
					)
				)
			)
		);
		$this->menu_bar_row( __( 'Item Font (Hover)', 'nymegamenu' ), __( 'Set the font style on hover.', 'nymegamenu' ), $control( __( 'Color', 'nymegamenu' ), $color( $prefix . '_hover_color' ) ) . $control( __( 'Weight', 'nymegamenu' ), $select( $prefix . '_hover_weight', $weight_options ) ) . $control( __( 'Decoration', 'nymegamenu' ), $select( $prefix . '_hover_decoration', $decoration_options ) ) );
		$this->menu_bar_row( __( 'Item Background (Hover)', 'nymegamenu' ), __( 'Set the background hover color for menu items.', 'nymegamenu' ), $control( __( 'From', 'nymegamenu' ), $color( $prefix . '_hover_background_from' ) ) . '<span class="nymega-copy-arrow">→</span>' . $control( __( 'To', 'nymegamenu' ), $color( $prefix . '_hover_background_to' ) ) );
		$this->menu_bar_row(
			__( 'Item Padding', 'nymegamenu' ),
			__( 'Set the padding for menu items.', 'nymegamenu' ),
			$box(
				$prefix . '_padding_',
				array(
					'top'    => __( 'Top', 'nymegamenu' ),
					'right'  => __( 'Right', 'nymegamenu' ),
					'bottom' => __( 'Bottom', 'nymegamenu' ),
					'left'   => __( 'Left', 'nymegamenu' ),
				)
			)
		);
		$this->menu_bar_row(
			__( 'Item Margin', 'nymegamenu' ),
			__( 'Set the margin for menu items.', 'nymegamenu' ),
			$box(
				$prefix . '_margin_',
				array(
					'top'    => __( 'Top', 'nymegamenu' ),
					'right'  => __( 'Right', 'nymegamenu' ),
					'bottom' => __( 'Bottom', 'nymegamenu' ),
					'left'   => __( 'Left', 'nymegamenu' ),
				)
			)
		);
		$this->menu_bar_row(
			__( 'Item Border', 'nymegamenu' ),
			__( 'Set the border for menu items.', 'nymegamenu' ),
			$control( __( 'Color', 'nymegamenu' ), $color( $prefix . '_border_color' ) ) . $control( __( 'Color (Hover)', 'nymegamenu' ), $color( $prefix . '_hover_border_color' ) ) . $box(
				$prefix . '_border_',
				array(
					'top'    => __( 'Top', 'nymegamenu' ),
					'right'  => __( 'Right', 'nymegamenu' ),
					'bottom' => __( 'Bottom', 'nymegamenu' ),
					'left'   => __( 'Left', 'nymegamenu' ),
				)
			)
		);
	}
	private function panel_style_fields( $base, $styles, $title, $description, $is_mega ) {
		$this->field( $title . ' width', $description, $this->setting( $base . '[width]', $is_mega ? $styles['outer_width'] : $styles['width'] ) . ( $is_mega ? $this->setting( $base . '[inner_width]', $styles['inner_width'] ) : '' ) );
		$this->field( $title . ' background', __( 'Gradient start and end colors.', 'nymegamenu' ), '<input type="color" name="' . esc_attr( $base . '[background_from]' ) . '" value="' . esc_attr( $styles['background_from'] ) . '"><input type="color" name="' . esc_attr( $base . '[background_to]' ) . '" value="' . esc_attr( $styles['background_to'] ) . '">' );
		$this->field( $title . ' spacing', __( 'Padding, border, and corner rounding.', 'nymegamenu' ), $this->setting( $base . '[padding_top]', $styles['padding_top'] ) . $this->setting( $base . '[padding_right]', $styles['padding_right'] ) . $this->setting( $base . '[padding_bottom]', $styles['padding_bottom'] ) . $this->setting( $base . '[padding_left]', $styles['padding_left'] ) . '<input type="color" name="' . esc_attr( $base . '[border_color]' ) . '" value="' . esc_attr( $styles['border_color'] ) . '">' . $this->setting( $base . '[border_width]', $styles['border_width'] ) . $this->setting( $base . '[radius]', $styles['radius'] ) . ( $is_mega ? $this->setting( $base . '[columns_gap]', $styles['columns_gap'] ) : '' ) ); }

	private function new_theme_key( $themes ) {
		do {
			$key = 'theme-' . wp_generate_uuid4();
		} while ( isset( $themes[ $key ] ) );
		return $key; }
	public function theme_action() {
		if ( ! $this->allowed() ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'nymegamenu' ) );
		} check_admin_referer( 'nymegamenu_theme_action' );
		$operation = sanitize_key( wp_unslash( $_REQUEST['operation'] ?? '' ) );
		$settings  = Settings::all();
		$theme_key = sanitize_key( wp_unslash( $_REQUEST['theme'] ?? 'default' ) );
		if ( 'create' === $operation || 'duplicate' === $operation ) {
			$source = 'duplicate' === $operation && isset( $settings['themes'][ $theme_key ] ) ? $settings['themes'][ $theme_key ] : Settings::theme_defaults();
			$key    = $this->new_theme_key( $settings['themes'] );
			/* translators: %s: original theme name. */
			$source['name']             = 'duplicate' === $operation ? sprintf( __( '%s copy', 'nymegamenu' ), $source['name'] ) : __( 'New Menu Theme', 'nymegamenu' );
			$settings['themes'][ $key ] = $source;
			update_option( Settings::OPTION, $settings );
			wp_safe_redirect( $this->page_url( 'nymegamenu-themes', array( 'theme' => $key ) ) );
			exit;
		} if ( 'delete' === $operation && 'default' !== $theme_key && isset( $settings['themes'][ $theme_key ] ) ) {
			foreach ( $settings['locations'] as $location ) {
				if ( ( $location['theme'] ?? 'default' ) === $theme_key ) {
					wp_safe_redirect( add_query_arg( 'nymega_notice', 'theme-in-use', $this->page_url( 'nymegamenu-themes', array( 'theme' => $theme_key ) ) ) );
					exit;
				}
			} unset( $settings['themes'][ $theme_key ] );
			update_option( Settings::OPTION, $settings );
			wp_safe_redirect( $this->page_url( 'nymegamenu-themes' ) );
			exit;
		} if ( 'export' === $operation && isset( $settings['themes'][ $theme_key ] ) ) {
			nocache_headers();
			header( 'Content-Type: application/json; charset=utf-8' );
			header( 'Content-Disposition: attachment; filename=nymegamenu-' . $theme_key . '.json' );
			echo wp_json_encode(
				array(
					'name'  => $settings['themes'][ $theme_key ]['name'],
					'theme' => $settings['themes'][ $theme_key ],
				),
				JSON_PRETTY_PRINT
			);
			exit;
		} if ( 'import' === $operation ) {
			$file      = isset( $_FILES['theme_file'] ) && is_array( $_FILES['theme_file'] ) ? $_FILES['theme_file'] : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- File metadata is validated below.
			$file_name = sanitize_file_name( wp_unslash( $file['name'] ?? '' ) );
			$is_json   = 'json' === strtolower( pathinfo( $file_name, PATHINFO_EXTENSION ) );
			if ( UPLOAD_ERR_OK !== (int) ( $file['error'] ?? UPLOAD_ERR_NO_FILE ) || empty( $file['tmp_name'] ) || ! is_uploaded_file( $file['tmp_name'] ) || (int) $file['size'] > 1048576 || ! $is_json ) {
				wp_safe_redirect( add_query_arg( 'nymega_notice', 'theme-import-invalid', $this->page_url( 'nymegamenu-themes' ) ) );
				exit;
			}
			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- The validated upload is capped at one megabyte.
			$json = file_get_contents( $file['tmp_name'] );
			if ( false === $json ) {
				wp_safe_redirect( add_query_arg( 'nymega_notice', 'theme-import-invalid', $this->page_url( 'nymegamenu-themes' ) ) );
				exit;
			}
			$data = json_decode( $json, true );
			if ( JSON_ERROR_NONE === json_last_error() && is_array( $data ) && is_array( $data['theme'] ?? null ) ) {
				$key                        = $this->new_theme_key( $settings['themes'] );
				$settings['themes'][ $key ] = Settings::sanitize_theme( $data['theme'] );
				update_option( Settings::OPTION, $settings );
				wp_safe_redirect( $this->page_url( 'nymegamenu-themes', array( 'theme' => $key ) ) );
				exit;
			}
			wp_safe_redirect( add_query_arg( 'nymega_notice', 'theme-import-invalid', $this->page_url( 'nymegamenu-themes' ) ) );
			exit;
		} wp_safe_redirect( add_query_arg( 'nymega_notice', 'theme-action-failed', $this->page_url( 'nymegamenu-themes' ) ) );
		exit; }

	public function general_page() {
		if ( ! $this->allowed() ) {
			return;
		} $general = Settings::all()['general'];
		$this->shell( 'nymegamenu-general', __( 'General Settings', 'nymegamenu' ) );
		?>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'nymegamenu' );
		$this->field( __( 'CSS output', 'nymegamenu' ), __( 'Inline styles are generated per enabled menu location. This avoids filesystem permissions and stale generated-file issues on managed hosts.', 'nymegamenu' ), '<select name="nymegamenu_settings[general][css_output]"><option value="inline" ' . selected( $general['css_output'], 'inline', false ) . '>Output in head</option><option value="none" ' . selected( $general['css_output'], 'none', false ) . '>Do not output CSS</option></select>' );
		submit_button();
		?>
		</form>
		<?php
		$this->close_shell();
	}
	public function tools_page() {
		if ( ! $this->allowed() ) {
			return;
		}
		$this->shell( 'nymegamenu-tools', __( 'Tools', 'nymegamenu' ) );
		$this->notice();
		?>
	<section class="nymega-settings-panel">
		<?php
		$this->field(
			__( 'Remove legacy generated CSS files', 'nymegamenu' ),
			__( 'Current versions generate styles inline. This removes only generated CSS files left by earlier versions of the plugin.', 'nymegamenu' ),
			'<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="nymegamenu_clear_cache">' . wp_nonce_field( 'nymegamenu_clear_cache', '_wpnonce', true, false ) . '<button class="button">Remove legacy files</button></form>'
		);
		$this->field(
			__( 'Delete all NY Mega Menu data', 'nymegamenu' ),
			__( 'This permanently deletes NY Mega Menu settings and per-menu-item data. Deactivation preserves data; deleting the plugin also removes it.', 'nymegamenu' ),
			'<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="nymegamenu_delete_data">' . wp_nonce_field( 'nymegamenu_delete_data', '_wpnonce', true, false ) . '<label><input type="checkbox" name="nymegamenu_confirm_delete" value="1" required> ' . esc_html__( 'I understand this cannot be undone.', 'nymegamenu' ) . '</label><p><button class="button button-link-delete">' . esc_html__( 'Delete plugin data', 'nymegamenu' ) . '</button></p></form>'
		);
		?>
	</section>
		<?php
		$this->close_shell();
	}
	public function license_page() {
		if ( ! $this->allowed() ) {
			return;
		} $license = Settings::all()['license'];
		$this->shell( 'nymegamenu-license', __( 'License', 'nymegamenu' ) );
		?>
	<form method="post" action="options.php">
		<?php
		settings_fields( 'nymegamenu' );
		$this->field( __( 'License key', 'nymegamenu' ), __( 'Store a supplied license key. Activation is kept local until a licensing service is configured.', 'nymegamenu' ), '<input class="regular-text" name="nymegamenu_settings[license][key]" value="' . esc_attr( $license['key'] ) . '">' );
		submit_button();
		?>
		</form>
		<?php
		$this->close_shell(); }
	public function clear_cache() {
		if ( ! $this->allowed() ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'nymegamenu' ) );
		} check_admin_referer( 'nymegamenu_clear_cache' );
		Plugin::instance()->clear_generated_styles();
		wp_safe_redirect( add_query_arg( 'nymega_notice', 'cache-cleared', $this->page_url( 'nymegamenu-tools' ) ) );
		exit; }
	public function delete_data() {
		if ( ! $this->allowed() ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'nymegamenu' ) );
		}
		check_admin_referer( 'nymegamenu_delete_data' );
		if ( empty( $_POST['nymegamenu_confirm_delete'] ) ) {
			wp_die( esc_html__( 'Please confirm deletion before continuing.', 'nymegamenu' ) );
		}
		global $wpdb;
		delete_option( Settings::OPTION );
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- The explicit data-deletion action removes all plugin-owned per-item metadata.
		$wpdb->delete( $wpdb->postmeta, array( 'meta_key' => '_nymegamenu_item' ) );
		Plugin::instance()->clear_generated_styles();
		wp_safe_redirect( add_query_arg( 'nymega_notice', 'data-deleted', $this->page_url( 'nymegamenu-tools' ) ) );
		exit; }

	public function item_fields( $item_id, $item ) {
		unset( $item );
		$settings = Renderer::item_settings( $item_id );
		$widgets  = array_keys( $GLOBALS['wp_widget_factory']->widgets );
		wp_nonce_field( 'nymegamenu_item', 'nymegamenu_item_nonce' );
		?>
	<p class="description description-wide nymega-menu-fields"><button type="button" class="button nymega-item-editor-trigger" data-nymega-editor="nymega-editor-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'NY Mega Menu', 'nymegamenu' ); ?></button></p><div id="nymega-editor-<?php echo esc_attr( $item_id ); ?>" class="nymega-item-editor" hidden><div class="nymega-item-editor__dialog" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'NY Mega Menu item settings', 'nymegamenu' ); ?>"><button type="button" class="nymega-item-editor__close" data-nymega-close>×</button><h3><?php esc_html_e( 'NY Mega Menu item', 'nymegamenu' ); ?></h3><label><?php esc_html_e( 'Submenu display', 'nymegamenu' ); ?><select name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][mode]"><option value="flyout" <?php selected( $settings['mode'], 'flyout' ); ?>>Flyout Menu</option><option value="mega" <?php selected( $settings['mode'], 'mega' ); ?>>Mega Menu — Grid Layout</option></select></label><label><?php esc_html_e( 'Grid columns', 'nymegamenu' ); ?><select name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][grid_columns]">
		<?php
		for ( $columns = 1; $columns <= 4; $columns++ ) :
			?>
	<option value="<?php echo esc_attr( $columns ); ?>" <?php selected( $settings['grid_columns'], $columns ); ?>><?php echo esc_html( $columns ); ?></option><?php endfor; ?></select></label><label><?php esc_html_e( 'Mega content', 'nymegamenu' ); ?><select name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][content_source]"><option value="children" <?php selected( $settings['content_source'], 'children' ); ?>>Use child menu items</option><option value="custom" <?php selected( $settings['content_source'], 'custom' ); ?>>Custom block content</option><option value="widget" <?php selected( $settings['content_source'], 'widget' ); ?>>WordPress widget</option></select></label><label><?php esc_html_e( 'Custom block content', 'nymegamenu' ); ?><textarea name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][custom_content]" rows="7"><?php echo esc_textarea( $settings['custom_content'] ); ?></textarea></label><label><?php esc_html_e( 'Widget', 'nymegamenu' ); ?><select name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][widget_class]"><option value="">Select widget</option>
		<?php
		foreach ( $widgets as $widget ) :
			?>
	<option value="<?php echo esc_attr( $widget ); ?>" <?php selected( $settings['widget_class'], $widget ); ?>><?php echo esc_html( $widget ); ?></option><?php endforeach; ?></select></label><label><?php esc_html_e( 'Badge', 'nymegamenu' ); ?><input name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][badge]" value="<?php echo esc_attr( $settings['badge'] ); ?>"></label><label><?php esc_html_e( 'Badge style', 'nymegamenu' ); ?><select name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][badge_style]">
		<?php
		for ( $style = 1; $style <= 4; $style++ ) :
			?>
		<?php /* translators: %d: badge style number. */ ?><option value="<?php echo esc_attr( $style ); ?>" <?php selected( $settings['badge_style'], $style ); ?>><?php echo esc_html( sprintf( __( 'Style %d', 'nymegamenu' ), $style ) ); ?></option><?php endfor; ?></select></label><label><?php esc_html_e( 'Dashicon', 'nymegamenu' ); ?><input name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][icon]" value="<?php echo esc_attr( $settings['icon'] ); ?>" placeholder="dashicons-admin-home"></label><label><input type="checkbox" name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][hide_text]" value="1" <?php checked( $settings['hide_text'] ); ?>> Hide text</label><label><input type="checkbox" name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][hide_arrow]" value="1" <?php checked( $settings['hide_arrow'] ); ?>> Hide arrow</label><label><input type="checkbox" name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][disable_link]" value="1" <?php checked( $settings['disable_link'] ); ?>> Disable link</label><label><input type="checkbox" name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][desktop]" value="1" <?php checked( $settings['desktop'] ); ?>> Desktop</label><label><input type="checkbox" name="nymegamenu_item[<?php echo esc_attr( $item_id ); ?>][mobile]" value="1" <?php checked( $settings['mobile'] ); ?>> Mobile</label></div></div>
		<?php
	}
	public function save_item( $menu_id, $menu_item_db_id ) {
		if ( ! $this->allowed() || empty( $_POST['nymegamenu_item_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nymegamenu_item_nonce'] ) ), 'nymegamenu_item' ) ) {
			return;
		}
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Each value is sanitized according to its expected type below.
		$all_input              = isset( $_POST['nymegamenu_item'] ) ? wp_unslash( $_POST['nymegamenu_item'] ) : array();
		$input                  = isset( $all_input[ $menu_item_db_id ] ) && is_array( $all_input[ $menu_item_db_id ] ) ? $all_input[ $menu_item_db_id ] : array();
		$data                   = Renderer::item_settings( $menu_item_db_id );
		$data['mode']           = in_array( $input['mode'] ?? '', array( 'mega', 'flyout' ), true ) ? $input['mode'] : 'flyout';
		$data['grid_columns']   = min( 4, max( 1, absint( $input['grid_columns'] ?? 3 ) ) );
		$data['content_source'] = in_array( $input['content_source'] ?? '', array( 'children', 'custom', 'widget' ), true ) ? $input['content_source'] : 'children';
		$data['custom_content'] = wp_kses_post( $input['custom_content'] ?? '' );
		$data['widget_class']   = sanitize_text_field( $input['widget_class'] ?? '' );
		$data['badge']          = sanitize_text_field( $input['badge'] ?? '' );
		$data['badge_style']    = min( 4, max( 1, absint( $input['badge_style'] ?? 1 ) ) );
		$data['icon']           = sanitize_html_class( $input['icon'] ?? '' );
		foreach ( array( 'hide_text', 'hide_arrow', 'disable_link', 'desktop', 'mobile' ) as $key ) {
			$data[ $key ] = empty( $input[ $key ] ) ? 0 : 1;
		} update_post_meta( $menu_item_db_id, '_nymegamenu_item', $data ); }
}
