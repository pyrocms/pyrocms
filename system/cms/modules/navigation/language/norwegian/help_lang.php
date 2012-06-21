<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Oversikt</h4>
<p>Navigasjons-modulen styrer hovednavigasjon område samt andre lenken grupper.</p>

<h4>Navigasjonsgrupper</h4>
<p>Navigasjon linker vises i henhold til gruppen at de er i. I de fleste temaer er øverste felt på siden navigasjonen.
Sjekk temaets dokumentasjon for å finne ut hvilke navigasjonsgrupper som støttes.
Hvis du vil vise en gruppe på nettstedet, bruuke følgende tag: {{ navigation:links group=\"ditt-gruppe-navn\" }}</p>

<h4>Å legge til lenker</h4>
<p>Velg en tittel for linken din, velg gruppen du ønsker at den skal vise i.
lenke typer er som følger:
<ul>
<li>URL: en ekstern lenke - http://google.no</li>
<li>Nettsted Lenke: en link på ditt nettsted - galleries/portfolio-pictures</li>
<li>Modul: leder til indeksiden av en modul</li>
<li>Side: lenke til en side</li>
</ul>
Mål spesifiserer om linken skal åpnes i et nytt nettleservindu eller kategorien.
(Tips: Bruk Nytt vindu sparsomt for å unngå irritasjon)
Klasse-feltet kan du legge til en CSS klasse til en enkelt lenke.</p>
<p></p>

<h4>Sortering av Navigasjonslenker</h4>
<p>Rekkefølgen av koblingene i admin panelet gjenspeiles på nettstedet.
Hvis du vil endre rekkefølgen de vises, dra og slippe dem til de er i den rekkefølgen du ønsker.</p>";