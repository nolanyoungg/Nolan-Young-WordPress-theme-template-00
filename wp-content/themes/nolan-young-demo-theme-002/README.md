# Nolan Young Demo Theme 002

A complete classic PHP WordPress studio theme with an editorial atelier design, an accessible image-led mega menu, and six locally generated photographic assets.

## Visual direction

Theme 002 uses aubergine, moss, dusty rose, oat, and antique-brass accents. Its page composition, folio cards, case-note layouts, and studio-style typography are intentionally independent from Demo Theme 001. The generated photography is packaged locally under `dist/images/generated/`; no remote stock-image service or placeholder art is required.

## Commands

- `npm install` installs the locked development dependencies.
- `npm run build` compiles production browser assets.
- `npm run dev` watches source styles and scripts.
- `npm run lint:php` checks every theme PHP file for syntax errors.
- `npm run package` builds and validates the release ZIP in `wp-content/zipped-theme/`.

Edit source in `src/`; do not hand-edit generated files in `dist/css` or `dist/js`.
