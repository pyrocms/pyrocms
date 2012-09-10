<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Áttekintés</h4>
<p>A Bővítmények modul lehetővé teszi az adminisztátoroknak harmadik féltől származó modulok feltöltését, telepítését és eltávolítását.</p>

<h4>Feltöltés</h4>
<p>Az új modulnak egy zip fájlban kell lennie és a könyvtár neve ugyanaz kell hogy legyen mint magának a modulnak.
Például ha a 'forums' modult töltöd fel, a könyvtárnak 'forums' neve kell hogy legyen nem pedig 'test_forums'.</p>

<h4>Modul kikapcsolása, eltávolítása vagy törlése</h4>
<p>Ha el akarsz távolítani egy modult a front end-ről és az admin menükből, egyszerűen kikapcsolhatod.
Ha az adatokat akarod törölni, de a modult később lehet hogy újratelepíted, eltávolíthatod.
<span style=\"color: red;\">Megjegyzés: ez a művelet eltávolítja az összes adatbázis bejegyzést.</span>
Ha végeztél az összes adattal és a forrásfájlokkal is, törölheted.
<span style=\"color:red;\">Ez eltávolítja az összes forrásfájlt, feltöltött fájlokat és adatbátis bejegyzéseket amik a modulhoz tartoznak.</span></p>";

/* End of file help_lang.php */