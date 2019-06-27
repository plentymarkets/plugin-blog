# Release notes for Blog plugin

## v1.0.2 (2019-06-27)

### NEW: OG Tags wurden hinzugefügt
- title = Metatitle
- description = Meta Description
- url = Relative URL zum Blogartikel
- image = Titelbild wenn verfügbar, sonst Vorschaubild. Wenn keines vorhanden wird kein og:image Tag übertragen.

### NEW: Custom fonts werden nun vom Blog unterstützt

### NEW: Der Landingpage Assistent is jetzt unter System >> Assistenten >> Omni Channel >> Blog verfügbar

## v1.0.0 (2019-06-19)

### NEW: Landingpage
Es wurde ein Assistent erstellt, um die Einsstiegsseite des Blogs einzurichten. 
Der Assistent kann für jede Plugin-Set und Sprache Kombination einzeln durchlaufen werden.
Einstellungen im Assistenten unter **System >> Assistenten**:
- Benutzerdefinierte URL
- Text für den Link zum Blog
- Text für den Link zurück zum Shop
- Titel der Landingpage
- Meta title
- Meta description
- Meta keywords
- Robots

Die Landingpage verhält sich sonst wie zuvor eine Kategorie.
- Benutzerdefinierte URL anpassen damit:
- URLs für Kategorien die benutzerdefinierte URL enthalten
- URLs für Blogbeiträge die benutzerdefinierte URL enthalten
- URLs von Such- und Tagseiten die benutzerdefinierte URL enthalten
**Das Plugin muss neu gebaut werden, damit diese Änderung sichtbar wird**

### Sonderfälle und Standards
URLs funktionieren nun folgendermaßen:
**Standard**
- /custom - oben genannte Landing page 
- /custom/category1 - Kategorie des Typs Blog auf 1. Ebene
- /custom/category1/category2 - Kategorie des Typs Blog auf 2. Ebene
- /custom/category1/category2/postUrlName - Blogbeitrag

**Special**
- /category1 - Kategorie des Typs Blog auf 1. Ebene funktionieren weiterhin, um 404 zu vermeiden
- /category1/category2 - Kategorie des Typs Blog auf 2. Ebene funktionieren weiterhin, um 404 zu vermeiden
- /custom/category1/category2/b-15 - Beitrag aus dem alten System, wird auf die neue migrierte URL weitergeleitet
    
**Default**
- Die Landingpage erhält als Default die URL /blog/, wenn keine benutzerdefinierte URL eingetragen wird.


### CHANGES: UI Frontend
- Shopbuilder Breadcrumbs werden auf Blogseiten unterdrückt
- Der Vorschautext wird nicht mehr im Body des Blogbeitrags angezeigt
- Optionale Einstellung im Plugin um den Einstieg zum Blog im Container automatisch zu verlinken
- Links enthalten nun benutzerdefinierte URL (Kategorie-, Beitrags- und Suchseiten)
- Breadcrumbs enthalten nun die benutzerdefinierte URL

Kategorieseiten:
- Kategoriename ist nun H1
- Beitragstitel als Link zum Beitrag ist nun H2
- Kategorienamen bei Beitragsvorschauen sind nur noch Text, war H5
Beitragsseiten:
- Kategoriename ist H2
- category name in the header is h2
- Titel des Beitrags ist H1

Blaue Einfärbungen sind nicht länger fix, der Blog nutzt die Primärfarbe von Ceres ( wenn Ceres grün nutzt werden die Elemente im Blog ebenfalls grün)
CSS und JS des Blogs wird nur noch auf Blogseiten geladen
CSS des Einsteigs (Verlinkung aus dem Shop) wird auf allen Seiten geladen

### REMOVED
Kategorieauswahl für den Einsteigslink zum Blog wurde aus der Plugin-Konfigartion entfernt. Dies wird nun im oben genannten Assistenten eingestellt.

## v0.9.3 (2019-03-06)

- FIX - Fix meta tags

## v0.9.2 (2019-02-22)

- FIX - Verbesserte Bildgestaltung.
- FIX - Beitragbilder sind auf volle Breite beschränkt.
- FIX - Besserer Zeilenabstand wenn Bilder fehlen.
- NEW - Standardbild zu den aktuellsten Beiträgen hinzugefügt, wenn der Beitrag kein Bild enthält.
- NEW - Funktion hinzugefügt, um die aktuellsten Beiträge auszublenden oder anzuzeigen.
- NEw - Funktion hinzugefügt, um anzuzeigen, wie viele  Beiträge in den aktuellsten Beiträgen angezeigt werden.

## v0.9.1 (2019-01-23)

- NEW - Kompatibilität mit Ceres 3
- NEW - Freigabe des Quellcodes
- FIX - Der Zugangspunkt zum Blog im Shop wird nun nicht mehr angezeigt, wenn keine Kategorie im Plugin ausgewählt ist.
## v0.9.0 (2019-01-08)

### Funktionen

- Blogfunktionalität für Ceres Webshops
