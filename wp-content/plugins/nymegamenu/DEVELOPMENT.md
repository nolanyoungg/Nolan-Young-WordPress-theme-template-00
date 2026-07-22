# Development

`composer.json` is only for contributors and release automation. WordPress does not load Composer, and the plugin release package must not include `vendor/`.

## Local quality checks

1. Install development tools with `composer install`.
2. Run `composer run lint` to check WordPress Coding Standards, translation text domains, and PHP 7.4 compatibility.
3. Run `composer run fix` only for mechanical PHPCS fixes, then review the diff.
4. Run `composer run make-pot` after changing translatable PHP strings. This requires WP-CLI with the `i18n` command available.

The local `phpcs.xml.dist` is the single source of truth for the lint rules. No external repository path is required.
