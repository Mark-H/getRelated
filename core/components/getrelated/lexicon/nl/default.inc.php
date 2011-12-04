<?php

$_lang['getrelated'] = 'getRelated';
$_lang['getrelated.desc'] = 'Genereert een lijst met gerelateerde documenten.';
$_lang['getrelated.pagesfound'] = 'Deze [[+count]] pagina\'s vind je misschien ook wel interessant:';
$_lang['getrelated.error.loadingclass'] = 'Laden van getRelated class in [[+path]] is mislukt.';
$_lang['getrelated.error.nofields'] = 'Geen velden of template variabele gespecificeerd om te doorzoeken.';
$_lang['getrelated.error.nodistinctivedata'] = 'Geen data gevonden om gerelateerde documenten mee te vergelijken.';
$_lang['getrelated.error.invalidresource'] = 'Het gespecificeerde of huidige document is ongeldig.';

$_lang['getrelated.stopwords'] = "aan,afd,dat,de,den,der,des,deze,die,dit,dl,door,dr,ed,een,enige,enkele,enz,etc,haar,het,hierin,hoe,hun,ik,inzake,is,je,na,naar,no,nu,om,onder,ons,onze,ook,op,over,prof,publ,sl,st,te,tegen,ten,ter,tot,uit,uitg,vakgr,vanaf,vert,vol,voor,wat,wie,zijn";

$_lang['getrelated.prop_desc.resource'] = 'Een resource ID om als basis te gebruiken voor de vergelijking, of "current" of leeg om voor het huidige document te zoeken.';
$_lang['getrelated.prop_desc.fields'] = 'Komma gescheiden lijst van velden om te gebruiken in de verlijking, syntax is veldnaam:gewicht. TVs kan je gebruiken door deze vooraf te laten gaan met "tv.". Gebruik niet het inhoudsveld tenzij je je performance niet belangrijk vind. Voorbeeld: pagetitle:3,tv.MyTags:7,tv.MySubjects:15,introtext:2';
$_lang['getrelated.prop_desc.returnFields'] = 'Document Velden (gebruik returnTVs voor template variabelen) welke je kan gebruiken in de output chunks.';
$_lang['getrelated.prop_desc.returnTVs'] = 'Komma gescheiden lijst van template variabelen namen om in de resultaten te gebruiken. Geen "tv." voor zetten.';
$_lang['getrelated.prop_desc.parents'] = 'Komma gescheiden lijst van bovenliggende documenten om in te zoeken.';
$_lang['getrelated.prop_desc.exclude'] = 'Komma gescheiden lijst van document IDs die je buiten de resultaten wilt houden.';
$_lang['getrelated.prop_desc.parentsDepth'] = 'De diepte om bovenliggende documenten te zoeken.';
$_lang['getrelated.prop_desc.contexts'] = 'Komma gescheiden lijst van contexts on in te zoeken.';
$_lang['getrelated.prop_desc.includeUnpublished'] = 'Gebruik ook niet gepubliceerde documenten in de resultaten?';
$_lang['getrelated.prop_desc.includeHidden'] = 'Gebruik ook documenten aangemerkt als "verborgen in menu" in de resultaten?';
$_lang['getrelated.prop_desc.limit'] = 'Aantal resultaten om weer te geven. ';
$_lang['getrelated.prop_desc.fieldSample'] = 'Aantel resources om te gebruiken in het vergelijken op basis van resource velden. Kan een grote impact hebben op je performance, dus stel deze lager in als het processen te lang duurt.';
$_lang['getrelated.prop_desc.fieldSort'] = 'Document veld om op te sorteren, gebruikt met de fieldSample optie.';
$_lang['getrelated.prop_desc.fieldSortDir'] = 'Sorteer volgorde van de fieldSort optie.';
$_lang['getrelated.prop_desc.tvSample'] = 'Aantel TV resultaten om te gebruiken in het vergelijken op basis van resource velden. Let op dat 1 resource meerdere TV resultaten kan hebben. Kan een grote impact hebben op je performance, dus stel deze lager in als het processen te lang duurt.';
$_lang['getrelated.prop_desc.tvSort'] = 'Document veld om op te sorteren, gebruikt met de tvSample optie.';
$_lang['getrelated.prop_desc.tvSortDir'] = 'Sorteer volgorde van de tvSort optie.';
$_lang['getrelated.prop_desc.tplOuter'] = 'Chunk naam om te gebruiken als wrapper template. Zie standaard in core/components/getrelated/elements/snippets/chunks/.';
$_lang['getrelated.prop_desc.tplRow'] = 'Chunk naam om te gebruiken als row template. Zie standaard in core/components/getrelated/elements/snippets/chunks/.';
$_lang['getrelated.prop_desc.noResults'] = 'Text of output wanneer er niks relevants is gevonden.';
$_lang['getrelated.prop_desc.toPlaceholder'] = 'Als je de output in a placeholder wilt in plaats van direct bij de snippet definieer je de placeholder naam hier.';
$_lang['getrelated.prop_desc.rowSeparator'] = 'String om te gebruiken tussen rows.';
$_lang['getrelated.prop_desc.defaultWeight'] = 'Standaard gewicht voor velden waaraan geen gewicht is toegekend.';
$_lang['getrelated.prop_desc.debug'] = 'Zet debug mode aan of uit. Wanneer deze aan staat zal er veel informatie op het scherm getoond worden.';

?>
