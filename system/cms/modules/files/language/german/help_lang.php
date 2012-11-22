<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h6>Übersicht</h6><hr>
<p>Das Dateien-Modul ermöglicht es dem Site-Administrator die Dateien der Website auf eine einfache und flexible Art zu verwalten.
Alle Bilder oder Dateien, die in eine Seite, Galerie oder einen Blog-Artikel eingefügt werden können, werden hier gespeichert.
Bilder für Seiten können hier hochgeladen und dann im WYSIWYG-Editor eingefügt werden. Sie können Bilder aber auch direkt im WYSIWYG-Editor hochladen.</p>
<p>Die Oberfläche funktioniert ähnlich wie ein vom Desktop gewohntes Dateisystem: mit einem Rechtsklick auf einen Ordner oder eine Datei wird ein Kontext-Menü angezeigt. Alles im mittleren Bereich kann angeklickt werden.</p>

<h6>Ordner verwalten</h6>
<p>Nachdem Sie einen Ordner auf der obersten Ebene angelegt haben, können Sie beliebig viele Unterordner anlegen. Zum Beispiel \"blog/images/screenshots/\" oder \"pages/audio/\".
Die Ordnernamen dienen nur zur Verwaltung und werden nicht in den Download-Links im Frontend angezeigt.
Mit einem Rechtsklick auf einen Ordner öffnet sich ein Kontextmenü, während sich bei einem Doppelklick der Ordner selber öffnet.
Sie können aber auch auf einen Ordner in der linken Spalte klicken um ihn zu öffnen.</p>
<p>Falls Cloud Anbieter aktiviert wurden, können Sie den Speicher eines Ordner im Menü \"Details\" im Kontextmenü des Ordners konfigurieren.
Sie können dort einen Speicher bestimmen (zum Beispiel \"Amazon S3\") und den Namen des Buckets oder Containers angeben. Falls der Bucket oder Container nicht exisitert, wird er bei einem Klick auf \"Speichern\" angelegt.
Bitte beachten Sie, dass nur der Speicher eines leeren Ordner geändert werden kann.</p>

<h6>Dateien verwalten</h6>
<p>Um Dateien zu verwalten, öffnen Sie den gwünschten Ordner im Verzeichnis-Baum in der linken Spalte oder mit einem Doppelklick im mittlere Bereich.
Sobald die Dateien angezeigt werden, können Sie diese mit einem Rechtsklick über das Kontextmenü bearbeiten. Sie können Dateien auch anordnen, indem Sie die Datei an die gewüschte Position ziehen.
Beachten Sie, dass Ordner innerhalb eines Ordners immer zuerst angezeigt werden. Dateien werden nach den Ordnern aufgelistet.</p>

<h6>Dateien hochladen</h6>
<p>Nach einem Klick auf \"Upload\" im Kontextmenü des Ordners erscheint das Fenster für den Datei-Upload.
Dateien die Sie hochladen möchten können entweder auf das Feld gezogen und abgelegt oder durch einen Klick auf das Feld im Standard Dateiauswahl-Fenster ausgewählt werden.
Sie können mehrere Dateien hinzufügen, indem Sie die gewünschten Dateien bei gedrückter Control/Command oder Shift-Taste anklicken. Die gewählten Dateien werden anschliessend in einer Liste im unteren Bereich des Fensters angezeigt.
Sie können dann versehentlich gewählte Dateien aus der Liste entfernen. Sobald Sie mit Ihrer Auswahl zufrieden sind, können Sie den Upload-Prozess durch einen Klick auf Upload-Button starten.</p>
<p>Falls eine Warnung bezüglich der Dateigrösse erscheint, kann es daran liegen dass Ihr Hosting-Anbieter Uploads über 2 MB nicht erlaubt.
Die meisten modernen Kameras produzieren Bilder die oft grösser sind als 5 MB. Es kann also sehr gut möglich sein, dass Sie auf dieses Problem stossen.
Um diese Limite anzupassen, melden Sie sicht beim Support Ihres Hosting-Anbieters. Alternativ können Sie die Bilder vor dem Upload verkleinern.
Die Anpassung der Bildgrösse hat ausserdem den Vorteil, dass der Upload-Prozess weniger lange dauert. Sie können die Upload-Limite ausserdem im Control Panel unter Einstellungen -> Dateien anpassen.
Diese Einstellung ändert allerdings nichts an der Limite des Hosting-Anbieters. Wenn Ihr Hoster aber beispielsweise Uploads von 50 MB erlaubt, können Sie hier eine Limite von 20 MB einstellen.</p>

<h6>Dateien synchronisieren</h6>
<p>Falls Sie Ihre Dateien bei einem Cloud-Anbieter gespeichert haben, sollten Sie die Synchronisations-Funktion benutzen, um die Datenbank aktuell zu halten. Diese Version gleich die Dateien auf Ihrem Cloud-Speicher mit der File Tabelle der Datenbank ab.
Falls Sie bespielsweise einen anderen Service nutzen, der Bilder oder Dateien in den Cloud-Speicher ablegt, können Sie einfach den Ordner der mit dem Bucket oder Container verbunden ist mit der rechten Maustaste anklicken und \"Synchronisieren\" wählen.
Dadurch werden alle verfügbaren Datei-Informationen vom Cloud-Anbieter geholt und in die Datenbank gespeichert. Die Dateien können nun wie gewohnt in Seiten, Gallerien, Blog-Artikeln usw. eingefügt werden.
Falls Dateien seit der letzten Synchronisation von Ihre Cloud-Speicher gelöscht wurden, werden diese Dateien auch in der Datenbank gelöscht.</p>

<h6>Suche</h6>
<p>Sie können eine Suche über alle Ihre Dateien oder Ordner starten, in dem Sie einen Begriff in das Suchfeld in der rechten Spalte eingeben und Enter drücken. Danach werden die ersten 5 zutreffenden Dateien sowie die ersten 5 zutreffenden Ordner angezeigt.
Wenn Sie auf einen Treffer klicken, wird der Ordner, in dem sich die Datei befindet, angezeigt und die gesuchte Datei markiert. In der Suche kann nach Ordnernanmen, Dateinanem, Dateiendungen, Speicher und Cloud Container- bzw. Bucket-Namen gesucht werden.</p>";