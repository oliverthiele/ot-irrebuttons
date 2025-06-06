# TYPO3 Extension ot-irrebuttons

Mit dieser Erweiterung wird in TYPO3 die Tabelle tt_content um Datenbankfelder erweitert,
die eine Ausgabe von Buttons ermöglicht, ohne dass diese im RTE ergänzt werden müssten.

Vorteile:

- Zentrale Steuerung des Button-Layouts
- Icons im Button sind einfach zu realisieren
- Konfigurierbar für unterschiedliche CTypes

## Installation

```shell
composer req oliverthiele/ot-irrebuttons
```

## Konfiguration

### Anpassung der Extension Settings

#### CTypes

Die CTypes, bei denen die Buttons angezeigt werden sollen, können in den Extension-Settings konfiguriert werden.

**(Admin Tools -> Settings -> Extension Configuration -> ot_irrebuttons -> CTypes with IRRE Buttons)**

Für jeden CType muss dann auch das entsprechende FluidTemplate aus EXT:fluid_styled_content im eigenen
SitePackage überschrieben werden. Für CType "text" ist ein Beispiel mitgeliefert.

Ergänzt werden muss dann der folgende HTML-Code:

```html
<f:if condition="{irreButtons}">
    <f:render partial="IrreButtons" section="Main" arguments="{data : data, irreButtons : irreButtons}"/>
</f:if>
```

#### Icons

Als Komma-separierte Liste können hier die Icon-Identifier angegeben werden.

Als Beispiel sind hier ein paar [Bootstrap Icons](https://icons.getbootstrap.com/) voreingestellt:

`bi-chevron-left, bi-chevron-right, bi-download, bi-file, bi-file-pdf, bi-send`

Die Icon Identifier werden dann im Partial _EXT:ot_irrebuttons/Resources/Private/Bootstrap5/Partials/Icon.html_
ausgegeben. Dieses Partial kann im eigenen SitePackage überschrieben werden, damit auch z.B. SVG-Sprites implementiert
werden können.

### TypoScript

Im TypoScript muss die Konstante `projectSettings.framework.directory` gesetzt sein.
Dies kann z.B. auch im eigenen SitePackage erfolgen. In der mitgelieferten _constants.typoscript_ Datei
ist _Bootstrap5_ voreingestellt. Mit dieser Konstante passe ich in meinen anderen Extensions zentral den Pfad zu den
Template-Dateien an. Bei einem späteren Wechsel zu einem anderen Framework kann ich dann an einer Stelle alle
Template-Dateien umstellen.

Mit der Version **v3.1.0** werden die TYPO3 Site Sets unterstützt. Hier wird nicht mehr die Konstante
projectSettings.framework.directory sondern sitekit.frameworks.frontend.directory genutzt.
Diese Konstante setze ich bei meinen diversen Sitekit Extensions ein. Damit die alten Installationen weiterhin
funktionieren, habe ich die Konstante `projectSettings.framework.directory`noch nicht entfernt.

### Anpassung des Partials für Icons

Per Default wird das Partial _Icon.html_ verwendet. Der Pfad muss im eigenen SitePackage überschrieben werden!
Je nach eingesetztem Icon-Set (wie z.B. Bootstrap Icons, FontAwesome, eigener ViewHelper, ...) muss diese Datei
unterschiedlich angepasst werden. Dazu kann im TypoScript ein weiterer Pfad zu den FluidTemplate-Dateien angegeben
werden:

Beispiel:

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
