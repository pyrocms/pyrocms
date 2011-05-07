<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Finnish translation.
 * 
 * @author Mikael Kundert <mikael@kundert.fi>
 * @date 07.02.2011
 * @version 1.0.3
 */

// Files

// Titles
$lang['files.files_title']					= 'Tiedostot';
$lang['files.upload_title']					= 'Lähetä tiedostoja';
$lang['files.edit_title']					= 'Muokkaa tiedostoa "%s"';

// Labels
$lang['files.actions_label']				= 'Toiminto';
$lang['files.download_label']				= 'Lataa';
$lang['files.edit_label']					= 'Muokkaa';
$lang['files.delete_label']					= 'Poista';
$lang['files.upload_label']					= 'Lähetä tiedosto';
$lang['files.description_label']			= 'Kuvaus';
$lang['files.type_label']					= 'Tyyppi';
$lang['files.file_label']					= 'Tiedosto';
$lang['files.filename_label']				= 'Tiedostonimi';
$lang['files.filter_label']					= 'Suodata';
$lang['files.loading_label']				= 'Ladataan...';
$lang['files.name_label']					= 'Nimi';

$lang['files.dropdown_no_subfolders']		= '-- Ei mikään --';
$lang['files.dropdown_root']				= '-- Juuri --';

$lang['files.type_a']						= 'Ääni';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Dokumentti';
$lang['files.type_i']						= 'Kuva';
$lang['files.type_o']						= 'Muu';

$lang['files.display_grid']					= 'Ruudukko';
$lang['files.display_list']					= 'Lista';

// Messages
$lang['files.create_success']				= 'Tiedosto tallennettiin.';
$lang['files.create_error']					= 'Tapahtui virhe.';
$lang['files.edit_success']					= 'Tiedosto tallennettiin onnistuneesti.';
$lang['files.edit_error']					= 'Tiedostoa tallennetaessa tapahtui virhe.';
$lang['files.delete_success']				= 'Tiedosto poistettiin.';
$lang['files.delete_error']					= 'Tiedostoa ei voitu poistaa.';
$lang['files.mass_delete_success']			= '%d/%d tiedostoa poistettiin onnistuneesti, ne olivat "%s ja %s"';
$lang['files.mass_delete_error']			= 'Tapahtui virhe poistaessa %d/%d tiedostoa, ne olivat "%s ja %s".';
$lang['files.upload_error']					= 'Tiedoston lataaminen on pakollinen.';
$lang['files.invalid_extension']			= 'Tiedostomuoto ei kelpaa.';
$lang['files.not_exists']					= 'Ei voitu valita tiedostoa (ei ole olemassa).';
$lang['files.no_files']						= 'Ei tiedostoja tällä hetkellä.';
$lang['files.no_permissions']				= 'Sinulla ei ole käyttöoikeuksia hallinnoida moduulia.';
$lang['files.no_select_error'] 				= 'Sinun tulee ensin valita tiedosto, pyyntö keskeytettiin.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Kansiot';
$lang['file_folders.manage_title']			= 'Hallitse kansioita';
$lang['file_folders.create_title']			= 'Uusi kansio';
$lang['file_folders.delete_title']			= 'Vahvista poistaminen';
$lang['file_folders.edit_title']			= 'Muokkaa kansiota "%s"';

// Labels
$lang['file_folders.folders_label']			= 'Kansiot';
$lang['file_folders.folder_label']			= 'Kansio';
$lang['file_folders.subfolders_label']		= 'Alakansio';
$lang['file_folders.parent_label']			= 'Yläkohta';
$lang['file_folders.name_label']			= 'Nimi';
$lang['file_folders.slug_label']			= 'Polkutunnus';
$lang['file_folders.created_label']			= 'Luotu';

// Messages
$lang['file_folders.create_success']		= 'Kansio tallennettiin.';
$lang['file_folders.create_error']			= 'Kansiota luodessa tapahtui virhe.';
$lang['file_folders.edit_success']			= 'Tiedosto tallennettiin onnistuneesti.';
$lang['file_folders.edit_error']			= 'Muutoksia tallennettaessa tapahtui virhe.';
$lang['file_folders.confirm_delete']		= 'Oletko varma, että haluat poistaa alla olevan kansion? Kaikki sen sisällä olevat tiedostot ja kansiot poistetaan myös.';
$lang['file_folders.delete_mass_success']	= '%d/%d kansiota poistettiin onnistuneesti, ne olivat "%s ja %s.';
$lang['file_folders.delete_mass_error']		= '%d/%d kansioita poistaessa tapahtui virhe, ne olivat "%s ja %s".';
$lang['file_folders.delete_success']		= 'Kansio "%s" poistettiin.';
$lang['file_folders.delete_error']			= 'Kansion "%s" poistaessa tapahtui virhe.';
$lang['file_folders.not_exists']			= 'Ei voitu valita kansiota (ei ole olemassa).';
$lang['file_folders.no_subfolders']			= 'Ei yhtään';
$lang['file_folders.no_folders']			= 'Tiedostot listataan kansioittain. Tällä hetkellä kansioita ei ole luotu.';
$lang['file_folders.mkdir_error']			= 'Ei voitu luoda uploads/files kansiota';
$lang['file_folders.chmod_error']			= 'Ei voitu määrittää käyttöoikeuksia uploads/files kansioon';

/* End of file files_lang.php */