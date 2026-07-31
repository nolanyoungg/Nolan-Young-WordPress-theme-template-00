# Repository Guidelines

## Project Structure & Module Organization

This repository tracks WordPress content only, not WordPress core, the database, uploads, or environment configuration. The active rebuild theme is `wp-content/themes/nolan-young-theme-template-99-master`. Its PHP templates and helpers live in `inc/`, `template-parts/`, and `page-templates/`; editable frontend sources live in `src/scss/` and `src/js/`; browser-ready output lives in `dist/css/`, `dist/js/`, `dist/images/`, and `dist/icons/`. The theme's Node build scripts live in `build/`. Plugins live in `wp-content/plugins/`, including `nyforms` and `nymegamenu`, with implementation in `includes/` and frontend assets in `assets/`. NY Mega Menu's development-only PHPUnit suite and tool configuration live in `tests/nymegamenu/`, outside its release package. Keep must-use plugin work under `wp-content/mu-plugins/`.

## Build, Test, and Development Commands

The designated runtime sandbox for `nolan-young-theme-template-99-master` is:

`/Users/nolany/Developer/Sandbox/ny-wp-test-playground/app/public/wp-content/themes/nolan-young-theme-template-99-master`

The sandbox must contain the complete development theme. It must not be populated from the stripped production ZIP. Before frontend development or visual inspection, confirm that all of the following exist in the sandbox theme:

- `build/`
- `src/`
- `package.json`
- `package-lock.json`
- `node_modules/` after dependency installation
- `dist/`

The npm working directory is the theme root containing `package.json` and `build/`; do not `cd` into `build/`. The files in `build/` are the scripts invoked by the npm commands.

Required local-development sequence:

1. Inspect the repository worktree and preserve unrelated changes.
2. Synchronize the complete repository development theme into the sandbox theme, including `build/`, `src/`, package files, PHP, and runtime assets. Never use the production package as the development copy.
3. Run `npm install` from the sandbox theme root before development begins and whenever `package-lock.json` changes.
4. Run `npm run dev` from the sandbox theme root while making and visually inspecting frontend changes.
5. Keep repository source and sandbox source synchronized before every runtime inspection; do not claim to have inspected code that was not copied into the sandbox.
6. Before handoff, run `npm run lint:php` and `npm run build` against the final source. Run `npm run package` from the repository theme root so the verified archive targets the repository's `wp-content/zipped-theme/`.

The required theme commands are:

- `npm install` installs the dependencies declared by `package.json` and `package-lock.json`.
- `npm run dev` performs an initial build and watches SCSS and JavaScript for changes.
- `npm run build` creates minified production assets and validates theme structure.
- `npm run lint:php` checks every theme PHP file.
- `npm run package` performs destination preflight, builds, and creates the validated production ZIP.

Do not hand the theme back based only on source inspection or a repository-side build. The final sandbox copy must match the reviewed repository source, its watcher/build output must be current, and the rendered WordPress pages must be inspected in the designated sandbox.

Do not add `composer.json`, Composer dependencies, PHPUnit, or Composer commands to `nolan-young-theme-template-99-master`. This theme uses only the npm command surface listed above.

## Coding Style & Naming Conventions

Follow `.editorconfig`: use tabs in PHP, two spaces in CSS, SCSS, JavaScript, JSON, YAML, and Markdown, LF endings, and a final newline. Follow WordPress Coding Standards and existing WordPress naming conventions: prefix public PHP functions, hooks, options, CSS classes, and handles with the component slug (for example, `nytt99_`, `nymegamenu_`, or `nyforms_`). Modify `src/` files rather than generated theme assets, then rebuild the matching `dist/` output. During theme 99 development, synchronize source changes to the sandbox before runtime inspection.

## Testing Guidelines

Exercise capability checks, sanitization, escaping, rendering, and relevant keyboard and responsive paths. Run `npm run lint:php` during development and `npm run build` before a theme-facing change is proposed. Do not introduce a separate test framework or additional public npm scripts without explicit user approval.

## Commit and Pull Request Guidelines

Use a scoped branch such as `feature/mobile-menu-focus` or `fix/form-validation`. Write concise imperative Conventional Commit-style subjects, for example `fix: restore parent menu links`; keep commits small and reversible. Pull requests should state purpose, affected paths, validation performed, rollout or migration considerations, and linked issues. Include screenshots or a short recording for visible admin or frontend changes. Never commit credentials, database exports, `node_modules/`, `vendor/`, local WordPress configuration, or generated diagnostic logs.
