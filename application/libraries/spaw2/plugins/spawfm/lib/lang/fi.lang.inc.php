<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// Finnish language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Copyright: Solmetra (c)2006 All rights reserved.
// Translation: Teemu Joensuu, teemu.joensuu@saunalahti.fi
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2007-06-27
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'iso-8859-1';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'spawfm' => array(
    'title' => 'Tiedostoselain',
    'error_reading_dir' => 'Virhe: Hakemiston sis‰ltˆ‰ ei voitu lukea.',
    'error_upload_forbidden' => 'Virhe: Tiedoston l‰hetys palvelimelle ei ole sallittua t‰ss‰ hakemistossa.',
    'error_upload_file_too_big' => 'Lataus ep‰onnistui: tiedostokoko liian iso.',
    'error_upload_failed' => 'Tiedoston l‰hetys ep‰onnistui.',
    'error_upload_file_incomplete' => 'L‰hetetty tiedosto ei latautunut kokonaan, yrit‰ uudelleen.',
    'error_bad_filetype' => 'Virhe: T‰m‰n tyyppiset tiedostot eiv‰t ole sallittuja.',
    'error_max_filesize' => 'Suurin hyv‰ksytty tiedostokoko:',
    'error_delete_forbidden' => 'Virhe: Tiedostojen poistaminen ei ole sallittua t‰ss‰ hakemistossa.',
    'confirm_delete' => 'Haluatko varmasti poistaa tiedoston "[*file*]"?',
    'error_delete_failed' => 'Virhe: Tiedostoa ei voitu poistaa. Sinulla ei ole ehk‰ siihen tarvittavia oikeuksia.',
    'error_no_directory_available' => 'Ei selattavissa olevia hakemistoja.',
    'download_file' => '[lataa tiedosto koneellesi]',
    'error_chmod_uploaded_file' => 'Tiedoston lataus onnistui, mutta oikeuksien muuttaminen ep‰onnistui.',
    'error_img_width_max' => 'Suurin hyv‰ksytty kuvan leveys: [*MAXWIDTH*] kuvapistett‰',
    'error_img_height_max' => 'Suurin hyv‰ksytty kuvan korkeus: [*MAXHEIGHT*] kuvapistett‰',
    'rename_text' => 'Anna uusi nimi tiedostolle "[*FILE*]":',
    'error_rename_file_missing' => 'Uudelleen nime‰minen ep‰onnistui - tiedostoa ei lˆydetty.',
    'error_rename_directories_forbidden' => 'Virhe: hakemiston uudelleen nime‰minen ei ole sallittua t‰ss‰ hakemistossa.',
    'error_rename_forbidden' => 'Virhe: Tiedostojen uudelleen nime‰minen ei ole sallittua t‰ss‰ hakemistossa.',
    'error_rename_file_exists' => 'Virhe: Tiedosto "[*FILE*]" on jo olemassa.',
    'error_rename_failed' => 'Virhe: uudelleen nime‰minen ep‰onnistui. Sinulla ei ehk‰ ole tarvittavia oikeuksia.',
    'error_rename_extension_changed' => 'Virhe: Tiedostop‰‰tteen vaihtaminen estetty!',
    'newdirectory_text' => 'Anna uuden hakemiston nimi:',
    'error_create_directories_forbidden' => 'Virhe: hakemistojen luonti on estetty.',
    'error_create_directories_name_used' => 'Antamasi nimi on jo k‰ytˆss‰, kokeile toista nime‰.',
    'error_create_directories_failed' => 'Virhe: Hakemistoa ei voitu luoda. Sinulla ei ehk‰ ole siihen tarvittavia oikeuksia.',
    'error_create_directories_name_invalid' => 'Seuraavia merkkej‰ ei voi k‰ytt‰‰ hakemiston nimess‰: / \\ : * ? " < > ',
    'confirmdeletedir_text' => 'Haluatko varmasti poistaa hakemiston "[*DIR*]"?',
    'error_delete_subdirectories_forbidden' => 'Hakemistojen poistaminen on estetty.',
    'error_delete_subdirectories_failed' => 'Hakemiston poistaminen ei onnistunut. Sinulla ei ehk‰ ole siihen tarvittavia oikeuksia.',
    'error_delete_subdirectories_not_empty' => 'Hakemisto ei ole tyhj‰',
    'upload_if_load_jpg_resize_to' => 'L‰hett‰ess‰ni jpg-valokuvan pienenn‰ se kokoon',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'Peruuta',
    'view_list' => 'Selaustapa: luettelo',
    'view_details' => 'Selaustapa: luettelo ja tiedot',
    'view_thumbs' => 'View mode: esikatselukuvat',
    'rename'    => 'Nime‰ uudelleen...',
    'delete'    => 'Poista',
    'go_up'     => 'Ylˆs',
    'upload'    =>  'L‰het‰ tiedosto',
    'create_directory'  =>  'Uusi hakemisto...',
  ),
  'file_details' => array(
    'name'  =>  'Nimi',
    'type'  =>  'Tyyppi',
    'size'  =>  'Koko',
    'date'  =>  'Muokattu',
    'filetype_suffix'  =>  'file',
    'img_dimensions'  =>  'Mitat',
    'file_folder'  =>  'Tiedostokansio',
  ),
  'filetypes' => array(
    'any'       => 'Kaikki tiedostot (*.*)',
    'images'    => 'Kuvatiedostot',
    'flash'     => 'Flash-animaatiot',
    'documents' => 'Dokumentit',
    'audio'     => 'ƒ‰nitiedostot',
    'video'     => 'Videotiedostot',
    'archives'  => 'Arkistotiedostot',
    '.jpg'  =>  'JPG-kuvatiedosto',
    '.jpeg'  =>  'JPG-kuvatiedosto',
    '.gif'  =>  'GIF-kuvatiedosto',
    '.png'  =>  'PNG-kuvatiedosto',
    '.swf'  =>  'Flash-animaaito',
    '.doc'  =>  'Microsoft Word dokumentti',
    '.xls'  =>  'Microsoft Excel dokumentti',
    '.pdf'  =>  'PDF dokumentti',
    '.rtf'  =>  'RTF dokumentti',
    '.odt'  =>  'OpenDocument Teksti',
    '.ods'  =>  'OpenDocument Taulukkolaskenta',
    '.sxw'  =>  'OpenOffice.org 1.0 Tekstidokumentti',
    '.sxc'  =>  'OpenOffice.org 1.0 Taulukkolaskenta',
    '.wav'  =>  'WAV-audiotiedosto',
    '.mp3'  =>  'MP3-audiotiedosto',
    '.ogg'  =>  'Ogg Vorbis -audiotiedosto',
    '.wma'  =>  'Windows ‰‰nitiedosto',
    '.avi'  =>  'AVI-videotiedosto',
    '.mpg'  =>  'MPEG-videotiedosto',
    '.mpeg'  =>  'MPEG-videotiedosto',
    '.mov'  =>  'QuickTime-videotiedosto',
    '.wmv'  =>  'Windows-videotiedosto',
    '.zip'  =>  'ZIP-paketti',
    '.rar'  =>  'RAR-paketti',
    '.gz'  =>  'gzip-paketti',
    '.txt'  =>  'Tekstitiedosto',
    ''  =>  '',
  ),
);
?>
