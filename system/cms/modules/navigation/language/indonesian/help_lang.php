<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4> Ikhtisar </h4>
<p> Modul Navigasi mengontrol area navigasi utama Anda serta kelompok tautan lain. </p>

<h4>Grup Navigasi </h4>
<p>Tautan Navigasi ditampilkan menurut kelompok bahwa mereka adalah tema yang paling masuk dalam kelompok Header navigasi utama.
Periksa dokumentasi tema Anda untuk mengetahui kelompok mana navigasi tersebut didukung dalam file tema.
Jika Anda ingin menampilkan kelompok dalam konten situs gunakan tag ini: {{ navigation:links group=\"nama-grup-Anda\" }} </p>

<h4>Menambahkan Tautan </h4>
<p>Pilih judul untuk tautan anda, kemudian pilih kelompok yang Anda ingin untuk itu untuk ditampilkan.
Jenis tautannya adalah sebagai berikut:
<ul>
<li> URL: tautan eksternal - http://google.com </li>
<li> Tautan Situs: tautan dalam situs Anda - galleries/portofolio-pictures </li>
<li> Modul: menampilkan kepada pengunjung halaman index dari suatu modul </li>
<li> Halaman: tautan ke halaman </li>
</ul>
Target mesti ditentukan jika tautan ini harus terbuka di jendela browser baru atau tab.
(Tip: gunakan setidaknya New Window untuk menghindari terganggunya pengunjung situs Anda).
Kolom Class memungkinkan Anda untuk menambahkan class css untuk tautan tunggal. </p>
</p>

<h4> Pengurutan Tautan Navigasi </h4>
<p> Urutan tautan Anda di panel admin tercermin pada bagian depan situs web.
Untuk mengubah urutan kemunculannya, cukup dengan drag dan drop mereka sampai mereka berada di urutan yang Anda sukai. </p>";
