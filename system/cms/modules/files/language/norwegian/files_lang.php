<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Filer';
$lang['files:fetching']						= 'Mottar data...';
$lang['files:fetch_completed']				= 'Ferdig';
$lang['files:save_failed']					= 'En feil oppstod, endringene kunne ikke lagres';
$lang['files:item_created']					= '"%s" ble opprettet';
$lang['files:item_updated']					= '"%s" ble oppdatert';
$lang['files:item_deleted']					= '"%s" ble slettet';
$lang['files:item_not_deleted']				= '"%s" kunne ikke slettes.';
$lang['files:item_not_found']				= 'En feil oppstod. "%s" ble ikke funnet';
$lang['files:sort_saved']					= 'Sortering lagret';
$lang['files:no_permissions']				= 'Du har ikke rettigheter';

// Labels
$lang['files:activity']						= 'Aktivitet';
$lang['files:places']						= 'Steder';
$lang['files:back']							= 'Tilbake';
$lang['files:forward']						= 'Fremover';
$lang['files:start']						= 'Start opplasting';
$lang['files:details']						= 'Detaljer';
$lang['files:name']							= 'Navn';
$lang['files:slug']							= 'Slug';
$lang['files:path']							= 'Plassering';
$lang['files:added']						= 'Dato lagt til';
$lang['files:width']						= 'Bredde';
$lang['files:height']						= 'H�yde';
$lang['files:ratio']						= 'Ratio';
$lang['files:full_size']					= 'Full st�rrelse';
$lang['files:filename']						= 'Filnavn';
$lang['files:filesize']						= 'Filst�rrelse';
$lang['files:download_count']				= 'Antall nedlastinger';
$lang['files:download']						= 'Last ned';
$lang['files:location']						= 'Plassering';
$lang['files:description']					= 'Beskrivelse';
$lang['files:container']					= 'Beholder';
$lang['files:bucket']						= 'B�tte';
$lang['files:check_container']				= 'Sjekk gyldighet';
$lang['files:search_message']				= 'Skriv og trykk Enter';
$lang['files:search']						= 'S�k';
$lang['files:synchronize']					= 'Synkroniser';
$lang['files:uploader']						= 'Slipp filer her <br />eller<br />Klikk her for � velge filer';

// Context Menu
$lang['files:open']							= '�pne';
$lang['files:new_folder']					= 'Ny mappe';
$lang['files:upload']						= 'Last opp';
$lang['files:rename']						= 'Gi nytt navn';
$lang['files:delete']						= 'Slett';
$lang['files:edit']							= 'Rediger';
$lang['files:details']						= 'Detaljer';

// Folders

$lang['files:no_folders']					= 'Filer og mapper behandles likt som ditt skrivebord. H�yreklikk nedenfor denne meldingen for � opprette din f�rste mappe. Detter h�yreklikk p� mappen for � utf�re handlinger.';
$lang['files:no_folders_places']			= 'Mapper du har opprettet, vil dukke opp her i et tre som kan utvides og lukkes. Klikk p� Steder for � vise root mappen.';
$lang['files:no_folders_wysiwyg']			= 'Ingen mapper har blitt opprettet enda';
$lang['files:new_folder_name']				= 'Uten Tittel';
$lang['files:folder']						= 'Mappe';
$lang['files:folders']						= 'Mapper';
$lang['files:select_folder']				= 'Velg �n mappe';
$lang['files:subfolders']					= 'Undermapper';
$lang['files:root']							= 'Root';
$lang['files:no_subfolders']				= 'Ingen undermapper';
$lang['files:folder_not_empty']				= 'Du m� slette innholdet av "%s" f�rst';
$lang['files:mkdir_error']					= 'Kunne ikke opprette %s. Du er n�dt til � opprette den manuelt';
$lang['files:chmod_error']					= 'Opplastingen katalogen er ikke skrivelig. Den m� ha 0777-CHMOD';
$lang['files:location_saved']				= 'Mappeplasseringen har blitt lagret';
$lang['files:container_exists']				= '"%s" eksiterer. Lagre for � knytte innholdet til denne mappen';
$lang['files:container_not_exists']			= '"%s" finnes ikke p� kontoen din. Lagre og vi vil pr�ve � opprette den';
$lang['files:error_container']				= '"%s" kunne ikke opprettes, og vi kunne ikke fastsl� �rsaken';
$lang['files:container_created']			= '"%s" har blitt opprettet og er n� knyttet til denne mappen';
$lang['files:unwritable']					= '"%s" er ikke skrivelig, Den m� ha 0777-CHMOD';
$lang['files:specify_valid_folder']			= 'Du m� angi en gyldig mappe for � laste opp filen til';
$lang['files:enable_cdn']					= 'Du m� aktivere CDN for "%s" via Rackspace kontrollpanel f�r vi kan synkronisere';
$lang['files:synchronization_started']		= 'Starter synkronisering';
$lang['files:synchronization_complete']		= 'Synkronisering for "%s" er fullf�rt';
$lang['files:untitled_folder']				= 'Uten tittel';

// Files
$lang['files:no_files']						= 'Ingen filer funnet';
$lang['files:file_uploaded']				= '"%s" har blit lastet opp';
$lang['files:unsuccessful_fetch']			= 'Vi kunne ikke hente "%s". Er du sikker p� at det er en offentlig fil?';
$lang['files:invalid_container']			= '"%s" er ikke en gyldig beholder.';
$lang['files:no_records_found']				= 'Ingen data ble funnet';
$lang['files:invalid_extension']			= '"%s" har en filendelse som ikke er tillatt';
$lang['files:upload_error']					= 'Opplastingen av filene mislyktes';
$lang['files:description_saved']			= 'Beskrivelse av filen har blitt lagret';
$lang['files:file_moved']					= '"%s" has been moved successfully';
$lang['files:exceeds_server_setting']		= 'Serveren kan ikke h�ndtere en s� stor fil';
$lang['files:exceeds_allowed']				= 'Filen overskrider maks tillatt st�rrelse';
$lang['files:file_type_not_allowed']		= 'Denne filtypen er ikke tillatt';
$lang['files:type_a']						= 'Lyd';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Dokument';
$lang['files:type_i']						= 'Bilde';
$lang['files:type_o']						= 'Annet';

/* End of file files_lang.php */