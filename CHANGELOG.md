# Changelog

All notable repository-level changes are documented in this file.

## 2026-07-31

### Added

- Added `nolan-young-demo-theme-003` as an independently namespaced classic WordPress theme with a modernist design system, six generated photographic assets, distinct page templates, and validated packaging automation.
- Added a 50/50 image-led Services mega menu to Demo Theme 003 with five service categories and hover, focus, click, and arrow-key interaction.
- Added `nolan-young-demo-theme-002` on its own development branch as a complete, independently namespaced classic WordPress theme with an editorial atelier design system, six locally generated photographic assets, and a full development and packaging workflow.
- Added an accessible image-led 50/50 Services mega menu to Demo Theme 002 with hover, focus, click, arrow-key, Home, and End interactions across five service categories.
- Added `nolan-young-demo-theme-001` as a complete, independently namespaced classic WordPress theme with the full PHP template hierarchy, development sources, build tooling, accessibility guidance, translation catalog, and validated packaging workflow.
- Added an accessible 50/50 Services mega menu to Master 99 with five interactive service categories, detailed capability panels, responsive layouts, keyboard navigation, and animated CSS mascots.
- Added theme-identity and required-module checks to the Demo Theme 001 build validator.
- Added an optimized ground-up theme implementation sequence to Demo Theme 001's `AGENTS.md`.

### Changed

- Reworked Demo Theme 002's homepage into an editorial cover, service folio, case-note spread, studio rhythm, and invitation layout that is structurally and visually independent from Demo Theme 001.
- Replaced inherited placeholder and robot-style artwork in Demo Theme 002 with packaged, generated studio photography and a restrained image transition in the Services mega menu.
- Simplified the Master 99 blog index into a responsive four-column card grid with clearer post links and pagination.
- Kept Master 99's top-level mega panels click-controlled while preserving hover and focus switching inside the Services panel.
- Updated Demo Theme 001 documentation to match the approved npm command surface and release ZIP destination.

### Fixed

- Made Master 99 packaging create `wp-content/zipped-theme/` automatically when it is missing.
- Replaced Master 99's external `unzip` dependency with Node-based ZIP central-directory inventory validation for cross-platform packaging.
- Removed horizontal viewport overflow from Master 99's fixed desktop and mobile navigation layers.
