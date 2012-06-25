<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Langkah 1: Konfigurasi Database dan Server';
$lang['intro_text']		=	'PyroCMS sangat mudah untuk diinstall dan hanya memerlukan beberapa menit, tetapi ada sedikit pertanyaan yang nampaknya membingungkan jika Anda tidak memiliki latar belakang teknis. Jika ada suatu poin yang Anda dapati tidak dimengerti, silakan tanyakan penyedia layanan hosting Anda atau <a href="http://www.pyrocms.com/contact" target="_blank">kontak kami</a> untuk dukungan teknis.';

$lang['db_settings']	=	'Pengaturan Database';
$lang['db_text']		=	'PyroCMS memerlukan database (MySQL) untuk menyimpan semua konten dan pengaturan, jadi yang pertama kita butuhkan adalah mengecek apakah koneksi database berjalan lancar. Apabila Anda tidak mengerti apa yang kami minta Anda untuk mengisi silakan tanya kepada penyedia layanan hosting Anda atau server administrator untuk lebih detailnya.';
$lang['db_missing']		=	'The mysql database driver for PHP were not found, installation cannot continue. Ask your host or server administrator to install it.'; #translate

$lang['server']			=	'MySQL Hostname';
$lang['username']		=	'MySQL Username';
$lang['password']		=	'MySQL Password';
$lang['portnr']			=	'MySQL Port';
$lang['server_settings']=	'Pengaturan Server';
$lang['httpserver']		=	'HTTP Server';

$lang['httpserver_text']=	'PyroCMS memerlukan HTTP Server untuk menampilkan konten dinamik ketika pengguna membuka situs Anda. Ini nampak seperti Anda sudah memiliki suatu halaman yang dapat Anda lihat, tapi bila kita ketahui dengan tepat jenis yang mana maka PyroCMS dapat mengatur sendiri dengan lebih baik. Apabila Anda tidak mengerti apa maksudnya iniabaikan saja dan lanjutkan instalasi.';
$lang['rewrite_fail']	=	'Anda telah memilih "(Apache dengan mod_rewrite)" tetapi kami tidak dapat menyatakan bahwa mod_rewrite sudah menyala di server Anda. Cek host Anda apakah mod_rewrite sudah menyala atau langsung saja install dengan resiko ditanggung sendiri.';
$lang['mod_rewrite']	=	'Anda telah memilih "(Apache dengan mod_rewrite)" tetapi server Anda tidak memiliki modul rewrite yang menyala. Minta pada host Anda untuk menyalakanya atau install PyroCMS dengan opsi "Apache (tanpa mod_rewrite)".';
$lang['step2']			=	'Langkah 2';

// messages
$lang['db_success']		=	'Pengaturan database telah dites dan berjalan lancar.';
$lang['db_failure']		=	'Permasalahan koneksi pada database: ';

/* End of file step_1_lang.php */
