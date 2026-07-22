# Repository Guidelines

## Project Structure & Module Organization

This repository tracks WordPress content only, not WordPress core, the database, uploads, or environment configuration. The primary theme is `wp-content/themes/nolan-young-theme-template-01`: PHP templates and helpers live in `inc/`, `template-parts/`, and `patterns/`; editable frontend sources live in `src/scss/` and `src/js/`; committed build output lives in `assets/css/` and `assets/js/`. Plugins live in `wp-content/plugins/`, including `nyforms` and `nymegamenu`, with implementation in `includes/`, frontend assets in `assets/`, and PHPUnit tests in `tests/`. Keep must-use plugin work under `wp-content/mu-plugins/`.

## Build, Test, and Development Commands

Run theme commands from `wp-content/themes/nolan-young-theme-template-01`:

- `npm ci` installs the locked JavaScript dependencies for a fresh checkout or lockfile change.
- `npm run start` watches theme source assets during development.
- `npm run check` runs JavaScript, Node, and SCSS linting plus asset validation.
- `npm run build` performs the release asset build and validation.
- `npm run package` builds and verifies the distributable theme ZIP.

Use `composer run lint:php` and `composer run test:php` for theme PHP quality checks. In either plugin directory, run `composer run lint` and `composer run test`. Perform runtime WordPress checks only in the designated local sandbox: `C:\Users\NolanYoung\Local Sites\7-20-wp-playground`.

## Coding Style & Naming Conventions

Follow `.editorconfig`: use tabs in PHP, two spaces in CSS, SCSS, JavaScript, JSON, YAML, and Markdown, LF endings, and a final newline. Follow WordPress Coding Standards and existing WordPress naming conventions: prefix public PHP functions, hooks, options, CSS classes, and handles with the component slug (for example, `nymegamenu_` or `nyforms_`). Modify `src/` files rather than generated theme assets, then rebuild and commit the matching `assets/` output.

## Testing Guidelines

Add focused PHPUnit coverage beside the affected theme or plugin tests. Name tests after the behavior under test, such as `test_menu_toggle_closes_on_escape`. Exercise capability checks, nonces, sanitization, escaping, rendering, and relevant keyboard/responsive paths. Run the narrowest applicable command during development, then the release build before a theme-facing change is proposed.

## Commit and Pull Request Guidelines

Use a scoped branch such as `feature/mobile-menu-focus` or `fix/form-validation`. Write concise imperative Conventional Commit-style subjects, for example `fix: restore parent menu links`; keep commits small and reversible. Pull requests should state purpose, affected paths, validation performed, rollout or migration considerations, and linked issues. Include screenshots or a short recording for visible admin or frontend changes. Never commit credentials, database exports, `node_modules/`, `vendor/`, local WordPress configuration, or generated diagnostic logs.
