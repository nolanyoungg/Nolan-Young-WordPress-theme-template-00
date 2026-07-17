<?php
defined( 'ABSPATH' ) || exit;
echo NYforms\Plugin::instance()->privacy_shortcode(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode output is escaped by the plugin.
