<?php 
// ====================================================
// SPAW PHP WYSIWYG editor control
// ====================================================
// Italian language file
// ====================================================
// Developed: Alan Mendelevich, alan@solmetra.lt
// Copyright: Solmetra (c)2003 All rights reserved.
// Italian translation: Stefano Luchetta
// stefano.luchetta@consiglio.marche.it
// ----------------------------------------------------
//                                www.solmetra.com
// ====================================================
// v.1.0, 2003-04-11
// ====================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Taglia'
  ),
  'copy' => array(
    'title' => 'Copia'
  ),
  'paste' => array(
    'title' => 'Incolla'
  ),
  'undo' => array(
    'title' => 'Annulla'
  ),
  'redo' => array(
    'title' => 'Ripeti'
  ),
    'image' => array(
    'title' => 'Inserisci Immagine' //*******ADDED BY FABRIX*******
  ),
  'hyperlink' => array(
    'title' => 'Collegamento Ipertestuale'
  ),
  'image_insert' => array(
    'title' => 'Inserisci immagine',
    'select' => 'Seleziona',
    'cancel' => 'Esci',
    'delete' => 'Elimina', // new 1.0.5
    'library' => 'Libreria',
    'preview' => 'Anteprima',
    'images' => 'Immagini',
    'upload' => 'Caricamento immagine',
    'upload_button' => 'Carica',
    'error' => 'Errore',
    'error_no_image' => 'Immagine non selezionata',
    'error_uploading' => 'Si è verificato un errore durante il caricamento dell\'immagine.',
    'error_wrong_type' => 'Formato immagine errato',
    'error_no_dir' => 'La cartella delle immagini non esiste',
	'error_cant_delete' => 'Eliminazione fallita', // new 1.0.5
  ),
  'image_prop' => array(
    'title' => 'Proprietà immagine',
    'ok' => 	'   OK   ',
    'cancel' => 'Esci',
    'source' => 'File',
    'alt' => 	'Testo al passaggio del mouse (ALT TAG)',
    'align' => 	'Allineamento',
    'justifyleft' => 	'Sinistra',
    'justifyright' => 	'Destra',
    'top' => 	'In alto',
    'middle' => 'Centro',
    'bottom' => 'In Basso',
    'absmiddle' => 'Centrato alla riga',
    'texttop' => 'In alto al testo',
    'baseline' => 'Alla Base della riga',
    'width' => 	'Larghezza',
    'height' => 'Altezza',
    'border' => 'Bordo',
    'hspace' => 'Spaziatura orizzontale',
    'vspace' => 'Spaziatura verticale',
    'error' => 	'Errore',
    'error_width_nan' =>  'Larghezza: numero non valido',
    'error_height_nan' => 'Altezza: numero non valido',
    'error_border_nan' => 'Bordo: numero non valido',
    'error_hspace_nan' => 'Spaziatura orizzontale: numero non valido',
    'error_vspace_nan' => 'Spaziatura verticale: numero non valido',
  ),
  'inserthorizontalrule' => array(
    'title' => 'Barra orizzontale'
  ),
  'table_create' => array(
    'title' => 'Inserisci tabella'
  ),
  'table_prop' => array(
    'title' => 'Proprietà tabella',
    'ok' => 	'   OK   ',
    'cancel' => 'Esci',
    'rows' => 	'Righe',
    'columns' => 'Colonne',
	'css_class' => 'Classe CSS', // <=== new 1.0.6
    'width' =>   'Larghezza',
    'height' =>  'Altezza',
    'border' =>  'Bordo',
    'pixels' =>  'pixel', 
    'cellpadding' => 'Bordatura celle',
    'cellspacing' => 'Spaziatura celle',
    'bg_color' => 'Colore bordo',
	'background' => 'Immagine di sfondo', // <=== new 1.0.6
    'error' => 'Errore',
    'error_rows_nan' => 'Righe: non è un numero valido',
    'error_columns_nan' => 'Colonne: non è un numero valido',
    'error_width_nan' => 'Larghezza: non è un numero valido',
    'error_height_nan' => 'Altezza: non è un numero valido',
    'error_border_nan' => 'Bordo: non è un numero valido',
    'error_cellpadding_nan' => 'Bordatura celle: non è un numero valido',
    'error_cellspacing_nan' => 'Spaziatura celle: non è un numero valido',
  ),
  'table_cell_prop' => array(
    'title' => 'Proprietà cella',
    'horizontal_align' => 'Allineamento orizontale',
    'vertical_align' => 'Allineamento verticale',
    'width' => 'Larghezza',
    'height' => 'Altezza',
    'css_class' => 'classe CSS',
    'no_wrap' => 'No a capo automatico',
    'bg_color' => 'Colore sfondo',
	'background' => 'Immagine di sfondo', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'Esci',
    'justifyleft' => 'Sinistra',
    'justifycenter' => 'Centro',
    'justifyright' => 'Destra',
    'top' => 'Sopra',
    'middle' => 'Centrato',
    'bottom' => 'Sotto',
    'baseline' => 'Alla base',
    'error' => 'Errore',
    'error_width_nan' => 'Larghezza: numero non valido',
    'error_height_nan' => 'Altezza: numero non valido',
    
  ),
  'table_row_insert' => array(
    'title' => 'Inserisci righa'
  ),
  'table_column_insert' => array(
    'title' => 'Inserisci colonna'
  ),
  'table_row_delete' => array(
    'title' => 'Elimina righa'
  ),
  'table_column_delete' => array(
    'title' => 'Elimina colonna'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Unisci righe'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Unisci sotto'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Dividi le celle orizontalmente'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Dividi le celle verticalmente'
  ),
  'style' => array(
    'title' => 'Stile'
  ),
  'fontname' => array(
    'title' => 'Carattere'
  ),
  'fontsize' => array(
    'title' => 'Dimensione'
  ),
  'formatBlock' => array(
    'title' => 'Paragrafo'
  ),
  'bold' => array(
    'title' => 'Grassetto'
  ),
  'italic' => array(
    'title' => 'Corsivo'
  ),
  'underline' => array(
    'title' => 'Sottolineato'
  ),
  'strikethrough' => array(
    'title' => 'Barrato' //*******ADDED BY FABRIX*******
  ),
  'insertorderedlist' => array(
    'title' => 'Elenco numerato'
  ),
  'insertunorderedlist' => array(
    'title' => 'Elenco puntato'
  ),
  'indent' => array(
    'title' => 'Rientro a destra'
  ),
  'outdent' => array(
    'title' => 'Rientro a sinistra'
  ),
  'justifyleft' => array(
    'title' => 'Allinea a sinistra'
  ),
  'justifycenter' => array(
    'title' => 'Allinea al centro'
  ),
  'justifyright' => array(
    'title' => 'Allinea a destra'
  ),
    'justifyfull' => array(
    'title' => 'Giustifica'
  ),
  'fore_color' => array(
    'title' => 'Colore carattere'
  ),
  'bg_color' => array(
    'title' => 'Colore sfondo'
  ),

  'design' => array(
    'title' => 'Visualizza in modalità WYSIWYG (grafica)'
  ),
  'html' => array(
    'title' => 'Visualizza in modalità HTML (codice)'
  ),
  'colorpicker' => array(
    'title' => 'Palette colori',
    'ok' => '   OK   ',
    'cancel' => 'Esci',
  ),
  // <<<<<<<<< NEW >>>>>>>>>
  'cleanup' => array(
    'title' => 'Pulizia codice HTML',
    'confirm' => 'Questa azione pulirà il codice HTML rimuovendo i marcatori inutili. Alcuni stili e formattazioni potrebbero andare persi.',
    'ok' => '   OK   ',
    'cancel' => 'Esci',
  ),
  'toggle_borders' => array(
    'title' => 'Visualizza/Nascondi bordi',
  ),
  'hyperlink' => array(
    'title' => 'Collegamento ipertestuale',
    'url' => 'URL',
    'name' => 'Name',
    'target' => 'Target (finestra di destinazione)',
    'title_attr' => 'Title (al passaggio del mouse)',
	'a_type' => 'Tipo', // <=== new 1.0.6
	'type_link' => 'Link', // <=== new 1.0.6
	'type_anchor' => 'Anchor', // <=== new 1.0.6
	'type_link2anchor' => 'Link all\'anchor', // <=== new 1.0.6
	'anchors' => 'Anchor', // <=== new 1.0.6
    'ok' => '   OK   ',
    'cancel' => 'Esci',
  ),
    'hyperlink_targets' => array( // <=== new 1.0.5
  	'_self' => 'Stessa finestra (_self)',
	'_blank' => 'Nuova finestra (_blank)',
	'_top' => 'Frame corrente (_top)',
	'_parent' => 'Intero FrameSet (_parent)'
  ),
'unlink' => array( // <=== new v.2.0 *******ADDED BY FABRIX*******
    'title' => 'Rimuovi Collegamento'
  ),
  'table_row_prop' => array(
    'title' => 'Proprietà riga',
    'horizontal_align' => 'Allineamento orizzontale',
    'vertical_align' => 'Allineamento verticale',
    'css_class' => 'Classe CSS',
    'no_wrap' => 'No a capo automatico',
    'bg_color' => 'Colore Sfondo',
    'ok' => '   OK   ',
    'cancel' => 'Esci',
    'justifyleft' => 'Sinistra',
    'justifycenter' => 'Centro',
    'justifyright' => 'Destra',
    'top' => 'In alto',
    'middle' => 'Centro',
    'bottom' => 'In basso',
    'baseline' => 'Alla base',
  ),
  'symbols' => array(
    'title' => 'Mappa dei caratteri',
    'ok' => '   OK   ',
    'cancel' => 'Esci',
  ),
  'templates' => array(
    'title' => 'Templates',
  ),
  'page_prop' => array(
    'title' => 'Proprietà della Pagina',
    'title_tag' => 'Titolo',
    'charset' => 'Set dei caratteri (Charset)',
    'background' => 'Immagine sfondo',
    'bgcolor' => 'Colore sfondo',
    'text' => 'Colore testo',
    'link' => 'Colore collegamento ipertestuale',
    'vlink' => 'Colore collegamento ipertestuale già visitato',
    'alink' => 'Colore collegamento ipertestuale cliccato',
    'leftmargin' => 'Margine sinistro',
    'topmargin' => 'Margin superiore',
    'css_class' => 'Classe CSS',
    'ok' => '   OK   ',
    'cancel' => 'Esci',
  ),
  'preview' => array(
    'title' => 'Anteprima',
  ),
  'image_popup' => array(
    'title' => 'Finestra Popup immagine',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
    'subscript' => array( // <=== new 1.0.7
    'title' => 'Pedice',
  ),
  'superscript' => array( // <=== new 1.0.7
    'title' => 'Apice',
  ),
);
?>
