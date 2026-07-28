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
- Visual icon selector with search, SVG preview and favourites when
  [ot_iconselector](https://packagist.org/packages/oliverthiele/ot-iconselector)
  is installed
- Icon partial can be overridden per project (Bootstrap Icons, FontAwesome, SVG
  sprites, …)
- Configurable per CType via extension settings
- Fancybox lightbox link types — Ajax for internal pages, iFrame for external
  links or pages that need their own CSS/JS
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

| Setting                      | Description                                                                                                                                                           |
|------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| CTypes with IRRE Buttons     | Comma-separated list of CTypes that show the buttons                                                                                                                  |
| Icons                        | Comma-separated list of icon identifiers offered in the `Icon` field (not used when `ot_iconselector` is installed — see [Icon Selector](#icon-selector-optional) below) |
| Path to directory with icons | Directory holding the SVG files for the backend preview of the above identifiers, e.g. `EXT:my_sitepackage/Resources/Public/Icons/solid/`                              |
| Lightbox link types          | Comma-separated list of `lightbox`/`lightboxIframe` options to offer (empty hides the field — see [Lightbox link types](#lightbox-link-types-ajax--iframe) below)      |

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

### Lightbox link types (Ajax / iFrame)

The `link_type` field's `lightbox` and `lightboxIframe` options open the
linked target in a [Fancybox](https://fancyapps.com/fancybox/) lightbox
instead of navigating to it:

| `link_type`      | `t3://page?uid=...` (internal) | `http(s)://...` (external) | file / `mailto:` / `tel:` |
|-------------------|---------------------------------|------------------------------|---------------------------|
| `lightbox`        | Ajax                            | iFrame                       | plain link (no lightbox)  |
| `lightboxIframe`  | iFrame                          | iFrame                       | plain link (no lightbox)  |

**Prefer Ajax for internal pages.** An iFrame is a separate browsing context —
the surrounding page cannot read its content height, so the iFrame needs the
fixed `height: 80vh` from the SCSS below and keeps that height even when the
content only fills a fraction of it. Ajax content is injected into the parent
document, where `max-height: 80vh` lets the lightbox shrink to the actual
content height. Use `lightboxIframe` only when the target page needs its own
CSS/JS that the Ajax route does not load.

Both options depend on infrastructure the extension does **not** provide —
set this up once per site before enabling `lightboxTypes`
(see [Extension Settings](#extension-settings)):

1. **Route enhancer** — map two page-type suffixes in your site's
   `config/sites/{site}/config.yaml`:

   ```yaml
   routeEnhancers:
     PageTypeSuffix:
       type: PageType
       default: ''
       index: index
       map:
         content.html: 112234
         ajax.html: 112235
   ```

   The typeNum values are free to choose as long as they don't collide with
   existing ones — just keep them consistent with the `PAGE` objects below.

2. **TypoScript `PAGE` objects** — in your SitePackage (`EXT:my_sitepackage`),
   define one `PAGE` object per typeNum that renders the requested page's
   `colPos=0` content in isolation:

   ```typoscript
   # Full document with CSS/JS, no header/footer — used by lightboxIframe
   pageLightboxIframe = PAGE
   pageLightboxIframe {
       typeNum = 112234
       config {
           admPanel = 0
           debug = 0
           linkVars := removeFromList(type)
       }

       headerData >

       includeCSS {
           myProject = EXT:my_sitepackage/Resources/Public/Assets/Styles/Main.css
       }

       includeJSFooter {
           myProject = EXT:my_sitepackage/Resources/Public/Assets/JavaScript/Main.js
       }

       10 = FLUIDTEMPLATE
       10 {
           templateName = Iframe
           templateRootPaths.10 = EXT:my_sitepackage/Resources/Private/PageView/Pages/
           variables {
               content0 = CONTENT
               content0 {
                   table = tt_content
                   select {
                       where = {#colPos}=0
                       orderBy = sorting
                   }
               }
           }
       }

       20 >
   }

   # Raw content only, no CSS/JS/head/body — used by lightbox (Ajax)
   pageLightboxAjax = PAGE
   pageLightboxAjax {
       typeNum = 112235
       config {
           disableAllHeaderCode = 1
           admPanel = 0
           debug = 0
           linkVars := removeFromList(type)
       }

       10 = FLUIDTEMPLATE
       10 {
           templateName = Ajax
           templateRootPaths.10 = EXT:my_sitepackage/Resources/Private/PageView/Pages/
           variables {
               content0 = CONTENT
               content0 {
                   table = tt_content
                   select {
                       where = {#colPos}=0
                       orderBy = sorting
                   }
               }
           }
       }
   }
   ```

   Keep `linkVars := removeFromList(type)` on both objects. Without it, every
   link generated *from inside* the lightbox content (e.g. a normal editorial
   link in a privacy-policy text) would inherit the current typeNum and
   silently open as another bare Ajax/content-only fragment instead of a
   normal page.

3. **Fluid templates** — `Iframe` outputs `{content0}`. `Ajax` must not
   include a surrounding `<html>`/`<head>`/`<body>` (its output is injected
   into an existing page via Ajax, not loaded as a standalone document) and
   must wrap `{content0}` in `<div class="lightbox-ajax-scroll">…</div>` — the
   scroll-height cap in the SCSS below targets that wrapper.

   In **both** templates, wrap `{content0}` in a `container` — Bootstrap rows
   carry negative side margins (`-.5 * $gutter-x`) that are meant to be
   absorbed by a container's padding. Without one, every row overflows its
   parent by that amount and the lightbox shows a spurious horizontal
   scrollbar:

   ```html
   <!-- Iframe -->
   <div class="container-fluid">{content0 -> f:format.raw()}</div>

   <!-- Ajax -->
   <div class="lightbox-ajax-scroll">
       <div class="container-fluid">{content0 -> f:format.raw()}</div>
   </div>
   ```

   Use `container` instead of `container-fluid` if the lightbox content should
   follow the same max-widths as a regular page.

4. **Frontend JS** — bind Fancybox once for `[data-fancybox]`, e.g.:

   ```javascript
   import {Fancybox} from "@fancyapps/ui/dist/fancybox/fancybox.js";
   Fancybox.bind("[data-fancybox]");
   ```

5. **SCSS** — Fancybox v6 does not cap the popup size on its own; without
   this it fills the full viewport instead of reading as a lightbox
   (assumes Bootstrap 5, for `$container-max-widths` /
   `media-breakpoint-up`):

   ```scss
   .has-iframe .f-html,
   .has-ajax .f-html {
       @include media-breakpoint-up(sm) { max-width: map-get($container-max-widths, sm); }
       @include media-breakpoint-up(md) { max-width: map-get($container-max-widths, md); }
       @include media-breakpoint-up(lg) { max-width: map-get($container-max-widths, lg); }
       @include media-breakpoint-up(xl) { max-width: map-get($container-max-widths, xl); }
       @include media-breakpoint-up(xxl) { max-width: map-get($container-max-widths, xxl); }
   }

   .has-iframe .f-html {
       height: auto;

       iframe {
           height: 80vh;
           max-height: 80vh;
       }
   }

   .has-ajax .f-html .lightbox-ajax-scroll {
       max-height: 80vh;
       overflow-y: auto;
   }
   ```

If this setup is not in place, leave `lightboxTypes` empty — the `link_type`
field is then omitted from the editing form entirely.

### Icon Partial

The shipped partial `Partials/Icon.html` receives the stored identifier as
`{iconIdentifier}` and renders it as a [Bootstrap Icons](https://icons.getbootstrap.com/)
element:

```html
<i class="bi bi-{iconIdentifier}"></i>
```

This is a placeholder — override it in your SitePackage to match your icon set
(FontAwesome, an SVG sprite, the `ot_icons` ViewHelper, …). The extension
registers its own partial path at index `15`, so any higher index wins:

```typoscript
lib.contentElement {
    partialRootPaths {
        40 = EXT:my_sitepackage/Resources/Private/Content/Partials/
    }
}
```

Your override must provide a `Main` section, since the partial is rendered with
`<f:render partial="Icon" section="Main" arguments="{iconIdentifier: ...}"/>`.
Using `ot_icons`, for example:

```html
<f:section name="Main">
    <i:icon identifier="{iconIdentifier}" aria-hidden="true"/>
</f:section>
```

### Icon Selector (optional)

Without further dependencies the `Icon` field is a select box filled from the
`Icons` extension setting (see [Extension Settings](#extension-settings)), with
the backend preview icons taken from `Path to directory with icons`.

If `oliverthiele/ot-iconselector` is installed, the field is rendered as a
visual selector instead: search with live SVG preview across the whole icon
directory configured in the site setting `otIcons.iconDirectory`. The `Icons`
and `Path to directory with icons` extension settings are then no longer used
for this field — every icon of the directory becomes selectable.

Frequently used button icons can be pre-selected for editors via the site
setting `otIconselector.favorites.buttons` (comma-separated list of icon
identifiers). If it is empty, `otIconselector.favorites.default` is used:

```yaml
settings:
  otIconselector:
    favorites:
      buttons: 'chevron-right,download,file-pdf,arrow-up-right-from-square'
```

Stored values are plain icon identifiers in both cases, so the `Icon` partial
and existing records work unchanged.

**Requires a resolvable icon directory.** If `otIcons.iconDirectory` is empty
or points to a directory that does not exist, the selector could never return a
result — the `Icon` and `Icon Position` fields are therefore hidden instead of
showing a widget that stays empty. Set the site setting (normally provided by
[ot_icons](https://packagist.org/packages/oliverthiele/ot-icons)) to make them
reappear:

```yaml
settings:
  otIcons:
    iconDirectory: 'EXT:my_sitepackage/Resources/Public/Icons/'
```

The directory is expected to hold one subdirectory per icon style (`solid/`,
`regular/`, …, plus an optional `brands/`), matching what the selector
searches.

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
