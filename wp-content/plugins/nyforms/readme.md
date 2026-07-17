# NYforms

NYforms is an original WordPress-native form builder for WordPress 7.0+ and PHP 7.4+. Install it in `wp-content/plugins/nyforms`, activate it, then create forms at **NYforms → NYforms**. Administrators receive the `nyforms_manage_forms`, `nyforms_view_entries`, `nyforms_manage_entries`, and `nyforms_export_entries` capabilities; assign these deliberately to non-administrator roles.

## Forms and embedding

The editor provides text, paragraph, email, phone, number, name, address, URL, date, time, select, radio, checkbox, consent, hidden, HTML, section, page, upload, product, option, quantity, total, and calculation fields. Use the NYforms block, `[nyforms id="123"]`, or `<?php echo nyforms_render_form( 123 ); ?>`. Forms use semantic labels, accessible error messages, server-side validation, responsive styling, optional safe CSS classes, conditional visibility, page navigation, and optional save/resume links.

## Entries, uploads, and privacy

Entries retain form revision, timestamp, status, read state, values, and privacy-conscious source metadata. Authorized users can review entries and export active entries as CSV. Uploads are checked against WordPress upload rules, permitted extensions, MIME information, and per-field size limits. Keep upload permissions conservative; uploaded files are represented by private attachments and must only be exposed through authorized WordPress administration.

Set retention in NYforms settings before collecting personal data. Retention moves expired active entries to trash. WordPress personal-data export/erasure tools can locate entries by email values. NYforms transmits no submission data externally by default.

## Confirmations, notifications, and spam controls

Confirmations can render a message, use an internal page, or redirect to a validated HTTPS URL. Notifications support recipients, sender and reply-to values, conditions, and original tokens: `[[nyforms:field:field_key]]`, `[[nyforms:form:title]]`, `[[nyforms:site:name]]`, and `[[nyforms:entry:id]]`. A honeypot and per-IP rate limit are enabled by configuration. CAPTCHA and anti-spam services are extension points only; no third-party key or data transmission is enabled by default.

## Developer API

Use `nyforms_render_form( $id )`, the `nyforms/v1` REST API (capability-protected), `nyforms_entry_created`, `nyforms_field_types`, `nyforms_spam_providers`, and `nyforms_notification_providers`. Imports and exports use NYforms-owned versioned JSON; unknown or malformed field definitions are rejected.

## Scope and validation

Payment gateways are deliberately excluded. NYforms does not import from, claim compatibility with, or include any code, branding, design assets, APIs, or documentation from other form plugins. For development, run PHP and JavaScript parse checks and a WordPress integration suite against a configured local WordPress instance. Composer/PHPUnit is optional and not required by the plugin runtime.
