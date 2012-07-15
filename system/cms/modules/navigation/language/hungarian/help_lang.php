<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Leírás</h4>
<p>A Navigáció modul vezérli a fő navigációs részt, ugyanúgy mint más link csoportokat.</p>


<h4>Navigációs csoportok</h4>
<p>A navigációs linkek a csoportjuk szerint lesznek megjelenítve. A legtöbb oldalstílusban a \"Header\" a fő navigációs csoport.
 Nézd meg az oldalstílusod dokumentációját hogy megtudd melyik navigációs csoportok támogatottak a stílus fájljaiban.
Ha meg akarsz jeleníteni egy csoportot egy oldal tartalmában, használd a következő tag-et: {{ navigation:links group=\"linkcsoportod-neve\" }}</p>

<h4>Linkek hozzáadása</h4>
<p>Válassz egy címet a linkednek, azután válaszd ki a csoportot amelyikben meg szeretnéd jeleníteni.
A link típusok a következők:
<ul>
<li>URL: egy külső link - http://google.com</li>
<li>Oldal Link: egy link az oldalon belül - galeria/portfolio-kepek</li>
<li>Modul: a látogatót a modul index oldalára viszi</li>
<li>Oldal: link egy oldalra</li>
</ul>
A cél megadja hogy a link új ablabkan vagy böngészőlapon nyíljon meg.
(Tipp: használd az új oldalakat mérséklettel, hogy elkerüld a látogatók bosszantását.)
Az Osztály mezővel egy CSS osztályt adhatsz egyetlen hivatkozáshoz.</p>

<p></p>

<h4>Navigációs linkek elrendezése</h4>
<p>A linkjeid sorrendje az admin panelen ugyanolyan mint a weboldal front-endjén.
A sorrend változtatásához egyszerűen fogd és húzd őket míg nincsenek olyan sorrendben ahogyan szeretnéd.</p>";

/* End of file help_lang.php */