# Release notes für das Blog plugin

## v1.1.9 (2020-02-27)

- Funktionalität des Debug-Assistenten erweitert.

## v1.1.8 (2020-02-27)

- Funktionalität des Debug-Assistenten erweitert.

## v1.1.7 (2020-01-15)

- Funktionalität des Debug-Assistenten erweitert.

## v1.1.6 (2020-01-10)

- Funktionalität des Debug-Assistenten erweitert.

## v1.1.5 (2019-11-1)

- Funktionalität des Debug-Assistenten erweitert.

## v1.1.4 (2019-10-31)

- NEW - Debug Assistenten um übliche Probleme in den Blog Beiträgen zu beheben.
- FIX - Layout der Such-Seite

## v1.1.3 (2019-08-20)

- FIX - Knopf:Mehr anzeigen,  auf der Standardansicht der Kategorieliste hinzugefügt

## v1.1.2 (2019-07-30)

### Feature
- Welche Kategorien in der Header-Navigation angezeigt werden sollen, kann nun gewählt werden
    + Nur Blog-Kategorien (default)
    + Kategorien wie im Rest des Shops

### FIX
- "Categories" in der Seitenleiste ist nun in "Kategorien" übersetzt
- Kategorien in der Seitenleiste nutzen nun das korrekte Sprach-URL-Präfix
- Die Benutzung der Suche in einer anderen Sprache als die aktuelle Shop-Einstellung wird nicht länger die Sprache zurücksetzen

## v1.1.1 (2019-07-25)

### Assistent
- Im Landingpage Assistenten erstellte multilinguale Texte können nicht länger im Menü Mehrsprächigkeit bearbeitet werden

### FIX: Layout
- Clear floats werden fur Beitragsseiten eingesetzt 

### CHANGE: Layout
- 300px Höhenlimitierung für Titelbilder auf Beitragsseiten wurde entfernt. Warnung: Da die Höhe kein mehr Limit hat, können hohe Bilder die den Headerbereich stark in die Länge ziehen. Wir empfehlen, stattdessen breitere Bilder zu verwenden

## v1.1.0 (2019-07-17)

### NEW: Layouts
Verschiedene Layout-Optionen für Beitragsseiten, Kategorieseiten und die Blog-Landingpage wurden hinzugefügt. Mehr Details findest du im Plugin-Guide.

### NEW in Frontend UI
- Ähnliche Beiträge unterhalb von Blogbeiträgen wurden hinzugefügt. Ähnliche Beiträge stammen aus der selben Kategorie wie der angezeigte Beitrag.
- Kategoriebaum wurde der Seitenleiste hinzugefügt

## NEW in Backend
- Ein neuer Editor wurde hinzugefügt.

### CHANGES in UI
- Die Seitenleiste wurde verschmälert. Der Hauptcontent der Seite fällt so mehr ins Gewicht und rückt mehr in den Fokus.
- Der Titel von "Neuesten Beiträgen" in der Seitenleiste wird nicht länger abgeschnitten. 

### CHANGE/FIX Open Graph Metadaten sind nun Properties

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
