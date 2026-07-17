<?php
defined( 'ABSPATH' ) || exit;
echo nyforms_render_form( absint( $attributes['formId'] ?? 0 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Renderer escapes field output.
