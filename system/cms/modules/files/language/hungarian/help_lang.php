<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = '
<h6>Áttekintés</h6><hr>
<p>A Fájlok modul egy kitűnő mód az oldal adminisztátorának az oldalon használt fájlok kezelésére.
Minden kép vagy fájl, ami oldalakba, galériákba, vagy blogbejegyzésekbe van illesztve, itt lesz tárolva.
Az oldalak tartalmához tartozó képeket feltöltheted közvetlenül a WYSIWYG szerkesztőből, vagy akár feltöltheted őket innen, és beillesztheted őket a szerkesztőből.</p>
<p>A Fájlok felülete ugyanúgy működik mint egy helyi fájlrendszer: jobb klikkel megjeleníthetsz egy helyi menüt. A középső panelen minden kattintható.</p>

<h6>Mappák kezelése</h6>
<p>Miután létrehoztad a legfelső mappát vagy mappákat, annyi almappát kreálhatsz, amennyire csak szükséged van, mint pl. blog/kepek/screenshotok vagy oldalak/audio/.
A mappanevek csak saját használatodra vannak, a nevek nem jelennek meg a letöltési linkekben vagy az oldal front end-jén.
Mappák kezeléséhez vagy jobb gombbal kattints rájuk és válassz ki egy menüpontot, vagy duplakattintással nyisd meg őket.
A bal oldali oszlopból is megnyithatod a mappákat ha rájuk kattintasz.</p>
<p>Ha "cloud" szolgáltatók engedélyezve vannak, be tudod állítani a mappa helyét ha jobb gombbal rákattintasz és a Részletek menüpontot választod.
Ezután kiválaszthatod a helyet (például "Amazon S3") és megadhatod a távoli bucket vagy container nevét. Ha a "bucket" vagy "container" nem létezik,
létre lesz hozva amikor a Mentésre kattintasz. Megjegyzés: csak üres mappa helyét tudod megváltoztatni.</p>

<h6>Fájlok kezelése</h6>
<p>Fájlok kezeléséhez navigálj a tartalmazó mappához a bal oldali oszlopban lévő fa használatával, vagy a középső oszlopban lévő mappaneveken történő duplakattintással.
Ha látod a fájlokat, jobb klikkel szerkesztheted őket. El is rendezheted őket ha a megfelelő pozicóba húzod őket. Megjegyzés:
ha fájlok és mappák is vannak ugyanabban a szülő mappában, a mappák mindig elsőként lesznek megjelenítve, ezután következnek a fájlok.</p>

<h6>Fájlok feltöltése</h6>
<p>Miután jobb gombbal rákattintottál a kívánt mappa Feltöltés menüjére, egy feltöltési ablak fog megjelenni.
Hozzáadhatsz fájlokat úgy hogy ráhúzod őket a Fájlfeltöltő dobozra, vagy úgy hogy a dobozba kattintasz és kiválasztod a fájlokat a szokásos fájl ablakból.
Több fájlt is kijelölhetsz a CTRL (Mac-en Cmd) vagy Shift billentyű nyomva tartásával, miközben a fájlokra kattintasz. A kiválaszottt fájlok meg fognak jelenni egy listában a képernyő alján.
Törölheted a nemkívánatos fájlokat a listából, vagy a Feltöltés gombra kattinthatsz a feltöltés megkezdéséhez.</p>
<p>Ha kapsz egy figyelmeztetést arról hogy a fájl mérete túl nagy, vedd figyelembe hogy a legtöbb szolgáltató nem enged 2MB-nál nagyobb fájlfeltöltéseket.
Sok modern fényképezőgép 5MB-nál is nagyobb fájlokat generálhat, így gyakran bele lehet futni ebbe a problémába.
Hogy orvosold ezt a korlátozást, megkérrheted a szolgáltatódat hogy növelje meg a fájlfeltöltésre vonatkozó korlátot, vagy átméretezheted a képeket feltöltés előtt.
Az átméretezésnek megvan az az előnye is, hogy a feltöltés gyorsabban végbemegy. Megváltoztathatod a feltöltés korlátját a
Vezérlőpult > Beállítások > Fájlok menüpont alatt is, de ez másodlagos a szolgáltató korlátozásával szemben. Például ha a szolgáltatód 50MB-os fájlfeltöltést enged,
még mindig limitálhatod a feltöltés méretét 20-ra.

<h6>Fájlok szinkronizálása</h6>
<p>Ha tárolsz fájlokat "cloud" szolgáltatónál használhatod a Szinkronizálás funkciót. Ez lehetővé teszi hogy "frissítsd"
a fájlokat tartalmazó adatbázist, hogy a távoli tárhellyel naprakészen tartsd őket. Például ha van egy másik szolgáltatásod
ami fájlokat küld az Amazon tárhelyedre amit meg akarsz jeleníteni a heti blogbejegyzésedben, egyszerűen rámész a mappára ami
ahhoz a bucket-hez van rendelve, és a Szinkronizálásra kattintasz. Ez le fogja szedni az összes elérhető információt az Amazonról és
 eltárolja az adatbázisban, mintha a file csak a Fájlok modul felületéről lett volna feltöltve. A fájlok most már beszúrhatóak oldalak tartalmába,
 blogbejegyzésekbe, stb. Ha a fájlok törölve lettek a távoli bucket-ről az utolsó szinkronizálás óta, az adatbázisból is törlésre kerülnek.</p>

<h6>Keresés</h6>
<p>Kereshetsz az összes fájlod és mappád között ha beírsz egy keresőszót a jobb oldali oszlopba és Entert ütsz. Az első
5 egyező mappa és az első 5 egyező fájl lesz visszaadva. Ha egy tételre kattintasz, az azt tartalmazó mappa meg lesz jelenítve
és azok a tételek amelyek megegyeznek a kereséseddel ki lesznek emelve. A tételek mappanév, fájlnév, kiterjesztés,
hely és távoli "container" alapján lesznek keresve.</p>';
