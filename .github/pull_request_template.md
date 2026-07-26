## Summary

Describe the purpose and scope of this change.

## Source-of-truth confirmation

- [ ] I edited maintained source files, not generated bundles.
- [ ] SCSS changes were made under `src/scss/`.
- [ ] JavaScript changes were made under `src/js/`.
- [ ] Persistent/business functionality remains outside the theme.
- [ ] `functions.php` remains bootstrap-only.

## Validation

- [ ] From the repository root, `npm ci` completed when dependencies changed or the checkout was new.
- [ ] From the repository root, `npm run build` passed as the final production build.
- [ ] Generated files under `assets/css/` and `assets/js/` are committed and current.
- [ ] Repository guardrails and the redacted secret scan passed.
- [ ] PHP 7.4 and PHP 8.4 syntax checks passed.
- [ ] Relevant Composer coding-standard checks passed.
- [ ] WordPress PHPUnit tests ran in a configured WordPress test environment when relevant.
- [ ] The theme was reviewed in a local or staging WordPress installation.
- [ ] Navigation, forms, keyboard behavior, responsive layouts, and browser console were checked when relevant.

## Release impact

- [ ] No release required.
- [ ] Patch release.
- [ ] Minor release.
- [ ] Major/breaking release.

`npm run package` is optional during pull requests. Use the separate **Theme Package** workflow or a `v*` tag when an installable ZIP is required.

## Deployment impact

- [ ] No Pressable deployment-path or `.deployignore` change.
- [ ] Pressable staging deployment was reviewed before production.
- [ ] Unrelated server themes, plugins, and must-use plugins remain protected.

## Screenshots or test notes

Add visual evidence or focused test results when the change affects presentation or behavior.
