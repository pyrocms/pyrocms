<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h6>Cuplikan</6><hr>
<p>Modul Berkas adalah cara cerdas bagi admin situs untuk mengatur berkas yang digunakan di dalam situs. 
Semua gambar atau berkas yang dimasukkan ke dalam halaman, galeri, atau post blog disimpan disini. 
Untuk konten halaman berupa gambar dapat Anda unggah secara langsung dari WYSIWYG editor atau Anda dapat mengunggahnya disini dan tinggal memasukkannya melalui WYSIWYG.</p>
<p>Antarmuka berkas bekerja sebagaimana system berkas lokal: menggunakan klik kanan untuk menampilkan menu konteks. Segala sesuatu yang ada di panel tengah dapat diklik.</p>

<h6>Mengatur Folder</h6>
<p>Setelah Anda membuat folder level atas atau folder yang Anda buat sebagai subfolder yang Anda perlukan seperti blog/images/screenshots/ atau pages/audio/.
Nama folder adalah untuk penggunaan Anda sendiri, nama ini tidak akan ditampilkan  di tautan unduhan di halaman depan.
Untuk mengatur folder Anda tinggal mengklik kanan di atasnya lalu pilih sebuah aksi dari menu yang ditampilkan, atau klik ganda folder untuk membukanya. 
Anda juga dapat mengklik pada folder di kolom kanan untuk membukanya.</p>
<p>Jika cloud provider diaktifkan Anda dapat mengeset lokasi folder dengan mengklik kanan pada folder dan memilih Detail.
Anda kemudian dapat memilih lokasi (misalnya \"Amazon S3\") lalu menyimpan pada nama remote bucket atau kontainer. Bila bucket atau kontainer tidak
ada maka akan dibuatkan ketika Anda mengklik Simpan. Perhatikan bahwa Anda hanya bisa mengubah lokasi folder yang kosong.</p>

<h6>Mengelola Berkas</h6>
<p>Untuk mengelola berkas arahkan ke folder menggunakan pohon folder di kolom kiri atau dengan mengklik pada folder di panel tengah.
Setelah Anda melihat berkas, Anda bisa mengubahnya dengan mengklik kanan pada folder tersebut. Anda juga dapat mengurutkannya dengan menyeret mereka ke posisinya. Catat
bahwa jika Anda memiliki folder dan berkas dalam folder induk yang sama, folder akan selalu ditampilkan pertama diikuti dengan berkas.</p>

<h6>Unggah Berkas</h6>
<p>Setelah mengklik kanan folder yang diinginkan, jendela unggah akan muncul.
Anda dapat menambahkan berkas dengan menjatuhkan mereka di kotak unggah berkas atau dengan mengklik di dalam kotak dan memilih berkas dari berkas dialog standar Anda.
Anda dapat memilih beberapa berkas dengan menekan Control/Command atau tombol Shift saat mengklik mereka. Berkas yang dipilih akan ditampilkan dalam daftar di bagian bawah layar.
Anda kemudian dapat baik menghapus berkas yang tidak perlu dari daftar, atau jika puas klik unggah untuk memulai proses unggah. </p>
<p>Jika Anda mendapatkan peringatan tentang ukuran berkas yang terlalu besar, diketahui bahwa banyak host tidak mengizinkan unggah berkas lebih dari 2MB.
Kamera modern menghasilkan gambar dalam exess dari 5MB sehingga sangat umum untuk mengalami masalah ini.
Untuk memperbaiki keterbatasan ini Anda juga dapat meminta host Anda untuk mengubah batas unggah atau Anda mungkin ingin mengubah ukuran gambar Anda sebelum unggah.
Mengubah ukuran memiliki keuntungan tambahan yakni proses mengunggah menjadi lebih cepat. Anda dapat mengubah batas unggah di
CP > berkas > Pengaturan tetapi ini adalah pengecekan sekunder dengan keterbatasan host. Misalnya jika host memungkinkan unggah 50MB Anda masih dapat membatasi ukuran
dari unggah dengan menetapkan maksimum misalnya \"20\" di CP> berkas> Pengaturan. </p>

<h6>Sinkronisasi Berkas</h6>
<p> Jika Anda menyimpan berkas dengan cloud provider Anda mungkin ingin menggunakan fungsi Sinkronisasi. Ini memungkinkan Anda untuk \"refresh\"
database berkas untuk tetap up to date dengan lokasi penyimpanan lokal. Sebagai contoh jika Anda memiliki layanan lain
yang menyimpan berkas ke dalam folder di Amazon yang ingin ditampilkan dalam posting blog mingguan Anda, Anda dapat pergi ke folder Anda
yang dihubungkan dengan bucket tersebut dan klik Synkronisasikan. Hal ini akan menarik semua informasi yang tersedia dari Amazon dan
menyimpannya dalam database sebagai berkas yang diunggah melalui antarmuka Berkas. Berkas-berkas tersebut sekarang tersedia untuk dimasukkan ke dalam konten halaman,
posting blog, dll. Jika berkas sudah dihapus dari bucket sudah sejak terakhir disinkronkan, mereka sekarang akan dihapus dari
database juga</p>.

<h6>Pencarian</h6>
<p>Anda dapat mencari semua berkas dan folder dengan mengetik istilah pencarian di kolom kanan dan menekan Enter. Folder pertama 
dan 5 berkas pertama yang paling cocoklah yang akan ditampilkan. Bila Anda klik pada item folder maka semua isi didalamnya akan ditampilkan,
dan item yang cocok dengan pencarian Anda akan disorot. Item dicari berdasarkan nama folder, nama berkas, ekstensi,
lokasi, dan nama kontainer lokal.</p>";
