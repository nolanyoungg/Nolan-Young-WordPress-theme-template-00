# Nolan Young WordPress Content Template

This repository is the version-controlled `wp-content` layer for a Nolan Young WordPress site. It contains the site-owned theme and plugins that are deployed into a normal WordPress installation; it does not contain WordPress core, a database export, uploads, credentials, or environment-specific configuration.

The repository is designed to be a durable starting point for one or more WordPress themes. Its current production-ready implementation is a classic PHP theme supported by a modern asset pipeline, plus NYforms: an original, WordPress-native form-builder plugin.

## Contents

- [What is in this repository?](#what-is-in-this-repository)
- [Repository layout](#repository-layout)
- [Current theme: Nolan Young Theme Template 01](#current-theme-nolan-young-theme-template-01)
- [Current plugin: NYforms](#current-plugin-nyforms)
- [Requirements](#requirements)
- [Getting started locally](#getting-started-locally)
- [Theme development workflow](#theme-development-workflow)
- [How to modify the current theme](#how-to-modify-the-current-theme)
- [Adding another theme later](#adding-another-theme-later)
- [NYforms development and use](#nyforms-development-and-use)
- [Testing, CI, and release packaging](#testing-ci-and-release-packaging)
- [Git workflow](#git-workflow)
- [Security and maintenance rules](#security-and-maintenance-rules)

## What is in this repository?

| Area | Current contents | Purpose |
| --- | --- | --- |
| `wp-content/themes/` | `nolan-young-theme-template-01` | The active, production-oriented classic WordPress theme and its source/build tooling. |
| `wp-content/plugins/` | `nyforms` | Original WordPress-native forms plugin with form building, entries, exports, privacy tooling, and a protected REST API. |
| `wp-content/mu-plugins/` | `.gitkeep` only | Reserved for must-use plugins that should load for every request. |
| `.github/workflows/` | `theme-ci.yml` | GitHub Actions build, package, generated-asset, ZIP, and PHP syntax validation. |

The repository has one theme today. The directory structure intentionally supports adding more theme directories later without changing the root development model.

## Repository layout

```text
.
├── .github/
│   └── workflows/theme-ci.yml       # CI for the current theme and PHP syntax
├── wp-content/
│   ├── mu-plugins/                  # Reserved for site-wide must-use plugins
│   ├── plugins/
│   │   └── nyforms/                 # NYforms WordPress plugin
│   └── themes/
│       └── nolan-young-theme-template-01/
│           ├── assets/              # Committed, generated browser assets
│           ├── build/               # Theme build/validation/package helpers
│           ├── docs/                # Focused theme documentation
│           ├── inc/                 # Focused PHP modules loaded by functions.php
│           ├── page-templates/      # Assignable classic page templates
│           ├── patterns/            # Registered WordPress block patterns
│           ├── src/                 # Maintained SCSS and JavaScript source
│           ├── template-parts/      # Reusable PHP presentation parts
│           ├── tests/               # Theme test bootstrap and tests
│           ├── theme.json           # Editor/design-system configuration
│           └── package.json         # Theme Node command interface
├── .editorconfig
├── .gitattributes
├── .gitignore
└── README.md                        # This repository guide
```

### What is intentionally excluded

Do not add WordPress core, `wp-config.php`, `wp-content/uploads/`, database dumps containing real user data, local `.env` files, dependency directories (`node_modules/`, `vendor/`), or build output that is explicitly ignored. The theme’s generated runtime assets under its committed `assets/` directory are the important exception: they are reviewed and deployed alongside source changes.

## Current theme: Nolan Young Theme Template 01

`wp-content/themes/nolan-young-theme-template-01` is a classic WordPress theme with modern WordPress capabilities. Its runtime identity is deliberately separate from this repository name.

| Property | Value |
| --- | --- |
| Display name | Nolan Young Theme Template 01 |
| Runtime slug | `nolan-young-theme-template-01` |
| Version | `1.2.1` |
| Theme type | Classic PHP theme with `theme.json` version 3 |
| WordPress requirement | 7.0 or newer |
| PHP requirement | 7.4 or newer |
| Text domain | `nolan-young-theme-template-01` |
| Node requirement | 18.12 or newer |
| Package tooling | npm, `@wordpress/scripts`, webpack |
| PHP development tooling | Composer, PHP_CodeSniffer, PHPUnit |

It uses the standard PHP template hierarchy (`front-page.php`, `home.php`, `page.php`, `single.php`, archives, search, and 404 templates) rather than full-site editing templates. `theme.json` provides editor settings, global styles, tokens, and block-related configuration; it does not make this a block theme.

The theme includes:

- Accessible, WordPress-managed navigation with progressive JavaScript enhancement.
- Reusable PHP template parts for front-page sections, headers, footers, and content views.
- Assignable page templates for About, Blog, Contact, Policy, Services, Service Detail, and Work pages.
- Block patterns for hero, calls to action, services, featured work, and testimonials.
- A compiled SCSS and JavaScript pipeline, with generated files committed under `assets/css/` and `assets/js/`.
- Editor styles, registered block styles, menu locations, widget areas, and Customizer support.
- Optional presentation integrations for the bundled NYforms and NY Mega Menu plugins.

Read the theme’s detailed operating manual before changing its architecture: [theme README](wp-content/themes/nolan-young-theme-template-01/README.md). Its focused [documentation directory](wp-content/themes/nolan-young-theme-template-01/docs/) covers getting started, architecture, customization, accessibility, and releases.

## Current plugin: NYforms

## Theme integration policy

The active theme does not require an external companion plugin. Its contact and newsletter areas are theme-owned shortcode slots: site owners can paste a shortcode from their chosen form solution in **Appearance → Customize → Form Shortcodes**.

This repository also includes two optional, supported plugins that the theme can use when they are activated:

- `nyforms` supplies WordPress-native form building and can be pasted into either shortcode slot.
- `nymegamenu` supplies an enhanced primary-navigation experience; the theme retains its native WordPress navigation when it is inactive.


`wp-content/plugins/nyforms` is an original WordPress-native form-builder plugin. It is intentionally independent of third-party form-plugin code, branding, layouts, import formats, or compatibility promises.

NYforms currently provides:

- An admin form workspace with field configuration, ordering, page navigation, conditional logic, and layout widths.
- Core fields including text, email, phone, number, name, address, URL, date/time, select, radio, checkbox, consent, hidden, HTML, section, page, file upload, product, option, quantity, total, and calculation fields.
- Embedding through the NYforms block, `[nyforms id="123"]`, or `nyforms_render_form( 123 )`.
- Server-side submission validation, confirmations, notifications, token replacement, honeypot checks, per-IP rate limiting, and optional reCAPTCHA.
- Entry administration with unread/starred/status states, search, bulk actions, protected uploads, and JSON/CSV/XLSX-oriented exports.
- Import/export of versioned NYforms JSON form definitions.
- WordPress personal-data exporter/eraser integration and a self-service `[nyforms_privacy_request]` block/shortcode.
- A capability-protected `/wp-json/nyforms/v1` REST API for admin integrations, with pagination, CSV exports, audit events, diagnostics, and an OpenAPI-style discovery document at `/wp-json/nyforms/v1/openapi`.

Payments, custom NYforms API keys, public entry APIs, and third-party data transmission by default are deliberately out of scope.

For plugin-specific setup, capabilities, API notes, and scope, read [the NYforms README](wp-content/plugins/nyforms/readme.md).

## Requirements

### Runtime

To run this content in WordPress, use a standard WordPress installation that satisfies the active theme and plugin requirements:

- WordPress 7.0 or newer for the current theme.
- PHP 7.4 or newer for the current theme and NYforms.
- A configured database and web server supported by WordPress.
- A local or staging site with the repository’s `wp-content` directories installed in the expected location.

### Development

For the complete current-theme workflow, install:

- Git.
- Node.js 18.12+ and npm 8.19+.
- PHP 7.4+; PHP 8.2 is used by CI for syntax validation.
- Composer when using the theme’s PHP_CodeSniffer or PHPUnit commands.
- A disposable local WordPress site (Local, Docker, wp-env, or comparable tooling).

Confirm the core tools:

```powershell
node --version
npm --version
php --version
composer --version
git --version
```

## Getting started locally

This is a `wp-content` repository, not a self-bootstrapping WordPress application. Start with a working local WordPress installation, then place or link the repository’s `wp-content` contents into that installation.

### 1. Clone the repository

```bash
git clone https://github.com/nolanyoungg/Nolan-Young-WordPress-theme-template-00.git
cd Nolan-Young-WordPress-theme-template-00
```

### 2. Put the content in a local WordPress site

Use one of these approaches:

- Clone directly into a project that supplies the surrounding WordPress installation.
- Copy `wp-content/themes/nolan-young-theme-template-01` into the local site’s `wp-content/themes/` directory.
- Copy `wp-content/plugins/nyforms` into the local site’s `wp-content/plugins/` directory.
- Use directory links/junctions if your local environment supports them and you want edits in this checkout to appear immediately in WordPress.

Do not overwrite an existing `wp-content/uploads/` directory or `wp-config.php` with anything from this repository.

### 3. Activate what you need

In WordPress Admin:

1. Activate **Nolan Young Theme Template 01** under **Appearance → Themes**.
2. Activate **NYforms** under **Plugins** if the site needs forms.
3. Assign menus, configure a static front page, and create any required Contact, Services, or Work pages.
4. In **NYforms → Settings**, configure retention and optional reCAPTCHA only if the local site needs to exercise those paths.

### 4. Install the current theme’s development dependencies

Run npm commands from the theme directory—not from the repository root:

```powershell
Set-Location .\wp-content\themes\nolan-young-theme-template-01
npm ci
```

Install Composer dependencies only when you will run PHP standards checks or PHPUnit:

```powershell
composer install
```

### 5. Build once before reviewing

```powershell
npm run build
```

The production build cleans prior output, runs the theme linters, compiles browser assets, and validates the result. It is the required final asset command before review, packaging, or committing generated asset updates.

## Theme development workflow

The theme has a strict source/output boundary:

| Edit this | Do not edit this by hand |
| --- | --- |
| `src/scss/` | `assets/css/` |
| `src/js/` | `assets/js/` |
| PHP templates, `inc/`, `template-parts/`, `patterns/`, `theme.json` | Build output or dependency directories |

`assets/css/` and `assets/js/` are generated runtime assets. They must be committed when a build changes them, but they are never the hand-authored source of a change.

### Day-to-day commands

From `wp-content/themes/nolan-young-theme-template-01`:

```powershell
# Install the locked Node dependency tree.
npm ci

# Watch source files with development output.
npm run start

# Alternative minified watch workflow.
npm run dev

# Run JS, Node helper, and SCSS linting.
npm run lint

# Validate structure and version relationships.
npm run validate

# Final production build (required before review/release).
npm run build

# Build, validate, and create an installable ZIP in dist/.
npm run package

# PHP code standards and test suite when Composer dependencies are installed.
composer lint:php
composer test:php
```

Use `npm run start` while iterating when readable development output is helpful. Stop the watcher before your final `npm run build`; do not leave a watcher running when packaging or committing.

## How to modify the current theme

The theme is presentation-only. It may render data from plugins but must not own functionality that must survive a theme switch: custom post types, custom taxonomies, persistent records, submission processing, credentials, payments, or application REST endpoints belong in a plugin.

### Change a PHP template or template part

1. Identify the WordPress template hierarchy file or reusable file under `template-parts/`.
2. Make the focused presentation change. Use WordPress APIs and escape dynamic output at the point of rendering.
3. Run PHP syntax checking for the changed file, for example:

   ```powershell
   php -l .\template-parts\global\content-hero.php
   ```

4. Verify the matching route in local WordPress with `WP_DEBUG` enabled.
5. Run `composer lint:php` when Composer tooling is installed.

PHP-only changes do not require an asset rebuild unless SCSS or JavaScript source also changed.

### Change styling

1. Find the appropriate maintained source file below `src/scss/`:
   - variables/mixins: `src/scss/abstracts/`
   - baseline and editor-facing primitives: `src/scss/base/`
   - reusable UI: `src/scss/components/`
   - site structure: `src/scss/layout/`
   - route-specific styling: `src/scss/pages/`
2. Edit or add a partial, then import it from `src/scss/main.scss` in the appropriate layer.
3. Run `npm run start` during iteration.
4. Check the front end, responsive layouts, keyboard states, and reduced-motion behavior.
5. Stop the watcher and run `npm run build`.
6. Commit the source change and any resulting `assets/css/` changes together.

### Change frontend JavaScript

1. Add or edit a focused module in `src/js/components/` or `src/js/utilities/`.
2. Import it from `src/js/main.js` and initialize it from the existing DOM-ready flow.
3. Keep the page usable without JavaScript.
4. Test pointer and keyboard behavior, especially navigation and interactive controls.
5. Run `npm run build` and commit the resulting `assets/js/` output.

### Change the design system or editor controls

Use `theme.json` for global settings, presets, and block-editor styling. Use the theme’s editor module and editor SCSS only for complementary editor behavior that `theme.json` cannot express cleanly. Test both the front end and the block editor after changes.

### Add a page template or pattern

- **Page template:** add a PHP file in `page-templates/`, give it a valid `Template Name` header, follow the normal `get_header()` / Loop / `get_template_part()` / `get_footer()` pattern, and document it in the theme README.
- **Pattern:** add a registered PHP pattern in `patterns/`, use the theme text domain for user-facing strings, and verify it is useful in the block inserter and when rendered on the front end.

### Change navigation or theme/plugin integrations

Navigation configuration is in `inc/navigation.php` and header template parts. Preserve WordPress-managed menus and accessible keyboard behavior; do not hardcode a primary menu in `header.php`.

The theme remains usable with no active plugins. NYforms and NY Mega Menu are bundled optional integrations; do not make a theme feature depend on an unbundled companion plugin.

## Adding another theme later

New themes should be independent WordPress themes, not renamed copies of the current runtime theme in place. Keep each one in its own directory:

```text
wp-content/themes/
├── nolan-young-theme-template-01/
└── your-new-theme-slug/
```

For a new theme:

1. Choose a unique, stable folder name, stylesheet header name, text domain, package name, and asset prefix.
2. Add a self-contained `README.md` that documents its runtime requirements, development commands, source/output boundaries, and packaging process.
3. Add its own `package.json`, lockfile, and build configuration if it needs compiled assets. Do not make a second theme depend on another theme’s `node_modules`.
4. Keep theme-specific templates, `theme.json`, styles, scripts, screenshot, patterns, and documentation inside that theme’s directory.
5. Extend `.github/workflows/theme-ci.yml` so CI builds and validates the new theme independently. Do not silently replace the existing theme’s CI target.
6. Update this root README’s contents table and repository layout so contributors know the new theme exists and how to work on it.
7. Test theme switching with persistent features supplied by plugins, confirming that content and forms remain available.

If the new theme is derived from the current template, treat it as a new product: deliberately update all identity strings and retained documentation instead of performing a blind search-and-replace.

## NYforms development and use

NYforms is a normal WordPress plugin under `wp-content/plugins/nyforms`. Install it by copying/symlinking that directory into a WordPress site and activating it in the admin.

### Important operational points

- Administrators receive `nyforms_manage_forms`, `nyforms_view_entries`, `nyforms_manage_entries`, and `nyforms_export_entries` capabilities. Assign them deliberately for non-administrator roles.
- The visual builder’s nonce-authenticated requests work inside WordPress Admin even when external developer REST access is disabled.
- External REST integrations require the NYforms REST setting, HTTPS, a WordPress Application Password, and a user with the necessary NYforms capability.
- The reCAPTCHA secret is write-only in the REST response model; it must never be placed in source control, logs, or client-side code.
- The public privacy request route and its block/shortcode intentionally return generic responses to avoid revealing whether an email address has stored data.
- Payments are not implemented.

The plugin has optional Composer development tools:

```powershell
Set-Location .\wp-content\plugins\nyforms
composer install
composer lint
composer test
```

Run these only in an appropriate WordPress-aware test setup; Composer tooling is not required at runtime.

## Testing, CI, and release packaging

### Local verification baseline

Before committing theme changes, run the relevant smallest checks plus the full build when source assets changed:

```powershell
Set-Location .\wp-content\themes\nolan-young-theme-template-01
npm run lint
npm run build
composer lint:php
composer test:php
```

Then test the actual WordPress site: template routes, menus, editor styles, responsive behavior, keyboard access, forms where installed, and the browser console. Use a local/staging site with `WP_DEBUG` enabled; never enable verbose debugging on production sites.

### GitHub Actions

`Theme CI` runs on pushes to `main` and `staging`, on pull requests targeting `main`, and when manually dispatched. It:

1. installs the current theme’s locked Node dependencies;
2. runs the production build and creates the installable theme ZIP;
3. confirms generated assets are current;
4. checks that the ZIP is structurally valid and contains one expected top-level theme directory; and
5. runs `php -l` across PHP files in the repository, excluding dependency and distribution directories.

The installable ZIP is uploaded as a short-retention GitHub Actions artifact. CI currently targets `nolan-young-theme-template-01`; update it when adding a second buildable theme.

### Packaging the current theme

From the current theme directory:

```powershell
npm run package
```

This reruns the final build gate and creates:

```text
wp-content/themes/nolan-young-theme-template-01/dist/nolan-young-theme-template-01.zip
```

Install that ZIP on a clean staging WordPress site before treating it as a release candidate. The ZIP is a deployment artifact, not the source of truth.

## Git workflow

Use a focused branch for each change. The preferred branch prefix is `codex/` for Codex-driven work.

```bash
git switch main
git pull --ff-only origin main
git switch -c codex/short-description
```

Keep commits scoped and descriptive. For theme asset changes, commit maintained source files and the generated `assets/css/`/`assets/js/` output from the same final build. Do not commit `node_modules`, `vendor`, local packages, credentials, or local WordPress configuration.

Before merging or pushing:

1. Review `git diff` and `git status`.
2. Run the appropriate tests and final production build.
3. Confirm generated assets are current.
4. Verify the local WordPress behavior.
5. Push only intentional changes.

## Security and maintenance rules

- Keep secrets, Application Passwords, reCAPTCHA keys, API credentials, exports containing personal data, and production database dumps out of Git.
- Escape dynamic output, sanitize controlled input, use WordPress nonces for browser-admin actions, and use capability checks for privileged behavior.
- Keep persistent functionality in plugins. A theme change must not remove stored records, form processing, privacy tools, custom content types, or access rules.
- Edit maintained SCSS/JS source under `src/`, then rebuild; never patch generated theme assets as the source fix.
- Preserve accessible keyboard navigation, visible focus behavior, semantic markup, and reduced-motion support.
- Keep the current theme’s stylesheet header, package version, and changelog version aligned when releasing a new theme version.
- Update the relevant README whenever commands, directory boundaries, supported versions, or architecture change.

## Where to go next

- Working on the current theme? Start with the [theme operating manual](wp-content/themes/nolan-young-theme-template-01/README.md).
- Building or administering forms? Read [NYforms documentation](wp-content/plugins/nyforms/readme.md).
- Need an overview of the theme architecture? Read [theme architecture notes](wp-content/themes/nolan-young-theme-template-01/docs/architecture.md).
- Preparing a theme release? Follow the [theme release process](wp-content/themes/nolan-young-theme-template-01/docs/release-process.md).
