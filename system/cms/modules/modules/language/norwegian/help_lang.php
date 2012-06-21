<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4>Oversikt</h4>
<p>Den modulen lar administratorene  å laste opp, installere og avinstallere tredjeparts moduler.</p>

<h4>Opplasting</h4>
<p>Nye moduler må være i en zip-filen og mappen må hete det samme som modulen.
For eksempel hvis du laster opp modulen 'forums' må mappen hete 'forums', ikke 'test_forums'.</p>

<h4>Deaktivering, Avinstallering eller slette en modul</h4>
<p>If you want to remove a module from the front-end and from the admin menus you may simply Disable the module.
If you are done with the data but may want to re-install the module in the future you may Uninstall it.
<font color=\"red\">Note: this removes all database records.</font> If you are finished with all database records and source files you may Delete it.
<font color=\"red\">This removes all source files, uploaded files, and database records associated with the module.</font></p>

<p>Hvis du vil fjerne en modul fra forsiden og fra admin menyene kan du bare deaktivere modulen.
Hvis du er ferdig med opplysningene, men ønsker kanskje å re-installere modulen i fremtiden kan du avinstallere den.
<font color=\"red\">Merk: Dette fjerner alle databasedatene </font> Hvis du er ferdig med alle databasedatene og kildefiler så kan du sletten den.
<font color=\"red\">Dette fjerner alle kildefiler, opplastede filer og databasedataer knyttet til modulen.</font></p>
";