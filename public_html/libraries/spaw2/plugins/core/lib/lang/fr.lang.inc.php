<?php 
// ================================================
// SPAW v.2.0.5
// ================================================
// French language file
// ================================================
// Author: oVa, Toulouse (France)
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.2.0.5
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'

$spaw_lang_data = array(
  'cut' => array(
    'title' => 'Couper'
  ),
  'copy' => array(
    'title' => 'Copier'
  ),
  'paste' => array(
    'title' => 'Coller'
  ),
  'undo' => array(
    'title' => 'Annuler'
  ),
  'redo' => array(
    'title' => 'R&eacute;p&eacute;ter'
  ),
  'image' => array(
    'title' => 'Ins&eacute;rer une image'
  ),
  'image_prop' => array(
    'title' => 'Propri&eacute;t&eacute;s de l\'image',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
    'source' => 'Source',
    'alt' => 'Texte alternatif',
    'align' => 'Alignement',
    'left' => 'Gauche',
    'right' => 'Droite',
    'top' => 'Haut',
    'middle' => 'Milieu',
    'bottom' => 'Bas',
    'absmiddle' => 'Milieu absolu',
    'texttop' => 'Haut de ligne',
    'baseline' => 'Bas de ligne',
    'width' => 'Largeur',
    'height' => 'Hauteur',
    'border' => 'Bordure',
    'hspace' => 'Espacement Horiz',
    'vspace' => 'Espacement Vertic',
    'dimensions' => 'Dimensions', // <= new in 2.0.1
    'reset_dimensions' => 'R&eacute;initialiser les dimensions', // <= new in 2.0.1
    'title_attr' => 'Titre', // <= new in 2.0.1
    'constrain_proportions' => 'Conserver les proportions', // <= new in 2.0.1
    'error' => 'Erreur',
    'error_width_nan' => 'Largeur non num&eacute;rique',
    'error_height_nan' => 'Hauteur non num&eacute;rique',
    'error_border_nan' => 'Bordure non num&eacute;rique',
    'error_hspace_nan' => 'Espacement Horizontal non num&eacute;rique',
    'error_vspace_nan' => 'Espacement Vertical non num&eacute;rique',
  ),
  'flash_prop' => array(                // <= new in 2.0
    'title' => 'Ins&eacute;rer une animation flash',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
    'source' => 'Source',
    'width' => 'Largeur',
    'height' => 'Hauteur',
    'error' => 'Erreur',
    'error_width_nan' => 'Largeur non num&eacute;rique',
    'error_height_nan' => 'Hauteur non num&eacute;rique',
  ),
  'inserthorizontalrule' => array( // <== v.2.0 changed from hr
    'title' => 'S&eacute;parateur horizontal'
  ),
  'table_create' => array(
    'title' => 'Creer un tableau'
  ),
  'table_prop' => array(
    'title' => 'Propri&eacute;t&eacute;s du Tableau',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
    'rows' => 'Lignes',
    'columns' => 'Colonnes',
    'css_class' => 'Classe CSS',
    'width' => 'Largeur',
    'height' => 'Hauteur',
    'border' => 'Bordure',
    'pixels' => 'Pixels',
    'cellpadding' => 'Marge de cellule',
    'cellspacing' => 'Espace entre cellules',
    'bg_color' => 'Couleur de fond',
    'background' => 'Image de fond',
    'error' => 'Erreur',
    'error_rows_nan' => 'Lignes non num&eacute;riques',
    'error_columns_nan' => 'Colonnes non num&eacute;riques',
    'error_width_nan' => 'Largeur non num&eacute;rique',
    'error_height_nan' => 'Hauteur non num&eacute;rique',
    'error_border_nan' => 'Bordure non num&eacute;rique',
    'error_cellpadding_nan' => 'Marge de cellule non num&eacute;rique',
    'error_cellspacing_nan' => 'Espace entre cellules non num&eacute;rique',
  ),
  'table_cell_prop' => array(
    'title' => 'Propri&eacute;t&eacute;s de la cellule',
    'horizontal_align' => 'Alignement Horizontal',
    'vertical_align' => 'Alignement Vertical',
    'width' => 'Largeur',
    'height' => 'Hauteur',
    'css_class' => 'Classe CSS',
    'no_wrap' => 'Pas de saut de ligne automatique',
    'bg_color' => 'Couleur de fond',
    'background' => 'Image de fond',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
    'left' => 'Gauche',
    'center' => 'Centre',
    'right' => 'Droite',
    'top' => 'Haut',
    'middle' => 'Milieu',
    'bottom' => 'Bas',
    'baseline' => 'Bas de ligne',
    'error' => 'Erreur',
    'error_width_nan' => 'Largeur non num&eacute;rique',
    'error_height_nan' => 'Hauteur non num&eacute;rique',
  ),
  'table_row_insert' => array(
    'title' => 'Ins&eacute;rer une ligne'
  ),
  'table_column_insert' => array(
    'title' => 'Ins&eacute;rer une colonne'
  ),
  'table_row_delete' => array(
    'title' => 'Supprimer une ligne'
  ),
  'table_column_delete' => array(
    'title' => 'Supprimer une colonne'
  ),
  'table_cell_merge_right' => array(
    'title' => 'Fusionner avec cellule de droite'
  ),
  'table_cell_merge_down' => array(
    'title' => 'Fusionner avec cellule du bas'
  ),
  'table_cell_split_horizontal' => array(
    'title' => 'Partager la cellule horizontalement'
  ),
  'table_cell_split_vertical' => array(
    'title' => 'Partager la cellule verticalement'
  ),
  'style' => array(
    'title' => 'Style'
  ),
  'fontname' => array( // <== v.2.0 changed from font
    'title' => 'Police'
  ),
  'fontsize' => array(
    'title' => 'Taille'
  ),
  'formatBlock' => array( // <= v.2.0: changed from paragraph
    'title' => 'Paragraphe'
  ),
  'bold' => array(
    'title' => 'Gras'
  ),
  'italic' => array(
    'title' => 'Italique'
  ),
  'underline' => array(
    'title' => 'Soulign&eacute;'
  ),
  'strikethrough' => array(
    'title' => 'Barr&eacute;'
  ),
  'insertorderedlist' => array( // <== v.2.0 changed from ordered_list
    'title' => 'Num&eacute;ros'
  ),
  'insertunorderedlist' => array( // <== v.2.0 changed from bulleted list
    'title' => 'Puces'
  ),
  'indent' => array(
    'title' => 'Augmenter la marge &agrave; droite'
  ),
  'outdent' => array( // <== v.2.0 changed from unindent
    'title' => 'Augmenter la marge &agrave; gauche'
  ),
  'justifyleft' => array( // <== v.2.0 changed from left
    'title' => 'Gauche'
  ),
  'justifycenter' => array( // <== v.2.0 changed from center
    'title' => 'Centr&eacute;'
  ),
  'justifyright' => array( // <== v.2.0 changed from right
    'title' => 'Droite'
  ),
  'justifyfull' => array( // <== v.2.0 changed from justify
    'title' => 'Justifi&eacute;'
  ),
  'fore_color' => array(
    'title' => 'Couleur du texte'
  ),
  'bg_color' => array(
    'title' => 'Couleur de fond'
  ),
  'design' => array( // <== v.2.0 changed from design_tab
    'title' => 'Basculer en mode WYSIWYG (Design)'
  ),
  'html' => array( // <== v.2.0 changed from html_tab
    'title' => 'Basculer en mode HTML (Code)'
  ),
  'colorpicker' => array(
    'title' => 'Choix de couleur',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
  ),
  'cleanup' => array(
    'title' => 'Nettoyer le code HTML (enlever les styles)',
    'confirm' => 'Valider cette action supprimera tous les styles, polices, et tags html inutiles du contenu actuel. Tout ou une partie de votre formattage pourrait &ecirc;tre perdu.',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
  ),
  'toggle_borders' => array(
    'title' => 'Activer/D&eacute;sactiver bordures',
  ),
  'hyperlink' => array(
    'title' => 'Lien',
    'url' => 'URL',
    'name' => 'Nom',
    'target' => 'Cible',
    'title_attr' => 'Titre',
  	'a_type' => 'Type',
  	'type_link' => 'Lien',
  	'type_anchor' => 'Ancre',
  	'type_link2anchor' => 'Lien vers une ancre',
  	'anchors' => 'Ancres',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
  ),
  'hyperlink_targets' => array(
  	'_self' => 'Page actuelle (_self)',
  	'_blank' => 'Nouvelle fen&ecirc;tre (_blank)',
  	'_top' => 'Cadre de haut niveau (_top)',
  	'_parent' => 'Cadre parent (_parent)'
  ),
  'unlink' => array( // <=== new v.2.0
    'title' => 'Supprimer Lien'
  ),
  'table_row_prop' => array(
    'title' => 'Propri&eacute;t&eacute;s de ligne',
	'horizontal_align' => 'Alignement Horizontal',
    'vertical_align' => 'Alignement Vertical',
    'css_class' => 'Classe CSS',
    'no_wrap' => 'Pas de saut de ligne automatique',
    'bg_color' => 'Couleur de fond',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
    'left' => 'Gauche',
    'center' => 'Centre',
    'right' => 'Droite',
    'top' => 'Haut',
    'middle' => 'Milieu',
    'bottom' => 'Bas',
    'baseline' => 'Bas de ligne',
  ),
  'symbols' => array(
    'title' => 'Caract&egrave;res sp&eacute;ciaux',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
  ),
  'templates' => array(
    'title' => 'Mod&egrave;les',
  ),
  'page_prop' => array(
    'title' => 'Propri&eacute;t&eacute;s de la page',
    'title_tag' => 'Titre',
    'charset' => 'Jeu de charact&egrave;res',
    'background' => 'Image de fond',
    'bgcolor' => 'Couleur de fond',
    'text' => 'Couleur du texte',
    'link' => 'Couleurs des liens',
    'vlink' => 'Couleur des liens visit&eacute;s',
    'alink' => 'Couleur des liens actifs',
    'leftmargin' => 'Marge gauche',
    'topmargin' => 'Marge haut',
    'css_class' => 'Classe CSS',
    'ok' => '   OK   ',
    'cancel' => 'Fermer',
  ),
  'preview' => array(
    'title' => 'Pr&eacute;visualiser',
  ),
  'image_popup' => array(
    'title' => 'Popup image',
  ),
  'zoom' => array(
    'title' => 'Zoom',
  ),
  'subscript' => array(
    'title' => 'Indice',
  ),
  'superscript' => array(
    'title' => 'Exposant',
  ),
);
?>