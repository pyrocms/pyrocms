<?php defined('BASEPATH') or exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h4> Ikhtisar </h4>
<p> Modul halaman adalah cara yang sederhana tetapi ampuh untuk mengelola konten statis pada situs Anda.
Type halaman dapat dikelola dan widget tertanam tanpa pernah mengedit file template.</p>

<h4> Mengelola Halaman </h4> <hr>
<h6> Halaman Konten </h6>
<p> Ketika memilih judul halaman ingat bahwa tata letak halaman default akan menampilkan judul halaman di atas isi halaman.
Sekarangbuat konten halaman Anda menggunakan editor WYSIWYG.
Ketika Anda siap untuk menampilkan halaman kepada pengunjung atur status ke Publikasikan dan halaman akan dapat diakses melalui URL yang ditampilkan.
<strong> Anda juga harus pergi ke Desain -> Navigasi dan buat tautan navigasi baru jika Anda ingin halaman Anda muncul dalam menu. </strong> </p>

<h6> Meta data </ ​​h6>
<p> Meta title umumnya digunakan sebagai judul dalam hasil pencarian dan diyakini memberikan porsi yang signifikan dalam peringkat halaman. <br />
Meta keyword adalah kata-kata yang menggambarkan isi situs Anda dan untuk kepentingan search engine saja. <br />
Meta description adalah deskripsi singkat dari halaman ini dan dapat digunakan sebagai potongan pencarian jika mesin pencari dianggap relevan untuk pencarian. </p>

<h6> Desain </h6>
<p> Tab desain memungkinkan Anda untuk memilih tata letak halaman kustom dan opsional dalam menerapkan css yang berbeda di halaman ini saja.
Lihat Types bagian halaman di bawah ini untuk petunjuk tentang cara terbaik dalam menggunakan layout halaman. </p>

<h6> Script </h6>
<p> Anda dapat menempatkan javascript di sini jika Anda ingin script tersebut ditambahkan ke <head> halaman. </p>

<h6> Opsi </h6>
<p> Memungkinkan Anda untuk mengaktifkan komentar dan RSS feed untuk halaman ini.
Jika RSS feed diaktifkan pengunjung dapat berlangganan ke halaman ini dan mereka akan menerima anak halaman di setiap rss reader mereka. </p>

<h6> Revisi </h6>
<p> Revisi ​​adalah fitur yang sangat kuat dan berguna untuk mengedit halaman yang ada.
Katakanlah seorang karyawan baru benar-benar mengacaukan mengedit halaman.
Cukup pilih tanggal yang Anda ingin untuk kembali halaman dan klik Simpan!
Anda bahkan dapat membandingkan revisi untuk melihat apa yang telah berubah. </p>

<h4> Halaman Types </h4> <hr>
<p> layout halaman memungkinkan Anda untuk mengontrol tata letak halaman tanpa memodifikasi file tema.
Anda dapat menanamkan tag ke halaman tata letak, bukan menempatkan mereka di setiap halaman.
Sebagai contoh: Jika Anda memiliki widget twitter feed yang ingin ditampilkan di bagian bawah setiap halaman Anda tinggal menempatkan tag widget tata letak halaman:

<pre><code>
{{ page:title }}
{{ page:body }}

&lt;div class=&quot;my-twitter-widget&quot;&gt;
	{{ widgets:instance id=&quot;1&quot; }}
&lt;/div&gt;
</code></pre>
Sekarang Anda dapat menerapkan styling css untuk class \"my-twitter-widget\" dalam tab CSS.</p>";
