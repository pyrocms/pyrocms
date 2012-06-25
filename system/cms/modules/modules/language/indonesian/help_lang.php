<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4> Ikhtisar </h4>
<p> Modul Addons memungkinkan admin untuk meng-upload, memasang, dan uninstall modul pihak ketiga. </p>

<h4> Mengunggah </h4>
<p> modul baru harus dalam file zip dan folder harus bernama sama dengan modul.
Sebagai contoh jika Anda meng-upload modul 'forum' folder tersebut harus diberi nama 'forum' tidak 'test_forums'. </p>

<h4>Menonaktifkan, Uninstall, atau Menghapus modul </ h4>
<p> Jika Anda ingin menghapus sebuah modul dari halaman depan situs dan dari menu admin Anda mungkin hanya Nonaktifkan modul.
Jika Anda selesai dengan data tetapi mungkin ingin menginstal ulang modul di masa depan Anda mungkin harus memilih Uninstall.
<font color=\"red\">Catatan: ini akan menghapus semua catatan database </font> Jika Anda selesai dengan semua catatan database dan file modul yang akan Anda hapus.
<font color=\"red\"> ini akan menghapus semua file sumber, file upload, dan catatan database yang terkait dengan modul </font>. </p>
";
