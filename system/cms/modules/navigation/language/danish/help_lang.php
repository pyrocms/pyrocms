<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Overblik</h4>
<p>Navigationsmodulet kontrollerer dit hovednavigationsområde såvel som andre link grupper.
<h4>Navigationsgrupper</h4>
<p>Navigation links er vist i forhold til gruppen de er i. I de fleste teamer er Header gruppen site-navigationen.
Tjek dit temas dokumentation for at finde ud af hvilke navigationsgrupper der er understøttet i temaet.
Hvis du vil vise en gruppe i skal du blot bruge dette tag: {{ navigation:links group=\"dit-gruppe-navn\" }}</p>

<h4>Tilføjelse af links</h4>
<p>Vælg en titel til dit link, og vælg derefter en gruppe som du ønsker at det skal vises i.
Der er følgende linktyper:
<ul>
<li>URL: et eksternt link - http://google.com</li>
<li>Site Link: et link inden for dit site - galleries/portfolio-pictures</li>
<li>Module: tager den besøgende til index siden for et modul</li>
<li>Page: link til en side</li>
</ul>
Target/Mål specificerer om dette link skal åbnes i et nyt browservindue eller tab.
(Tip: brug Nyt Vindue med omtanke for at undgå at irritere dine brugere)
Class/Klasse feltet tillader at du kan tilføje en css klasse til et enkelt link.</p>
<p></p>

<h4>Ordning af navigationslinks</h4>
<p>Rækkefølgen af dine links på hjemmeside er afspejlet i administrationspanel.
For at ændre rækkefølgen skal du blot trække (drag-and-drop) dem rundt indtil de fremstår i den orden du vil have.</p>";