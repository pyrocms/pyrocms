<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = '
<h4>Áttekintés</h4>
<p>Az Oldalak modul egyszerű, de hatékony módja a statikus tartalmak kezelésének a weboldalon.
Oldaltervek kezelhetőek és widgetek beszúrhatóak a témafájlok szerkesztése nélkül.</p>

<h4>Oldalak kezelése</h4><hr>
<h6>Oldal tartalma</h6>
<p>Amikor megválasztod az oldal címét, ne felejtsd el hogy az alapértelmezett oldalterv megjeleníti azt az oldal tartalma felett.
Hozd létre az oldalatad a WYSIWYG szerkesztő használatával.
 Ha kész vagy hogy megmutasd az oldalt a látogatóknak, állítsd be a státuszát "Élő"-re és a megjelenő URL-en keresztül elérhetővé válik.
<strong>A Design > Navigáció oldalon létre kell hoznod egy új navigációs linket ha meg akarod jeleníteni az oldal menüjében.</strong></p>


<h6>Meta adatok</h6>
<p>A meta cím általában keresési eredmények címében használatos, és úgy hisszük nagy súllyal szerepel az oldal page rankjében.<br />
A meta kulcsszavak olyan szavak amik leírják az oldalad tartalmát és csak a keresőmotorok (pl. Google) segítségére vannak. <br>
A meta leírás egy rövid leírás az oldalról és a keresőmotor felhasználhatja keresőkifejezésként ha a kereséshez kapcsolódónak találja.</p>

<h6>Design</h6>
<p>A Design lap lehetővé teszi hogy kiválassz egy egyedi oldaltervet és opcionálisan különböző CSS stílusokat használj csak az adott oldalra.
Lásd az Oldaltervek részt további utasításokhoz az oldaltervek legjobb használatához.</p>

<h6>Szkript</h6>
<p>Olyan javascriptet írhatsz ide, amit az oldal &lt;head&gt; részében szeretnél megjeleníteni.</p>

<h6>Beállítások</h6>
<p>Engedélyezheted a hozzászólásokat és RSS feedet az adott oldalhoz. Akár korlátozhatsz oldalakat meghatározott
bejelentkezett felhasználói csoportok számára a Hozzáférések mező beállításával. Ha egy RSS feed engedélyezve van, a látogatók fel tudnak iratkozni
az oldalra és mindegyik aloldal frissítéseit megkapják az RSS olvasójukban.</p>
<p>A "Pontos URI egyezés szükséges" mező egy okos kis eszköz ami lehetővé teszi paraméterek megadását az URL-ben.
A PyroCMS alapértelmezetten a "hightech-kutytuk" oldalt keresi ami a "termekek" aloldala mikor meglátogatod
 a '. site_url('termekek/hightech-kutyuk'). ' címet. A checkbox bejelölésével a Termékek oldalon azt mondod a PyroCMS-nek hogy rendben van ha nem talál
 Hightech Kütyük nevű oldalt. Így csak a Termékek oldalt tölti be és a "higtech-kutyuk" csak egy paraméter lesz.
 Ez egyszerűvé teszi paraméterek átadását beágyazott tagekben. A példa azt szemlélteti hogyan használhatod a Streams add-ont a "hightech-kutyuk" nevű stream
 megjelenítésére a Termékek oldalon:
<pre><code>{{ streams:cycle stream={url:segments segment=&quot;2&quot;} }}
    {{ entries }}
        {{ company_intro }}
        {{ owner_name }}
        {{ owner_phone }}
    {{ /entries }}
{{ /streams:cycle }}</code></pre></p>
</p>

<h4>Oldaltervek</h4><hr>
<p>Az oldaltervek lehetővé teszik hogy beállíthasd az oldal szerkezetét a témafájlok szerkesztése nélkül.
 Beágyazhatsz tag-eket az oldaltervekbe ahelyett hogy minden oldalra elhelyeznéd őket.
Például ha van egy twitter feed widget-ed amit minden oldal alján meg akarsz jeleníteni, csak beilleszted a widget tag-et az oldaltervbe:
<pre><code>
{{ page:title }}
{{ page:body }}

&lt;div class=&quot;my-twitter-widget&quot;&gt;
	{{ widgets:instance id=&quot;1&quot; }}
&lt;/div&gt;
</code></pre>
Most már alkalmazhatsz CSS formázást a "my-twitter-widget" osztályra a CSS lapon.</p>';

/* End of file help_lang.php */
