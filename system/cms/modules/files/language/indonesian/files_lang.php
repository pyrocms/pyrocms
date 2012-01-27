<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		Apache License v2.0
 * @link		http://pyrocms.com
 * @since		Version 1.0-dev
 * @filesource
 */

// Files

// Titles
$lang['files.files_title']					= 'File';
$lang['files.upload_title']					= 'Upload File';
$lang['files.edit_title']					= 'Edit file "%s"';

// Labels
$lang['files.download_label']				= 'Download';
$lang['files.upload_label']					= 'Upload';
$lang['files.description_label']			= 'Deskripsi';
$lang['files.type_label']					= 'Tipe';
$lang['files.file_label']					= 'File';
$lang['files.filename_label']				= 'Nama File';
$lang['files.filter_label']					= 'Saring';
$lang['files.loading_label']				= 'Memuat...';
$lang['files.name_label']					= 'Nama';

$lang['files.dropdown_select']				= '-- Pilih Folder untuk Mengupload --';
$lang['files.dropdown_no_subfolders']		= '-- Tidak ada --';
$lang['files.dropdown_root']				= '-- Pangkal --';

$lang['files.type_a']						= 'Audio';
$lang['files.type_v']						= 'Video';
$lang['files.type_d']						= 'Dokumen';
$lang['files.type_i']						= 'Gambar';
$lang['files.type_o']						= 'Lainnya';

$lang['files.display_grid']					= 'Grid';
$lang['files.display_list']					= 'Daftar';

// Messages
$lang['files.create_success']				= '"%s" berhasil diupload.';
$lang['files.create_error']					= 'Terjadi kesalahan.';
$lang['files.edit_success']					= 'File berhasil disimpan.';
$lang['files.edit_error']					= 'Terjadi kesalahan ketika mencoba menyimpan file.';
$lang['files.delete_success']				= 'File telah dihapus.';
$lang['files.delete_error']					= 'File tidak dapat dihapus.';
$lang['files.mass_delete_success']			= '%d dari %d file berhasil dihapus. Diantaranya "%s dan %s"';
$lang['files.mass_delete_error']			= 'Terjadi kesalahan ketika mencoba menghapus %d dari %d file, diantaranya "%s dan %s".';
$lang['files.upload_error']					= 'File harus terupload dahulu.';
$lang['files.invalid_extension']			= 'File harus memiliki exstensi yang valid.';
$lang['files.not_exists']					= 'Folder yang salah telah dipilih.';
$lang['files.no_files']						= 'Tidak ada file.';
$lang['files.no_permissions']				= 'Anda tidak memiliki izin untuk melihat file modul.';
$lang['files.no_select_error'] 				= 'Anda harus memilih file terlebih dahulu, permintaan ditolak.';

// File folders

// Titles
$lang['file_folders.folders_title']			= 'Folder File';
$lang['file_folders.manage_title']			= 'Atur Folder';
$lang['file_folders.create_title']			= 'Folder Baru';
$lang['file_folders.delete_title']			= 'Konfirmasi Penghapusan';
$lang['file_folders.edit_title']			= 'Edit folder "%s"';

// Labels
$lang['file_folders.folders_label']			= 'Folder';
$lang['file_folders.folder_label']			= 'Folder';
$lang['file_folders.subfolders_label']		= 'Sub-Folder';
$lang['file_folders.parent_label']			= 'Induk';
$lang['file_folders.name_label']			= 'Nama';
$lang['file_folders.slug_label']			= 'URL Slug';
$lang['file_folders.created_label']			= 'Dibuat pada';

// Messages
$lang['file_folders.create_success']		= 'Folder telah disimpan.';
$lang['file_folders.create_error']			= 'Terjadi kesalahan ketika hendak membuat folder.';
$lang['file_folders.duplicate_error']		= 'Folder bernama "%s" sudah ada.';
$lang['file_folders.edit_success']			= 'Folder berhasil disimpan.';
$lang['file_folders.edit_error']			= 'Terjadi kesalahan ketika hendak menyimpan perubahan.';
$lang['file_folders.confirm_delete']		= 'Anda yakin akan menghapus folder ini, beserta semua file dan subfolder didalamnya?';
$lang['file_folders.delete_mass_success']	= '%d dari %d folder telah berhasi dihapus, yakni "%s dan %s.';
$lang['file_folders.delete_mass_error']		= 'Terjadi kesalahan ketika hendak menghapus %d dari %d folder, yakni "%s dan %s".';
$lang['file_folders.delete_success']		= 'Folder "%s" telah dihapus.';
$lang['file_folders.delete_error']			= 'Terjadi kesalahan ketika hendak menghapus folder "%s".';
$lang['file_folders.not_exists']			= 'Folder yang salah telah dipilih.';
$lang['file_folders.no_subfolders']			= 'Tidak ada';
$lang['file_folders.no_folders']			= 'File Anda diurutkan berdasarkan folders, saat ini Anda tidak punya satupun folder yang siap.';
$lang['file_folders.mkdir_error']			= 'Tidak dapat membuat direktori upload/file';
$lang['file_folders.chmod_error']			= 'Tidak dapat chmod direktori upload/file';

/* End of file files_lang.php */
