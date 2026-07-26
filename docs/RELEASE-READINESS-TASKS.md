# Release Readiness Tasks 1–9

This checklist records the combined repository review and implementation as one
workstream.

## Task 1 — GitHub to Pressable

- [x] Treat the repository as a versioned `wp-content` layer, not WordPress
      core, database, uploads, or environment configuration.
- [x] Add required CI for secrets, file guardrails, PHP 7.4/8.4 syntax,
      WordPress coding standards, PHPUnit, Plugin Check, and generated assets.
- [x] Synchronize only the owned theme and plugins while preserving uploads,
      MU plugins, and server-owned content.
- [x] Document backup, staging, path mapping, validation, rollback, and
      production promotion.
- [ ] Protect `main` and `staging` with Repository CI after this branch is
      pushed.
- [ ] Connect Pressable staging first and confirm repository `wp-content/`
      maps to `/htdocs/wp-content/`.

## Task 2 — npm workspace and commands

- [x] Use one private npm workspace and one authoritative root lockfile.
- [x] Pin Node 20 and require npm 10 or newer.
- [x] Delegate `start`, `dev`, `dev:fast`, `check`, `lint`, `build`, and
      `package` from the repository root.
- [x] Remove the misleading `npm test` build alias.
- [x] Add deterministic theme and plugin package commands.
- [x] Upgrade the maintained Node toolchain.

Run every npm command from the repository root. Run Composer commands from the
theme or plugin directory that owns the relevant `composer.json`.

`npm audit --omit=dev` reports zero shipped vulnerabilities. The full audit
currently reports six development-only advisories inherited through
`@wordpress/scripts@33.0.0`; npm's proposed automatic fix is an incompatible
downgrade to version 19. Keep the lockfile current and remove those advisories
when WordPress publishes a compatible toolchain update rather than forcing
unsupported transitive versions.

## Task 3 — Theme structure

- [x] Keep runtime templates at the theme root and helpers under `inc/`.
- [x] Keep reusable rendering under `template-parts/`, assignable templates
      under `page-templates/`, patterns under `patterns/`, and editable browser
      source under `src/`.
- [x] Fail clearly when a required PHP module is missing.
- [x] Remove activation-time menu/content mutations.
- [x] Generate and validate `FILE-MANIFEST.txt` from the real theme tree.
- [x] Keep development-only source and tooling out of the installable ZIP.

## Task 4 — Page and content templates

- [x] Use the normal loop and content template parts consistently.
- [x] Separate static front-page content from the posts page.
- [x] Preserve editor-authored front-page content without adding a second H1.
- [x] Use valid heading levels and accessible no-results labelling.
- [x] Standardize page-navigation labels and page-intro containers.
- [x] Hide legacy duplicate page templates from new assignments while
      preserving existing assignments.

## Task 5 — Header, footer, and navigation

- [x] Keep the theme functional without either optional plugin.
- [x] Render a native WordPress menu with usable parent links.
- [x] Give submenu controls unique IDs, keyboard behavior, and progressive
      enhancement.
- [x] Implement the previously empty mobile-navigation template part.
- [x] Capability-check optional NY Mega Menu integration so the theme remains
      functional when the plugin is inactive.
- [x] Use accessible footer navigation and omit unconfigured public form
      placeholders.

## Task 6 — Homepage

- [x] Resolve destination links from real pages and omit unavailable CTAs.
- [x] Use sticky posts as the explicit featured-work selection.
- [x] Exclude featured posts from the latest-post list.
- [x] Correct heading hierarchy and empty states.
- [x] Remove duplicated process-step output and translate maintained strings.
- [x] Replace the unrelated theme screenshot with a representative 1200×900
      preview.

## Task 7 — WordPress.org plugin readiness

Both plugins now include matching headers and stable tags, GPL metadata,
`readme.txt`, translation templates, uninstall cleanup, Composer standards,
PHPUnit configuration, official Plugin Check CI, and installer-ready ZIP
packaging that excludes development files.

### NYforms

- [x] Protect uploads outside the public web root by default.
- [x] Require authorized downloads and clean files with their entries.
- [x] Use exact email matching and deletion-safe privacy erasure batches.
- [x] Document optional Google reCAPTCHA transmission and policies.
- [x] Remove dynamic JavaScript execution from calculations.
- [x] Redact notification events and handle persistence failures.

### NY Mega Menu

- [x] Preserve no-JavaScript navigation and parent destinations.
- [x] Complete keyboard, nested-panel, drawer, and responsive state handling.
- [x] Supply a block editor script, dependency metadata, server preview, and
      registered-location selector.
- [x] Replace free-text widget locations with registered choices.
- [x] Keep development tests outside the release package.

Packaged activation and primary workflows have been tested in the designated
local WordPress sandbox on WordPress 7.0.2 and PHP 8.2.29. Before WordPress.org
submission, run Repository CI from the pushed branch and add optional directory
banner/icon/screenshots to the separate SVN `assets/` directory.

## Task 8 — Plugin feature review and roadmap

Implemented now:

- NYforms: configurable form behavior, confirmations, core email notification
  settings, safe calculation parsing, protected uploads, durable cleanup, and
  one-time resume/confirmation state.
- NY Mega Menu: editor-aware dynamic block, unique render IDs, progressive
  no-JavaScript output, nested menu state fixes, and registered widget
  locations.

Recommended next improvements:

### NYforms

- Add a visual condition builder for fields, confirmations, and notifications.
- Support multiple ordered confirmations and notifications in the builder.
- Add asynchronous delivery with retry/backoff and an administrator log.
- Add encrypted-at-rest field options and per-form retention overrides.
- Repeat local browser regression checks for multi-page forms, uploads,
  calculations, and assistive-technology announcements as those features
  change.

### NY Mega Menu

- Add block controls for theme/style selection and an explicit preview state.
- Add import/export conflict previews before replacing a menu theme.
- Add admin accessibility tests for menu-item controls and the theme editor.
- Repeat local browser regression checks for hover intent, touch, nested Escape
  handling, focus containment, and reduced motion as those features change.
- Add optional performance diagnostics for unusually large menus.

## Task 9 — SCSS ownership

- [x] Keep Sass tokens and mixins selector-free under `abstracts/`.
- [x] Emit runtime custom properties from `base/_root.scss`.
- [x] Keep WordPress editor content rules in `base/_wordpress-content.scss`.
- [x] Keep shared entry, newsletter, brand, process, and CTA rules in
      `components/`.
- [x] Limit `pages/_homepage.scss` to homepage-specific composition.
- [x] Remove unused accordion, carousel, comparison, and portfolio-filter
      sources.
- [x] Prevent plugin-prefixed selectors and frontend layer imports from
      leaking into theme/editor SCSS.
- [x] Enforce ownership, page scoping, and one-time imports with
      `validate-scss-architecture.js`.
