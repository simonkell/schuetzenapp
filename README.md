# SchützenApp

Dieses Projekt ist im Rahmen des Studiengangs Wirtschaftsinformatik an der Hochschule für Oekonomie & Management (FOM) entstanden. Nutznießer ist der Schützenzug Nüss Globetrotters 2014, seines Zeichens Teil des Neusser Grenadierkorps von 1823. Der Entwickler der Applikation ist Feldwebel seines Zuges, daher entstand die Idee einer App um die Verwaltung der Strafen in eine digitale Form zu bringen (auch wenn der allseits beliebte Knipser dafür wegfällt...).

Vorschau auf das Projekt: https://kell.nrw/schuetzenapp/

### Was kann die App bisher?
- Login für Zugmitglieder
- Übersicht über eigene Strafen
- Zugbefehl / Programm darstellen
- Adminbereich für Feldwebel
- Neuanlage von Strafen und Usern
- Zugsau ermitteln / Überblick der zu zahlenden Strafen anzeigen

### Roadmap für weitere Funktionen
- Userverwaltung ausbauen (User bearbeiten, neue Passwörter setzen, ...)
- Passwörter bei Neuanlage per Mail versenden
- Strafenverwaltung auch für bereits angelegte Strafen
- Verwaltung der eingenommenen Getränkeumlagen
- Push Notifications bei ausgesprochenen Strafen
- GPS-Ortung der Zugmitglieder in den oftmals unübersichtlichen Schützenfesttagen

### Ihr möchtet die App ebenfalls nutzen?
Das ist ganz einfach möglich! Dazu benötigt ihr lediglich ein einfaches Webhosting mit Domain, SSL-Zertifikat, einer MySQL-Datenbank und 100MB Webspeicher. Unterstützt werden muss weiterhin die Ausführung von PHP auf dem entsprechenden Server. Klassische Anbieter für solche Hostings sind Strato, HostEurope oder 1&1 IONOS (und noch viele viele weitere...)

#### Habt ihr das Webhosting gebucht, sind folgende Schritte zur Einrichtung notwendig:
1. Die FAQs eures gewählten Hosters zur Einrichtung aufmerksam lesen!
2. Anlage der Datenbank und Konfiguration (in phpMyAdmin muss die beiliegende Init.sql ausgeführt werden
3. Anpassung der beiligenden config.php auf die Zugangsdaten der neu angelegten Datenbank

> define('DB_NAME', 'Hier Datenbank-Name eintragen');
> 
> define('DB_USER', 'Hier Datenbank-Benutzername eintragen');
> 
> define('DB_PASSWORD', 'Hier Benutzernamen-Passwort eintragen');
> 
> define('DB_HOST', 'Hier Datenbank-Host eintragen');
> 
> define('DSN', 'mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; charset=utf8');

4. Alle Dateien aus dem Paket auf den Webserver übertragen
5. Domain einrichten und SSL-Zertifikat aktivieren
6. Auf Domain surfen und einloggen!
> Benutzername: Administrator
> 
> E-Mail: test@test.xyz
> 
> Passwort: AdminPW

#### Anleitung zur Nutzung
Die Applikation sollte für Nutzer grundsätzlich selbsterklärend sein. Wo immer möglich wurden Tooltipps verwendet, um die auszufüllenden Felder sprechend zu machen. 
Beim Login ist die Mailadresse sowie das Passwort zu verwenden. Nach erfolgtem Login wird man automatisch auf die persönliche Übersicht weitergeleitet. Hier ist zum einen ein Überblick über die eigenen Strafen (inkl. Begründung) möglich und zum anderen können zentrale Userverwaltungsoptionen wie Passwortwechsel und Logout durchgeführt werden. Im unteren Bereich kann Einblick in den Zugbefehl / Programm an den verschiedenen Schützenfesttagen genommen werden.
Chargierte (Administratoren) sehen in der persönlichen Übersicht zusätzlich einen Link, über den sie in den Administrationsbereich kommen. Dort besteht die Möglichkeit, einzelne Strafen auszusprechen. Hier können über Buttons entweder vorbelegte Strafen ausgewählt oder individuelle Strafen mit Begründung eingetragen werden. Weiterhin kann eine nach Höhe der Strafen sortierte Liste der Zugmitglieder eingeblendet werden - so kann auf einen Blick die aktuelle Zugsau ermittelt sowie zum Ende des Schützenfest der einzusammelnde Betrag angezeigt werden. Letztlich besteht die Möglichkeit, neue User anzulegen.

### Zum Schluss ein Dank
Ohne das Bootstrap-Framework wäre das UI dieser Software niemals so hübsch und funktionabel geworden. DANKE an das Team und alle Contributors, die dieses Stück Software täglich noch besser machen. https://getbootstrap.com/
