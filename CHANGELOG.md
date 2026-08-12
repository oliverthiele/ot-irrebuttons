# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [5.0.1] — 2026-08-12

### Fixed

- The site set replaced the resource paths with
  `{$sitekit.frameworks.frontend.directory}` unconditionally. In projects
  without `ot_sitekitbase` nothing defines that constant, so the paths stayed
  unresolved and the button partials were no longer found. The override now
  runs inside `[isLoaded('ot_sitekitbase')]`
- The site set did not import the extension constants, leaving
  `{$projectSettings.framework.directory}` without a default

## [5.0.0] — 2026-07-31

### Changed

- **Breaking:** Drop TYPO3 v13 support, require TYPO3 `^14.3`
- **Breaking:** Raise the PHP minimum to `>=8.4`, matching what the SiteKit
  distribution already enforces

## [4.1.0] — 2026-07-28

### Added

- Optional integration of `ot_iconselector`: if the extension is installed, the
  button `Icon` field is rendered with the visual icon selector (search, SVG
  preview, favourites) instead of the select box built from the `icons`
  extension setting. Integrator favourites can be defined in the site setting
  `otIconselector.favorites.buttons`. Without `ot_iconselector` nothing changes
- New `link_type` option `lightboxIframe` — always opens the lightbox via
  iFrame, for internal target pages that need their own CSS/JS not loaded by
  the Ajax route
- `IconSelectorDisplayCondition` hides the `Icon` and `Icon Position` fields
  while `ot_iconselector` renders them but the site setting
  `otIcons.iconDirectory` is empty or points to a directory that does not
  exist — the selector could not return a single result in that case
- Description for the `Icon` field (EN/DE) explaining the search and the
  favourites button, shown while the selector renders the field
- `lightboxTypes` extension configuration setting to control which lightbox
  options are offered in the "Link Type" field (or to hide the lightbox
  option entirely)
- README section documenting the route enhancer, `PAGE` objects, Fluid
  templates, JavaScript and SCSS required for the lightbox link types,
  including the container wrapper both templates need to avoid a horizontal
  scrollbar from Bootstrap's negative row margins, and why Ajax is preferable
  to iFrame for internal pages (an iFrame cannot size itself to its content)

### Changed

- `link_type=lightbox` now opens internal pages (`t3://page?uid=...`) via
  Ajax (`data-type="ajax"`, `/ajax.html` suffix) instead of iFrame; external
  links keep the iFrame behaviour
- The `link_type` field is now omitted from the palette entirely when
  `lightboxTypes` results in no selectable lightbox option (nothing to
  switch between)
- XLIFF files are indented with two spaces instead of tabs. The `.editorconfig`
  declared tabs for `*.xlf`, which contradicted the project convention

### Fixed

- `link_type=lightbox` on `mailto:`/`tel:` links no longer enables
  `data-fancybox` — these now render as plain links
- Reading the extension configuration no longer assumes the settings keys
  exist. `Configuration/Icons.php` additionally catches
  `ExtensionConfigurationExtensionNotConfiguredException`, which is thrown
  while the configuration has not been written yet (e.g. during the first
  request after installation)
- Empty entries in the `icons` setting (from a trailing comma) no longer
  produce a blank icon item
- Missing German translation for the `Link` button layout option
- `approved="yes"` removed from the English source file — the attribute belongs
  in translation files only

## [4.0.2] — 2026-06-17

### Fixed

- Use `_LOCALIZED_UID` in `IrreButtonsProcessor` so translated content elements
  load their own IRRE button records instead of the default language buttons

---

## [4.0.1] — 2026-04-25

### Fixed

- `ext_emconf.php`: remove title prefix from `description` field to prevent
  "Extension Title missing" warning in TYPO3 v14 backend

---

## [4.0.0] — 2026-04-25

### Added

- TYPO3 v14.3 support (`^13.4||^14.3`)
- `searchable: false` on `starttime`, `endtime`, and `link` TCA fields

### Changed

- Raise PHP minimum constraint to `>=8.3`
- Drop TYPO3 v12 support

---

## [3.2.9] — 2026-04-14

### Fixed
- Prevent "Undefined array key" PHP 8.x warning for `_ORIG_uid` in `IrreButtonsProcessor`
  — key is only present in workspace overlays, added `isset()` guard before `is_int()` check

## [3.2.8] — 2026-03-17

### Fixed
- Button rows are now wrapped in `['data' => $row]` to match the structure expected
  by the Fluid partial (`buttonData.data`) — buttons were silently empty before
- Removed `public: true` from `IrreButtonsProcessor` service definition (not needed
  with tag-based DataProcessor registration)

## [3.2.7] — 2026-03-17

### Fixed
- DataProcessor registration in `Services.yaml` — replaced incorrect Symfony `alias:`
  with the TYPO3-native `data.processor` tag and `identifier: ot-irrebuttons-processor`

## [3.2.6] — 2026-03-17

### Added
- Custom `IrreButtonsProcessor` DataProcessor — queries buttons by `parent_id` only,
  without any page (pid) restriction, ensuring correct rendering when content is
  inherited via TYPO3 Slide
- `Services.yaml` with DI configuration and alias `ot-irrebuttons-processor`
- `phpstan.neon.dist` at level 9

### Changed
- Updated `README.md` — English-only, Packagist badges, structured sections
- Replaced `README_DE.md` with `CHANGELOG.md`

## [3.2.5] — 2026-01-19

### Changed
- Updated gutter size variable to match updated SiteKit settings

## [3.2.4] — 2025-12-01

### Added
- Fancybox link type: adds `data-fancybox` attribute automatically when link type
  is set to `lightbox`

## [3.2.3] — 2025-12-01

### Added
- Support for SiteKit Gutter Size setting in button layout calculation

## [3.2.2] — 2025-11-24

### Changed
- Minor cleanup and code quality improvements

## [3.2.1] — 2025-10-27

### Changed
- Replaced `$_EXTKEY` with explicit extension key string for PHPStan compatibility
- Improved button functionality and extension internals

## [3.2.0] — 2025-06-16

### Changed
- Further updates to extension internals and button functionality

## [3.1.0] — 2025-06-06

### Added
- TYPO3 SiteSet support (`OtIrrebuttons`) — TypoScript is now auto-included via
  the SiteSet dependency mechanism
- New constant `sitekit.frameworks.frontend.directory` replaces
  `projectSettings.framework.directory` (legacy constant retained for
  backwards compatibility)
- Moved labels to `labels.xlf`

## [3.0.2] — 2025-01-24

### Fixed
- Alignment issue with single button usage

## [3.0.1] — 2025-01-22

### Fixed
- Removed deprecated `position` field from icon model

## [3.0.0] — 2025-01-22

### Added
- Full TYPO3 v12 support with updated TCA syntax

### Removed
- Deprecated `allowTableOnStandardPages` (removed in v2.0.1)

## [2.0.0] — 2024-03-24

### Added
- TYPO3 v12 release with updated TCA

## [1.0.1] — 2024-02-09

### Added
- `Button` Domain Model for use in Extbase extensions

## [1.0.0] — 2023-12-11

### Added
- Initial release
- IRRE button records on `tt_content`
- Configurable CTypes via extension settings
- Configurable icon identifiers
- Overridable `Icon.html` partial

[Unreleased]: https://github.com/oliverthiele/ot-irrebuttons/compare/v5.0.1...HEAD
[5.0.1]: https://github.com/oliverthiele/ot-irrebuttons/compare/v5.0.0...v5.0.1
[5.0.0]: https://github.com/oliverthiele/ot-irrebuttons/compare/v4.1.0...v5.0.0
[4.1.0]: https://github.com/oliverthiele/ot-irrebuttons/compare/v4.0.2...v4.1.0
[4.0.2]: https://github.com/oliverthiele/ot-irrebuttons/compare/v4.0.1...v4.0.2
[4.0.1]: https://github.com/oliverthiele/ot-irrebuttons/compare/v4.0.0...v4.0.1
[4.0.0]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.9...v4.0.0
[3.2.9]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.8...v3.2.9
[3.2.8]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.7...v3.2.8
[3.2.7]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.6...v3.2.7
[3.2.6]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.5...v3.2.6
[3.2.5]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.4...v3.2.5
[3.2.4]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.3...v3.2.4
[3.2.3]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.2...v3.2.3
[3.2.2]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.1...v3.2.2
[3.2.1]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.0...v3.2.1
[3.2.0]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.1.0...v3.2.0
[3.1.0]: https://github.com/oliverthiele/ot-irrebuttons/compare/3.0.2...v3.1.0
[3.0.2]: https://github.com/oliverthiele/ot-irrebuttons/compare/3.0.1...3.0.2
[3.0.1]: https://github.com/oliverthiele/ot-irrebuttons/compare/2.0.1...3.0.1
[2.0.0]: https://github.com/oliverthiele/ot-irrebuttons/compare/1.0.1...2.0.0
[1.0.1]: https://github.com/oliverthiele/ot-irrebuttons/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/oliverthiele/ot-irrebuttons/releases/tag/1.0.0