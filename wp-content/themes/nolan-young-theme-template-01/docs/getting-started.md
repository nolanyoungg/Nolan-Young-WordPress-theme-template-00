# Getting started

1. Install and activate `nolan-young-theme-template-01.zip`.
2. Assign Primary and Footer menus under Appearance.
3. Create a static front page and an optional posts page under Settings → Reading.
4. Assign page templates only where their specialized composition is needed.
5. Optionally activate the bundled NYforms or NY Mega Menu plugins when the site needs those features.

## Development

From the repository root, use the pinned Node 20 release and install the locked dependencies:

```bash
nvm use
npm ci
```

Use the standard readable WordPress watcher for normal debugging:

```bash
npm run start
```

Use the minified production-mode watcher when production-style output is specifically required during local work:

```bash
npm run dev
```

Stop either watcher with `Ctrl + C`. When development is complete, run the final production gate last:

```bash
npm run build
```

`npm run build` cleans generated assets, lints maintained source, creates optimized production assets, and validates the theme structure.

For PHP standards, install Composer dependencies and run `composer lint:php`.
