# TYPO3 Extension ot-irrebuttons

This extension adds database fields to the tt_content table in TYPO3,
which enables the output of buttons without having to add them to the RTE.

Advantages:

- Central control of the button layout
- Icons in the button are easy to implement
- Configurable for different CTypes

## Installation

```shell
composer req oliverthiele/ot-irrebuttons
```

## Configuration

### Customization of the extension settings

#### CTypes

The CTypes for which the buttons are to be displayed can be configured in the extension settings.

**(Admin Tools -> Settings -> Extension Configuration -> ot_irrebuttons -> CTypes with IRRE Buttons)**

For each CType, the corresponding FluidTemplate from EXT:fluid_styled_content must then also be overwritten in its own
SitePackage. An example is provided for CType "text".

The following HTML code must then be added:

```html
<f:if condition="{irreButtons}">
    <f:render partial="IrreButtons" section="Main" arguments="{data : data, irreButtons : irreButtons}"/>
</f:if>
```

#### Icons

The icon identifiers can be specified here as a comma-separated list.

As an example, a few [Bootstrap Icons](https://icons.getbootstrap.com/) are preset here:

`bi-chevron-left, bi-chevron-right, bi-download, bi-file, bi-file-pdf, bi-send`.

The icon identifiers are then output in the partial _EXT:ot_irrebuttons/Resources/Private/Bootstrap5/Partials/Icon.html_.
This partial can be overwritten in your own SitePackage so that SVG sprites, for example, can also be implemented.

### TypoScript

The constant `projectSettings.framework.directory` must be set in the TypoScript.
This can also be done in your own SitePackage. In the supplied _constants.typoscript_ file the preset is _Bootstrap5_.
I use this constant to centrally adjust the path to the template files in my other extensions.
If I change to a different framework at a later date, I can then change all template files in one place.

### Customization of the partial for icons

The _Icon.html_ partial is used by default. The path must be overwritten in your own SitePackage!
Depending on the icon set used (e.g. Bootstrap Icons, FontAwesome, own ViewHelper, ...) this file must be
adapted differently. For this purpose, an additional path to the FluidTemplate files can be specified in the TypoScript:

Example:

```typo3_typoscript
lib.contentElement {
    templateRootPaths {
        40 = EXT:my_sitepackage/Resources/Private/Content/Templates/
    }
    partialRootPaths {
        40 = EXT:my_sitepackage/Resources/Private/Content/Partials/
    }
    layoutRootPaths {
        40 = EXT:my_sitepackage/Resources/Private/Content/Layouts/
    }
}
```
