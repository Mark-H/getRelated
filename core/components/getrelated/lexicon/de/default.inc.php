<?php

$_lang['getrelated']                              = 'getRelated';
$_lang['getrelated.desc']                         = 'Auflistung themenbezogener Seiten.';
$_lang['getrelated.pagesfound']                   = 'Folgende [[+count]] Seiten k&ouml;nnten Sie enbenfalls interessieren:';
$_lang['getrelated.error.loadingclass']           = 'Fehler beim Laden der Klasse getRelated von [[+path]].';
$_lang['getrelated.error.nofields']               = 'Keine Felder oder Template-Variablen f&uuml;r die Suche gefunden.';
$_lang['getrelated.error.nodistinctivedata']      = 'Fehler beim Sammeln charakteristischer Daten aus der Resource f&uuml;r den Vergleich.';
$_lang['getrelated.error.invalidresource']        = 'Die angegebene Resource ist ung&uuml;ltig.';

/* Stop words are words that will be ignored in the data collected from the resource that would normally be used to match otehr resources with. */
$_lang['getrelated.stopwords']                    = "ab,aber,aehnlich,ähnlich,alle,allein,allem,allen,aller,alles,allg,allgemein,als,also,am,an,and,ander,andere,anderem,anderen,anderer,anderes,anderm,andern,anderr,anders,auch,auf,aus,außer,author,autor,been,bei,beim,bereits,besonders,besser,bevor,bietet,bin,bis,bist,böden,boeden,bzw,ca,da,dabei,dadurch,dafuer,daher,damit,daneben,dann,daran,darauf,daraus,darum,das,dass,daß,dasselbe,davon,davor,dazu,dein,deine,deinem,deinen,deiner,deines,dem,demselben,den,denen,denn,dennoch,denselben,der,derem,deren,derer,derselbe,derselben,des,deshalb,desselben,dessen,dich,die,dies,diese,dieselbe,dieselben,diesem,diesen,dieser,dieses,dinge,dir,doch,dort,du,dunklen,durch,eben,eher,eigenen,eigenes,eigentlich,ein,eine,einem,einen,einer,eines,einfach,einig,einige,einigem,einigen,einiger,einiges,einmal,er,erst,erste,erster,es,etc,etwa,etwas,euch,euer,eure,eurem,euren,eurer,eures,fall,finden,for,für,ganz,ganze,ganzem,ganzen,ganzer,ganzes,gar,geben,gegen,geht,gewesen,ggf,gibt,gleich,gute,guten,hab,habe,haben,hat,hatte,hatten,hattest,hattet,hier,hin,hinter,hinterher,ich,ihm,ihn,ihnen,ihr,ihre,ihrem,ihren,ihrer,ihres,im,immer,in,indem,information,ins,ist,ja,je,jede,jedem,jeden,jeder,jedes,jedoch,jene,jenem,jenen,jener,jenes,jetzt,kann,kannst,kein,keine,keinem,keinen,keiner,keines,koennen,koennt,kommen,kommt,können,könnt,konnte,könnte,langsam,lassen,leicht,leider,lesen,lichten,liest,machen,mag,man,manche,manchem,manchen,mancher,manches,mehr,mehrere,mein,meine,meinem,meinen,meiner,meines,meist,mich,mir,mit,möchte,moechte,moeglich,möglich,muß,müssen,mußt,müßt,musste,müsste,nach,nachdem,nachher,natürlich,ncht,neben,nein,neu,neue,neuem,neuen,neuer,neues,nicht,nichts,noch,nun,nur,nutzung,ob,oder,off,ohne,online,per,schnell,schon,schwierig,sehen,sehr,sehrwohl,seid,sein,seine,seinem,seinen,seiner,seines,seit,seite,seiten,selber,selbst,sich,sie,sieht,sind,so,sodaß,solch,solche,solchem,solchen,solcher,solches,soll,sollen,sollst,sollt,sollte,sollten,solltest,sondern,sonst,soviel,soweit,sowie,sowohl,spielen,statt,steht,suchen,titel,über,um,und,uns,unse,unsem,unsen,unser,unsere,unseren,unseres,unter,version,viel,viele,vieles,vom,von,vor,vorher,wachen,während,wann,war,waren,warst,warum,was,weg,weil,weiter,weitere,welche,welchem,welchen,welcher,welches,wenig,wenige,weniger,wenn,wer,werde,werden,werdet,weshalb,wie,wieder,wieso,wieviel,will,wir,wird,wirklich,wirst,wo,woher,wohin,wohl,wollen,wollte,wurde,würde,wurden,würden,zu,zum,zur,zwar,zwischen";

$_lang['getrelated.prop_desc.resource']           = 'Sowohl die Resource ID als auch die aktuelle Resource f&uuml;r welche themenbezogene Seiten gesucht werden sollen sind leer.';
$_lang['getrelated.prop_desc.fields']             = 'Kommaseparierte Liste bestehend aus Feldname:Gewichtung, welche für den Vergleich verwendet werden sollen. Template-Variablen mit Pr&auml;fix "tv." anf&uuml;hren! Das Feld "content" sollte f&uuml;r den Vergleich nicht herangezogen werden, da dies zu einem gro&szlig;en Performance-Einbruch f&uuml;hren kann. Anwendungsbeispiel: pagetitle:3,tv.MyTags:7,tv.MySubjects:15,introtext:2';
$_lang['getrelated.prop_desc.returnFields']       = 'Resource Felder (verwenden Sie "returnTVs" f&uuml;r Template-Variablen) die in einer eventuellen Ausgabe verwendet werden.';
$_lang['getrelated.prop_desc.returnTVs']          = 'Namen der Template-Variablen (durch Komma getrennt), die im Ergebnis enthalten sein sollen. Nicht mit Pr&auml;fix "tv." versehen!';
$_lang['getrelated.prop_desc.parents']            = 'Kommaseparierte Liste der IDs von Eltern-Elementen, in welchen themenbezogene Seiten gesucht werden sollen.';
$_lang['getrelated.prop_desc.exclude']            = 'Kommaseparierte Liste der IDs von Resourcen, die vom Ergebnis ausgeschlossen werden sollen.';
$_lang['getrelated.prop_desc.parentsDepth']       = 'Tiefe der Verschachtelung nach der Eltern-Elemente durchsucht werden.';
$_lang['getrelated.prop_desc.contexts']           = 'Kommaseparierte Liste von Context-Namen die durchsucht werden.';
$_lang['getrelated.prop_desc.includeUnpublished'] = 'Verwendung nicht ver&ouml;ffentlichter Resoucen im Ergebnis.';
$_lang['getrelated.prop_desc.includeHidden']      = 'Verwendung versteckter Resourcen ("Nicht in Men&uuml;s anzeigen") im Ergebnis.';
$_lang['getrelated.prop_desc.limit']              = 'Maximale Anzahl der Ergebnisse.';
$_lang['getrelated.prop_desc.fieldSample']        = 'Anzahl der Resoucen, die bei einem Vergleich basierend auf Resource-Feldern herangezogen werden sollen. Eine hohe Zahl kann zu einem gro&szlig;en Performance-Einbruch f&uuml;ren. Sollten die Ladezeiten steigen, versuchen Sie eine niedrigere Zahl.';
$_lang['getrelated.prop_desc.fieldSort']          = 'Resource Feld nach dem sortiert werden soll. Wird in Verbindung mit der "fieldSample" Eigenschaft verwendet.';
$_lang['getrelated.prop_desc.fieldSortDir']       = 'Sortierrichtung f&uuml;r die "fieldSort" Eigenschaft.';
$_lang['getrelated.prop_desc.tvSample']           = 'Anzahl der Template-Variablen Ergebnisse, die bei Vergleich mit Template-Variablen Werten eingebunden werden sollen (Anmerkung: eine Resource kann - abh&auml;ngig von der Feld-Eigenschaft - mehrere Ergebnisse liefern).';
$_lang['getrelated.prop_desc.tvSort']             = 'Resource-Feld nach dem in einer TV Abfrage sortiert werden soll. Wird in Verbindung mit der "tvSample" Eigenschaft verwendet.';
$_lang['getrelated.prop_desc.tvSortDir']          = 'Sortierrichtung f&uuml;r die "tvSort" Eigenschaft.';
$_lang['getrelated.prop_desc.tplOuter']           = 'Name des Chunks für das &auml;u&szlig;ere Template (Standard in core/components/getrelated/elements/snippets/chunks/).';
$_lang['getrelated.prop_desc.tplRow']             = 'Name des Chunks für eine Template Zeile (Standard in core/components/getrelated/elements/snippets/chunks/.';
$_lang['getrelated.prop_desc.noResults']          = 'Text der ausgegeben wird falls keine themenbezogenen Dokumente gefunden wurden.';
$_lang['getrelated.prop_desc.toPlaceholder']      = 'Name des Platzhalters - wenn keine direkter Ausgabe erfolgen soll.';
$_lang['getrelated.prop_desc.rowSeparator']       = 'String der als Trenner zwischen Zeilen ausgegeben werden soll.';
$_lang['getrelated.prop_desc.defaultWeight']      = 'Gewichtung, die Feldern zugeordnet werden soll, falls keine spezifische Gewichtung eingestellt ist.';
$_lang['getrelated.prop_desc.debug']              = 'Aktivierung/Deaktivierung des Debug Modus. Bei Aktivierung werden sehr viele zusätzliche Informationen am Bildschirm ausgegeben.';

?>
