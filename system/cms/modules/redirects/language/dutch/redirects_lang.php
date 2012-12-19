<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['redirects:from'] 			    = 'Vanaf';
$lang['redirects:to']					= 'Naar';
$lang['redirects:edit']					= 'Wijzig';
$lang['redirects:delete']				= 'Verwijder';
$lang['redirects:type']					= 'Type';

// redirect types
$lang['redirects:301']					= '301 - Permanent verplaatst';
$lang['redirects:302']					= '302 - Tijdelijk verplaatst';

// titles
$lang['redirects:add_title'] 			= 'Voeg verwijzing toe';
$lang['redirects:edit_title'] 			= 'Wijzig verwijzing';
$lang['redirects:list_title'] 			= 'Overzicht verwijzingen';

// messages
$lang['redirects:no_redirects']			= 'Er zijn geen verwijzingen.';
$lang['redirects:add_success'] 			= 'De verwijzing is toegevoegd.';
$lang['redirects:add_error'] 			= 'De verwijzing kon niet worden toegevoegd. Probeer het later nogmaals.';
$lang['redirects:edit_success'] 		= 'De verwijzing is opgeslagen.';
$lang['redirects:edit_error'] 			= 'De verwijzing kon niet worden opgeslagen. Probeer het later nogmaals.';
$lang['redirects:mass_delete_error'] 	= 'Fout tijdens het verwijderen van verwijzing "%s".';
$lang['redirects:mass_delete_success']	= '%s verwijzingen van %s verwijderd.';
$lang['redirects:no_select_error'] 		= 'U moet een verwijzing selecteren om te kunnen verwijderen.';
$lang['redirects:request_conflict_error']	= 'Er bestaat al een verwijzing vanaf "%s".';