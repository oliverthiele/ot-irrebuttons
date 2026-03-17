# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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

[Unreleased]: https://github.com/oliverthiele/ot-irrebuttons/compare/v3.2.7...HEAD
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