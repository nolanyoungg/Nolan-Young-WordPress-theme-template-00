=== NYforms ===
Contributors: nolanyoungg
Tags: forms, contact form, form builder, privacy, submissions
Requires at least: 7.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Build accessible WordPress forms, manage entries, and process privacy requests without requiring an external form service.

== Description ==

NYforms provides a WordPress-native form builder, blocks, shortcodes, entry management, protected upload storage, confirmations, notifications, conditional fields, privacy export and erasure integration, and an authenticated REST API.

Forms are embedded with the NYforms block, `[nyforms id="123"]`, or `nyforms_render_form( 123 )`.

NYforms stores submission data in dedicated WordPress database tables. Configure a retention period appropriate for your site and disclose each form's collection purpose in your privacy policy.

= Optional Google reCAPTCHA service =

NYforms does not contact an external service by default. If an administrator explicitly enables Google reCAPTCHA and supplies keys, the visitor's reCAPTCHA token and privacy-anonymized IP address are sent to Google's `https://www.google.com/recaptcha/api/siteverify` endpoint for spam evaluation. Google's browser script is also loaded from `https://www.google.com/recaptcha/api.js`.

Google Privacy Policy: https://policies.google.com/privacy

Google Terms of Service: https://policies.google.com/terms

== Installation ==

1. Upload the `nyforms` directory to `/wp-content/plugins/`, or install it through the WordPress Plugins screen.
2. Activate NYforms.
3. Open **NYforms** in WordPress administration and create a form.
4. Add the NYforms block or shortcode to a page.
5. Configure retention and optional notification settings before collecting personal data.
6. If forms accept uploads, confirm the filtered private storage directory is persistent and writable on your host.

== Frequently Asked Questions ==

= Where are uploaded files stored? =

New uploads are stored in a private directory outside the WordPress web root by default and are downloaded through capability-protected WordPress routes. Managed hosts may configure a persistent private path with the `nyforms_private_storage_directory` filter. Defense-in-depth denial files are added if that path is web reachable.

= Does NYforms send submission data to another company? =

Not by default. Normal form storage and email use WordPress. Enabling Google reCAPTCHA activates the external transmission described above. A developer may also install custom anti-spam or notification providers; those extensions are responsible for documenting their own transmissions.

= How can a visitor request their data? =

Use WordPress's built-in personal-data tools or place `[nyforms_privacy_request]` on a page. Requests use WordPress's confirmation-email workflow.

== Changelog ==

= 1.0.3 =

* Added exact-email privacy matching and deletion-safe erasure batches.
* Added private upload storage with authorized downloads and lifecycle cleanup.
* Added entry/form persistence failure handling.
* Added unique embed IDs and one-time resume/confirmation state.
* Replaced dynamic calculation execution with a constrained arithmetic parser.
* Added form-builder controls for behavior, confirmations, and core email notifications.

== Upgrade Notice ==

= 1.0.3 =

Verify that the private upload directory is writable and persistent before accepting new file uploads.
