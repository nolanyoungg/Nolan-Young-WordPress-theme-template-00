# Architecture

This is a self-contained classic PHP WordPress theme enhanced by `theme.json`. Root templates control requests, template parts render presentation, `inc/` contains narrowly scoped theme modules, and `src/` is the only editable CSS/JavaScript source. Optional bundled plugins add forms or enhanced navigation without being required by the theme.

## Boundaries

- Theme: layout, markup, editor styles, block styles, patterns, navigation, and presentation integration.
- Optional plugin: its own form processing, stored submissions, enhanced navigation, and privacy operations.
- Generated files: `assets/css/bundle.css`, `assets/css/editor.css`, and `assets/js/bundle.js`; never edit these directly.
