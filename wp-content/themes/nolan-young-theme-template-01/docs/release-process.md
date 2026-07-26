# Release process

Run every npm command in this process from the repository root.

1. Update the version in `style.css` and the theme workspace's `package.json`, update the root `package-lock.json`, and document the release in `CHANGELOG.md`.
2. Run `npm ci` from a clean source checkout.
3. Stop `npm run start`, `npm run dev:fast`, or `npm run dev` if a watcher is active.
4. Run `npm run build` as the final asset command. It cleans, lints, compiles optimized assets, and validates the theme.
5. Run PHP syntax checks, WordPress Coding Standards, and the WordPress PHPUnit suite.
6. Test with `WP_DEBUG` enabled on WordPress 7.0 and the declared PHP range.
7. Test Theme Unit Test content, keyboard behavior, comments, search, archives, pagination, 404, privacy page, and companion-plugin integrations.
8. Optionally run `npm run package` to rebuild and create one timestamped ZIP in `dist/` with one top-level theme directory and no development-only dependencies.
9. Install the generated ZIP on a clean staging site and complete final browser, responsive, accessibility, and cache checks.
