<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Berkas';
$lang['files:fetching']						= 'Menerima data...';
$lang['files:fetch_completed']				= 'Selesai';
$lang['files:save_failed']					= 'Maaf. Perubahan tidak dapat disimpan';
$lang['files:item_created']					= '"%s" telah dibuat';
$lang['files:item_updated']					= '"%s" telah diperbaharui';
$lang['files:item_deleted']					= '"%s" telah dihapus';
$lang['files:item_not_deleted']				= '"%s" tidak dapat dihapus';
$lang['files:item_not_found']				= 'Maaf. "%s" tidak ditemukan';
$lang['files:sort_saved']					= 'Urutan disimpan';
$lang['files:no_permissions']				= 'Anda tidak memiliki izin';

// Labels
$lang['files:activity']						= 'Aktivitas';
$lang['files:places']						= 'Tempat';
$lang['files:back']							= 'Kembali';
$lang['files:forward']						= 'Maju';
$lang['files:start']						= 'Mulai Mengunggah';
$lang['files:details']						= 'Detail';
$lang['files:id']							= 'ID'; #translate
$lang['files:name']							= 'Nama';
$lang['files:slug']							= 'Slug';
$lang['files:path']							= 'Path';
$lang['files:added']						= 'Tanggal Ditambahkan';
$lang['files:width']						= 'Lebar';
$lang['files:height']						= 'Tinggi';
$lang['files:ratio']						= 'Rasio';
$lang['files:alt_attribute']				= 'alt Attribute'; #translate
$lang['files:full_size']					= 'Ukuran Penuh';
$lang['files:filename']						= 'Nama Berkas';
$lang['files:filesize']						= 'Ukuran Berkas';
$lang['files:download_count']				= 'Hitungan Unduh';
$lang['files:download']						= 'Unduh';
$lang['files:location']						= 'Lokasi';
$lang['files:keywords']						= 'Keywords'; #translate
$lang['files:toggle_data_display']			= 'Toggle Data Display'; #translate
$lang['files:description']					= 'Deskripsi';
$lang['files:container']					= 'kontainer';
$lang['files:bucket']						= 'Baskom'; // no proper word if it's translated literally
$lang['files:check_container']				= 'Cek Validitas';
$lang['files:search_message']				= 'Ketik dan Tekan Enter';
$lang['files:search']						= 'Cari';
$lang['files:synchronize']					= 'Sinkronisasikan';
$lang['files:uploader']						= 'Letakkan berkas disini <br />atau<br />Klik untuk memilih berkas';
$lang['files:replace_file']					= 'Replace file'; #translate

// Context Menu
$lang['files:refresh']						= 'Refresh'; #translate
$lang['files:open']							= 'Buka';
$lang['files:new_folder']					= 'Folder Baru';
$lang['files:upload']						= 'Unggah';
$lang['files:rename']						= 'Ganti Nama';
$lang['files:replace']	  					= 'Replace'; # translate
$lang['files:delete']						= 'Hapus';
$lang['files:edit']							= 'Edit';
$lang['files:details']						= 'Detail';

// Folders

$lang['files:no_folders']					= 'Berkas dan folder diatur sebagaimana halnya bila ada di desktop Anda. Klik kanan di area di bawah pesan ini untuk membuat folder pertama. Kemudian klik kanan pada folder untuk mengganti nama, menghapus, mengunggah berkas ke dalamnya, atau mengganti detail menautkannya ke lokasi cloud.';
$lang['files:no_folders_places']			= 'Folder yang Anda buatakan tampil disini dalam bentuk diagram pohon yang bisa dibuka dan ditutup. Klik pada tautan "Tempat" untuk melihat folder utama.';
$lang['files:no_folders_wysiwyg']			= 'No folders have been created yet';
$lang['files:new_folder_name']				= 'Folder Baru';
$lang['files:folder']						= 'Folder';
$lang['files:folders']						= 'Folder';
$lang['files:select_folder']				= 'Pilih Folder';
$lang['files:subfolders']					= 'Subfolder';
$lang['files:root']							= 'Dasar';
$lang['files:no_subfolders']				= 'Tidak Ada Subfolder';
$lang['files:folder_not_empty']				= 'Anda harus menghapus konten dari "%s" terlebih dahulu';
$lang['files:mkdir_error']					= 'Kami tidak dapat membuat %s. Anda harus membuatnya secara manual';
$lang['files:chmod_error']					= 'Direktori unggahan tidak dapat ditulisi. Modenya mesti 0777';
$lang['files:location_saved']				= 'Lokasi folder telah disimpan';
$lang['files:container_exists']				= '"%s" sudah ada. Simpan untuk menautkan kontennya ke folder ini';
$lang['files:container_not_exists']			= '"%s" tidak ada di akun Anda. Simpan dan kami akan mencoba membuatnya';
$lang['files:error_container']				= '"%s" tidak dapat dibuat dan kami tidak dapat menemukan penyebabnya';
$lang['files:container_created']			= '"%s" sudah dibuat dan sekarang sudah tertaut ke folder ini';
$lang['files:unwritable']					= '"%s" tidak dapat ditulisi, silakan set permissionnya ke 0777';
$lang['files:specify_valid_folder']			= 'Anda harus menspesifikkan foledr yang benar untuk mengunggah berkas ke dalamnya';
$lang['files:enable_cdn']					= 'Anda harus menyalakan CDN untuk "%s" via kontrol panel Rackspace Anda sebelum kami mensinkronkannya';
$lang['files:synchronization_started']		= 'Memulai sinkronisasi';
$lang['files:synchronization_complete']		= 'Sinkronisasi untuk "%s" telah selesai';
$lang['files:untitled_folder']				= 'Folder Baru';

// Files
$lang['files:no_files']						= 'Tidak ada berkas';
$lang['files:file_uploaded']				= '"%s" sudah diunggah';
$lang['files:unsuccessful_fetch']			= 'Tidak dapat memuat "%s". Anda yakin ini adalah berkas untuk publik?';
$lang['files:invalid_container']			= '"%s" nampaknya bukan kontainer yang valid.';
$lang['files:no_records_found']				= 'Tidak ditemukan satu berkas pun';
$lang['files:invalid_extension']			= '"%s" memiliki ekstensi berkas yang tidak diperbolehkan';
$lang['files:upload_error']					= 'Unggah berkas gagal';
$lang['files:description_saved']			= 'Deskripsi berkas sudah disimpan';
$lang['files:alt_saved']					= 'The image alt attribute has been saved'; #translate
$lang['files:file_moved']					= '"%s" sudah dipindahkan';
$lang['files:exceeds_server_setting']		= 'Server tidak dapat menangani besarnya berkas ini';
$lang['files:exceeds_allowed']				= 'Berkas melebihi batas ukuran maksimal yang diperbolehkan';
$lang['files:file_type_not_allowed']		= 'Tipe berkas ini tidak diperbolehkan';
$lang['files:replace_warning']				= 'Warning: Do not replace a file with a file of a different type (e.g. .jpg with .png)'; #translate
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Dokumen';
$lang['files:type_i']						= 'Gambar';
$lang['files:type_o']						= 'Lainnya';

/* End of file files_lang.php */
