<?php 
// ================================================
// SPAW File Manager plugin
// ================================================
// Turkish language file
// ================================================
// Developed: Saulius Okunevicius, saulius@solmetra.com
// Translated: Sıtkı ÖZKURT, sitki@pragmamx.org
// Copyright: Solmetra (c)2006 All rights reserved.
// ------------------------------------------------
//                                www.solmetra.com
// ================================================
// v.1.0, 2006-11-20
// ================================================

// charset to be used in dialogs
$spaw_lang_charset = 'utf-8';

// language text data array
// first dimension - block, second - exact phrase
// alternative text for toolbar buttons and title for dropdowns - 'title'
$spaw_lang_data = array(
  'spawfm' => array(
    'title' => 'SPAW Dosya Yönetimi',
    'error_reading_dir' => 'Hata: Dizin okunamıyor.',
    'error_upload_forbidden' => 'Hata: Bu dizine dosya yüklemesi izinli değil.',
    'error_upload_file_too_big' => 'Yükleme başarısız. Dosya çok büyük.',
    'error_upload_failed' => 'Yükleme başarısız.',
    'error_upload_file_incomplete' => 'Dosya yükleme için komple değil. Tekrar deneyin.',
    'error_bad_filetype' => 'Hata: Bu dosya tipi izinli değil.',
    'error_max_filesize' => 'Maksimum izinli dosya büyüklüğü:',
    'error_delete_forbidden' => 'Hata: Bu dizinde dosya silinmesi izinli değil.',
    'confirm_delete' => 'Emin misiniz, bu dosyayı "[*file*]" silmek istediğinizden?',
    'error_delete_failed' => 'Hata: Dosya silinemedi. Muhtemelen gerekli haklarınız bulunmuyor.',
    'error_no_directory_available' => 'Aranabilecek dizin mevcut değil.',
    'download_file' => '[Dosyayı indir]',
    'error_chmod_uploaded_file' => 'Dosyanın yüklemesi başarılıydı, fakat kullanıcı hakların verilmesi başarısız.',
    'error_img_width_max' => 'Maksimum izinli resim genişliği: [*MAXWIDTH*]px',
    'error_img_height_max' => 'Maksimum izinli resim yüksekliği: [*MAXHEIGHT*]px',
    'rename_text' => 'Bu dosya için "[*FILE*]" yeni bir dosya ismi girin:',
    'error_rename_file_missing' => 'Yeniden adlandırma başarısız - Dosya bulunamadı.',
    'error_rename_directories_forbidden' => 'Hata: Dizinlerin bu dizinde yeniden adlandırılması izinli değil.',
    'error_rename_forbidden' => 'Hata: Dosyaların bu dizinde yeniden adlandırılması izinli değil.',
    'error_rename_file_exists' => 'Hata: Bu dosya "[*FILE*]" zaten mevcut.',
    'error_rename_failed' => 'Hata: Yeniden adlandırma başarısız. Muhtemelen gerekli haklarınız bulunmuyor.',
    'error_rename_extension_changed' => 'Hata: Dosya isim eklentileri değiştirilemez!',
    'newdirectory_text' => 'Dizin için bir isim girin:',
    'error_create_directories_forbidden' => 'Hata: Dizin üretilmesi yasaktır',
    'error_create_directories_name_used' => 'İsim zaten kullanılmakta, başka birini deneyin.',
    'error_create_directories_failed' => 'Hata: Dizin üretilemedi. Muhtemelen gerekli haklarınız bulunmuyor.',
    'error_create_directories_name_invalid' => 'Bu işaretler dizin isimlerinde kullanılamaz: / \\ : * ? " < > |',
    'confirmdeletedir_text' => 'Emin misiniz, bu dizini "[*DIR*]" silmek istediğinizden?',
    'error_delete_subdirectories_forbidden' => 'Dizin silinmesi yasaktır.',
    'error_delete_subdirectories_failed' => 'Dizin silinemedi. Muhtemelen gerekli haklarınız bulunmuyor.',
    'error_delete_subdirectories_not_empty' => 'Dizin boş değil.',
  ),
  'buttons' => array(
    'ok'        => '  OK  ',
    'cancel'    => 'İptal',
    'view_list' => 'Modus: Liste',
    'view_details' => 'Modus: Detaylar',
    'view_thumbs' => 'Modus: Önizleme',
    'rename'    => 'Yeniden adlandırmak...',
    'delete'    => 'Sil',
    'go_up'     => 'Yüzey yukarıda',
    'upload'    =>  'Yükleme',
    'create_directory'  =>  'Yeni dizin...',
  ),
  'file_details' => array(
    'name'  =>  'İsim',
    'type'  =>  'Tip',
    'size'  =>  'Büyüklük',
    'date'  =>  'Tarih değiştirildi',
    'filetype_suffix'  =>  'Dosya',
    'img_dimensions'  =>  'Boyut',
    'file_folder'  =>  'Dosya klasörü',
  ),
  'filetypes' => array(
    'any'       => 'Tüm dosyalar (*.*)',
    'images'    => 'Resim dosyaları',
    'flash'     => 'Flash filmleri',
    'documents' => 'Belgeler',
    'audio'     => 'Audio dosyaları',
    'video'     => 'Video dosyaları',
    'archives'  => 'Arşiv dosyaları',
    '.jpg'  =>  'JPG resim dosyası',
    '.jpeg'  =>  'JPG resim dosyası',
    '.gif'  =>  'GIF resim dosyası',
    '.png'  =>  'PNG resim dosyası',
    '.swf'  =>  'Flash filmi',
    '.doc'  =>  'Microsoft Word belgesi',
    '.xls'  =>  'Microsoft Excel belgesi',
    '.pdf'  =>  'PDF belgesi',
    '.rtf'  =>  'RTF belgesi',
    '.odt'  =>  'OpenDocument Teksti',
    '.ods'  =>  'OpenDocument Elektronik tablosu',
    '.sxw'  =>  'OpenOffice.org 1.0 Tekst belgesi',
    '.sxc'  =>  'OpenOffice.org 1.0 Elektronik tablosu',
    '.wav'  =>  'WAV Audio dosyası',
    '.mp3'  =>  'MP3 Audio dosyası',
    '.ogg'  =>  'Ogg Vorbis Audio dosyası',
    '.wma'  =>  'Windows Audio dosyası',
    '.avi'  =>  'AVI Video dosyası',
    '.mpg'  =>  'MPEG Video dosyası',
    '.mpeg'  =>  'MPEG Video dosyası',
    '.mov'  =>  'QuickTime Video dosyası',
    '.wmv'  =>  'Windows Video dosyası',
    '.zip'  =>  'ZIP Arşivi',
    '.rar'  =>  'RAR Arşivi',
    '.gz'  =>  'gzip Arşivi',
    '.txt'  =>  'Text belgesi',
    ''  =>  '',
  ),
);
?>