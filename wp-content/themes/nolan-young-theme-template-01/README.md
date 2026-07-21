# Nolan Young Theme Template 01

Nolan Young Theme Template 01 is a self-contained classic WordPress theme for WordPress 7.0+ and PHP 7.4+. It combines PHP templates, `theme.json`, block patterns, accessible navigation, and compiled CSS and JavaScript.

## Runtime model

The theme activates and works with no plugins enabled. It owns its layouts, starter content, page templates, block patterns, and presentation settings.

This repository includes two optional integrations:

- **NYforms** can provide contact and newsletter forms through the theme's shortcode slots.
- **NY Mega Menu** can enhance a registered WordPress menu location while the theme retains its native accessible menu when the plugin is inactive.

No external companion plugin is required. Do not add dependencies on an unbundled plugin to theme templates.

## Install and configure

1. Install and activate `nolan-young-theme-template-01.zip`.
2. Assign the Primary and Footer menus under **Appearance → Menus**.
3. Configure a static front page under **Settings → Reading** when needed.
4. Add and edit pages using the included page templates and block patterns.
5. To display a form, paste its shortcode in **Appearance → Customize → Form Shortcodes**. The Contact and Newsletter areas display a clear placeholder until configured.
6. Optionally install and activate the repository's NYforms or NY Mega Menu plugins.

## Theme boundaries

- Theme: templates, styles, block patterns, navigation presentation, editor styling, and shortcode placement.
- Optional plugins: their own submitted data, form processing, privacy tooling, or enhanced navigation behavior.
- WordPress core: pages, posts, menus, media, widgets, and the block editor.

Custom post types and form handlers do not belong in this theme. A site may install a purpose-built plugin when it needs those features, but the theme must still render a complete usable site without it.

## Source and generated files

Edit PHP templates and files under `inc/`, `template-parts/`, `patterns/`, `src/scss/`, and `src/js/`. Do not edit generated runtime assets under `assets/css/` or `assets/js/` by hand.

```bash
npm ci
npm run build
npm run package
```

`npm run build` cleans, lints, compiles, and validates the theme. `npm run package` also creates an installable ZIP in `dist/`.

## Validation

Run the following before release:

```bash
npm run build
composer lint:php
```

Use a local WordPress sandbox to test activation with no plugins, then with NYforms and NY Mega Menu active. Verify keyboard navigation, small-screen layout, editor styles, form shortcode output, and the browser console.

## Project structure

```text
assets/             Generated runtime CSS and JavaScript
build/              Validation and packaging scripts
inc/                Theme setup, navigation, and presentation helpers
page-templates/     Optional page compositions
patterns/           Block patterns
src/                Maintained SCSS and JavaScript source
template-parts/     Reusable presentation templates
tests/              WordPress unit tests
```

## Maintenance rules

- Preserve native WordPress fallbacks when an optional plugin is inactive.
- Escape output, sanitize input, enforce nonces and capabilities for privileged actions.
- Keep generated assets synchronized with maintained source.
- Update this README, `CHANGELOG.md`, and translations when user-visible behavior changes.
