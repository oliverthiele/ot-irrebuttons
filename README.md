# IRRE Buttons — Adds manageable buttons to TYPO3 content elements

Extends `tt_content` with IRRE-managed button records — buttons are configured
directly in the backend without touching the RTE.

[![TYPO3](https://img.shields.io/badge/TYPO3-13.4%20%7C%2014.3-orange.svg)](https://typo3.org/)
[![Packagist Version](https://img.shields.io/packagist/v/oliverthiele/ot-irrebuttons.svg)](https://packagist.org/packages/oliverthiele/ot-irrebuttons)
[![PHP](https://img.shields.io/packagist/dependency-v/oliverthiele/ot-irrebuttons/php.svg)](https://php.net/)
[![License](https://img.shields.io/packagist/l/oliverthiele/ot-irrebuttons.svg)](LICENSE)
[![Changelog](https://img.shields.io/badge/Changelog-CHANGELOG.md-blue.svg)](CHANGELOG.md)

## Features

- Buttons are managed as IRRE child records — no RTE markup required
- Central control over button layout (style, size, position)
- Optional icon support via a configurable list of icon identifiers
- Icon partial can be overridden per project (Bootstrap Icons, FontAwesome, SVG
  sprites, …)
- Configurable per CType via extension settings
- Fancybox link type support
- Compatible with TYPO3 content Slide (records from parent pages render
  correctly)
- SiteSet support via `sitekit.frameworks.frontend.directory`

## Requirements

| Dependency | Version        |
|------------|----------------|
| TYPO3      | ^13.4 \| ^14.3 |
| PHP        | >=8.3          |

## Installation

```bash
composer require oliverthiele/ot-irrebuttons
```

## Configuration

### Extension Settings

Open **Admin Tools → Settings → Extension Configuration → ot_irrebuttons**.

| Setting                  | Description                                          |
|--------------------------|------------------------------------------------------|
| CTypes with IRRE Buttons | Comma-separated list of CTypes that show the buttons |
| Icons                    | Comma-separated list of icon identifiers             |

For each configured CType the corresponding Fluid template from
`EXT:fluid_styled_content` must be overridden in your SitePackage.
A ready-to-use example is included for CType `text`.

### TypoScript / SiteSet

The extension ships a SiteSet (`OtIrrebuttons`). Include it as a dependency in
your site's SiteSet configuration — no manual TypoScript include required.

The template path constant `sitekit.frameworks.frontend.directory` (default:
`Bootstrap5`) is provided by the SiteSet. Change the value in your site
configuration if your project uses a different frontend framework directory.

> The legacy constant `projectSettings.framework.directory` is still evaluated
> for backwards compatibility with installations that do not use SiteSets.

### Icon Partial

The partial `IrreButtons/Icon.html` renders the icon identifier as plain text by
default. Override the partial path in your SitePackage to adapt it to your icon
set:

```typoscript
lib.contentElement {
    partialRootPaths {
        40 = EXT:my_sitepackage/Resources/Private/Content/Partials/
    }
}
```

## Usage

Add the following snippet to any Fluid template where buttons should appear:

```html

<f:if condition="{irreButtons}">
    <f:render partial="IrreButtons" section="Main"
              arguments="{data: data, irreButtons: irreButtons}"/>
</f:if>
```

The variable `irreButtons` is populated automatically by the included
DataProcessor for every CType listed in the extension settings.

## License / Author

GPL-2.0-or-later
© [Oliver Thiele](https://www.oliver-thiele.de)
