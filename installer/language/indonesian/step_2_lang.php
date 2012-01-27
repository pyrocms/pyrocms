<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Lsngkah 2: Cek Kebutuhan';
$lang['intro_text']		= 	'Langkah kedua ini untuk mengecek apakah server yang Anda gunakan mendukung PyroCMS. Kebanyakan server seharusnya dapat menjalankannya tanpa ada masalah.';
$lang['mandatory']		= 	'Mandat';
$lang['recommended']	= 	'Rekomendasi';

$lang['server_settings']= 	'Pengaturan HTTP Server';
$lang['server_version']	=	'Software server Anda:';
$lang['server_fail']	=	'Software server Anda tidak mendukung, kemungkinan PyroCMS tidak akan berjalan. Selama PHP dan MySQL ada di versi terbaru PyroCMS dapat berjalan sebagaimana mestinya, hanya saja tanpa URL yang bersih.';

$lang['php_settings']	=	'Pengaturan PHP';
$lang['php_required']	=	'PyroCMS memerlukan PHP versi %s ke atas.';
$lang['php_version']	=	'Server Anda saat ini menjalankan versi';
$lang['php_fail']		=	'Versi PHP Anda tidak mendukung. PyroCMS memerlukan PHP versi %s ke atas untuk berjalan lancar.';

$lang['mysql_settings']	=	'Pengaturan MySQL';
$lang['mysql_required']	=	'PyroCMS memerlukan akses ke database MySQL yang menjalankan versi 5.0 atau lebih.';
$lang['mysql_version1']	=	'Server Anda sedang menjalankan';
$lang['mysql_version2']	=	'Client Anda sedang menjalankan';
$lang['mysql_fail']		=	'Versi MySQL Anda tidak mendukung. PyroCMS memerlukan MySQL versi 5.0 ke atas untuk berjalan lancar.';

$lang['gd_settings']	=	'Pengaturan GD';
$lang['gd_required']	= 	'PyroCMS memerlukan GD library 1.0 atau lebih untuk memanipulasi gambar.';
$lang['gd_version']		= 	'Server Anda saat ini menjalankan versi';
$lang['gd_fail']		=	'Kami tidak dapat mendeteksi versi dari GD library. Ini biasanya terjadi karena GD library belum terinstal. PyroCMS masih dapat berjalan dengan baik tetapi beberapa fungsi gambar mungkin tidak akan bekerja. Sangat dianjurkan untuk memasang GD library.';

$lang['summary']		=	'Rangkuman';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS memerlukan Zlib untuk unzip dan menginstall tema.';
$lang['zlib_fail']		=	'Zlib tidak ditemukan. Ini terjadi karena Zlib belum terinstall. PyroCMS masih dapat berjalan lancar tetapi instalasi tema tidak akan bekerja. Sangat dianjurkan untuk memasang Zlib.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS memerlukan Curl untuk membuat koneksi ke situs lain.';
$lang['curl_fail']		=	'Curl tidak ditemukan. Ini terjadi karena Curl belum terinstall. PyroCMS masih dapat berjalan lancar tetapibeberapa fungsi tidak akan bekerja. Sangat dianjurkan untuk memasang Curl library.';

$lang['summary_success']	=	'Server Anda menemukan semua kebutuhan PyroCMS untuk berjalan lancar, lanjutkan ke langkah selanjutnya dengan mengklik tombol berikut.';
$lang['summary_partial']	=	'Server Anda menemukan <em>hampir</em> semua keperluan PyroCMS. Ini berarti bahwa PyroCMS masih dapat berjalan lancar tetapi ada kemungkinan Anda alan mendapatkan beberapa masalah seperti dalam mengubah ukuran gambar dan membuat thumbnail.';
$lang['summary_failure']	=	'Sepertinya server Anda gagal menemukan keperluan untuk menjalankan PyroCMS. Silakan kontak server administrator atau perusahaan jasa hosting Anda untuk menyelesaikan ini.';
$lang['next_step']		=	'Jalankan langkah selanjutnya';
$lang['step3']			=	'Langkah 3';
$lang['retry']			=	'Coba lagi';

// messages
$lang['step1_failure']	=	'Silakan isi pengaturan database yang diperlukan di form berikut.';

/* End of file step_2_lang.php */
