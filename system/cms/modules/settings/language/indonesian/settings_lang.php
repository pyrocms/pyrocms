<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings_site_name']						= 'Nama Situs';
$lang['settings_site_name_desc']				= 'Nama situs untuk judul halaman dan penggunaan lain di dalam situs.';

$lang['settings_site_slogan']					= 'Slogan Situs';
$lang['settings_site_slogan_desc']				= 'Slogan situs untuk judul halaman dan penggunaan lain di dalam situs.';

$lang['settings_site_lang']						= 'Bahasa Situs';
$lang['settings_site_lang_desc']				= 'Bahasa native untuk situs, digunakan untuk memilih template dari notifikasi e-mail, formulir kontak, dan fitur lain yang tidak tergantung pada bahasa pengguna.';

$lang['settings_contact_email']					= 'Kontak E-mail';
$lang['settings_contact_email_desc']			= 'Semua e-mail dari pengguna, penunjung dan situs akan mengacu ke alamat email ini.';

$lang['settings_server_email']					= 'Server E-mail';
$lang['settings_server_email_desc']				= 'Semua e-mail kepada pengguna akan berasal dari alamat e-mail ini.';

$lang['settings_meta_topic']					= 'Meta Topik';
$lang['settings_meta_topic_desc']				= 'Dua atau tiga kata yang menjelaskan jenis perusahaan/situs ini.';

$lang['settings_currency']						= 'Mata Uang';
$lang['settings_currency_desc']					= 'Simbol mata uang unuk digunakan pada produk, layanan, dan sebagainya.';

$lang['settings_dashboard_rss']					= 'RSS Feed Dasbor';
$lang['settings_dashboard_rss_desc']			= 'Tautan ke RSS feed yang akan ditampilkan di dasbor.';

$lang['settings_dashboard_rss_count']			= 'RSS Item Dasbor';
$lang['settings_dashboard_rss_count_desc']		= 'Berapa banyak RSS item yang akan ditampilkan di dasbor?';

$lang['settings_date_format']					= 'Format Tanggal';
$lang['settings_date_format_desc']				= 'Bagaimana tanggal mesti ditampilkan di dalam situs d? Gunakan <a target="_blank" href="http://php.net/manual/en/function.date.php">format tanggal</a> dari PHP - atau - gunakan format dari <a target="_blank" href="http://php.net/manual/en/function.strftime.php">string yang diformat sebagai date</a> dari PHP.';

$lang['settings_frontend_enabled']				= 'Status Situs';
$lang['settings_frontend_enabled_desc']			= 'Gunakan opsi ini untuk bagian situs untuk menampilkan apakah situs sedang on atau off. Berguna bila Anda ingin menampilkan situs ketika sedang dalam perbaikan';

$lang['settings_mail_protocol']					= 'Mail Protocol';
$lang['settings_mail_protocol_desc']			= 'Pilih email protocol.';

$lang['settings_mail_sendmail_path']			= 'Sendmail Path';
$lang['settings_mail_sendmail_path_desc']		= 'Path untuk server sendmail biner.';

$lang['settings_mail_smtp_host']				= 'SMTP Host';
$lang['settings_mail_smtp_host_desc']			= 'Nama host dari smtp server Anda.';

$lang['settings_mail_smtp_pass']				= 'SMTP password';
$lang['settings_mail_smtp_pass_desc']			= 'SMTP password.';

$lang['settings_mail_smtp_port'] 				= 'SMTP Port';
$lang['settings_mail_smtp_port_desc'] 			= 'Nomor port SMTP.';

$lang['settings_mail_smtp_user'] 				= 'SMTP User Name';
$lang['settings_mail_smtp_user_desc'] 			= 'Nama pengguna SMTP.';

$lang['settings_unavailable_message']			= 'Pesan Tidak Tersedia';
$lang['settings_unavailable_message_desc']		= 'Ketika situs dalam keadaan off/mati atau dalam keadaan bermasalah, pesan ini akan ditampilkan kepada pengguna.';

$lang['settings_default_theme']					= 'Tema Standar';
$lang['settings_default_theme_desc']			= 'Pilih tema standar yang Anda inginkan untuk ditampilkan kepada user.';

$lang['settings_activation_email']				= 'Email Aktivasi';
$lang['settings_activation_email_desc']			= 'Kirim sebuah e-mail ketika pengguna mendaftar dengan tautan aktivasi. Matikan ini untuk membiarkan admin yang mengaktifkan akun secara langsung.';

$lang['settings_records_per_page']				= 'Baris per Halaman';
$lang['settings_records_per_page_desc']			= 'Berapa banyak baris data yang harus ditampilkan per halaman di bagian admin?';

$lang['settings_rss_feed_items']				= 'Banyak Feed item';
$lang['settings_rss_feed_items_desc']			= 'Berapa banyak item yang harus ditampilkan di RSS/blog feed?';

$lang['settings_require_lastname']				= 'Perlukan nama belakang?';
$lang['settings_require_lastname_desc']			= 'Untuk beberapa situasi, nama belakang mungkin tidak diperlukan. Apakah Anda akan mewajibkan pengguna untuk memasukkan nama belakang?';

$lang['settings_enable_profiles']				= 'Nyalakan profil';
$lang['settings_enable_profiles_desc']			= 'Izinkan Pengguna untuk menambahkan dan memperbaharui profil.';

$lang['settings_ga_email']						= 'Google Analytic E-mail';
$lang['settings_ga_email_desc']					= 'Alamat E-mailyang digunakan untuk Google Analytics, kita memerlukan ini untuk menampilkan grafik di dasbor.';

$lang['settings_ga_password']					= 'Google Analytic Password';
$lang['settings_ga_password_desc']				= 'Google Analytics password. Ini juga diperlukan untuk menampilkan grafik di dasbor.';

$lang['settings_ga_profile']					= 'Google Analytic Profile';
$lang['settings_ga_profile_desc']				= 'ID Profil untuk situs ini di Google Analytics.';

$lang['settings_ga_tracking']					= 'Google Tracking Code';
$lang['settings_ga_tracking_desc']				= 'Masukkan Google Analytic Tracking Code Anda untuk mengaktifkan tampilan Google Analytics view data. Contohnya: UA-19483569-6';

$lang['settings_twitter_username']				= 'Username';
$lang['settings_twitter_username_desc']			= 'Twitter username.';

$lang['settings_twitter_feed_count']			= 'Banyak Feed';
$lang['settings_twitter_feed_count_desc']		= 'Berapa banyak tweet yang akan ditampilkan di dalam blok Twitter?';

$lang['settings_twitter_cache']					= 'Waktu Cache';
$lang['settings_twitter_cache_desc']			= 'Setiap berapa menit tweet Anda dimuat?';

$lang['settings_akismet_api_key']				= 'Akismet API Key';
$lang['settings_akismet_api_key_desc']			= 'Akismet adalah spam-blocker dari tim WordPress. Alat ini mengontrol datangnya spam tanpa memaksa pengguna untuk melalui  pengecekan manusia dengan form CAPTCHA.';

$lang['settings_comment_order']					= 'Urutan Komentar';
$lang['settings_comment_order_desc']			= 'Urutan komentar ketika ditampilkan.';

$lang['settings_enable_comments'] 				= 'Nyalakan Komentar';
$lang['settings_enable_comments_desc']			= 'Perbolehkan pengguna untuk mengirimkan komentar?';
	
$lang['settings_moderate_comments']				= 'Moderasi Komentar';
$lang['settings_moderate_comments_desc']		= 'Buat komentar untuk disetujui terlebih dahulu sebelum muncul di situs.';

$lang['settings_comment_markdown']				= 'Perbolehkan Markdown'; #translate
$lang['settings_comment_markdown_desc']			= 'Apakah Anda mengizinkan pengunjung mengirimkan komentar menggunakan Markdown?'; #translate

$lang['settings_version']						= 'Versi';
$lang['settings_version_desc']					= '';

$lang['settings_site_public_lang']				= 'Bahasa Publik'; #translate
$lang['settings_site_public_lang_desc']			= 'Bahasa apa yang paling pas untuk ditawarkan di halaman depan situs?'; #translate

$lang['settings_admin_force_https']				= 'Paksa HTTPS untuk Control Panel?'; #translate
$lang['settings_admin_force_https_desc']		= 'Izinkan hanya HTTPS protocol ketika menggunakan Control Panel?'; #translate

$lang['settings_files_cache']					= 'Cache File'; #translate
$lang['settings_files_cache_desc']				= 'Ketika keluaran berupa gambar melalui site.com/files berapa lama kita akan menyimpan file cache?'; #translate

$lang['settings_auto_username']					= 'Auto Username'; #translate
$lang['settings_auto_username_desc']			= 'Buat username otomatis, yang berarti pengguna dapat melewati pembuatan username saat registrasi.'; #translate

$lang['settings_registered_email']				= 'Email Pengguna Terdaftar'; #translate
$lang['settings_registered_email_desc']			= 'Kirim email notifikasi ke e-mail kontak ketika seseorang mendaftar.'; #translate

$lang['settings_ckeditor_config']               = 'CKEditor Config'; #translate
$lang['settings_ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>'; #translate

$lang['settings_enable_registration']           = 'Enable user registration'; #translate
$lang['settings_enable_registration_desc']      = 'Allow users to register in your site.'; #translate

$lang['settings_cdn_domain']                    = 'CDN Domain'; #translate
$lang['settings_cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.'; #translate

#section titles
$lang['settings_section_general']				= 'Umum';
$lang['settings_section_integration']			= 'Integrasi';
$lang['settings_section_comments']				= 'Komentar';
$lang['settings_section_users']					= 'Pengguna';
$lang['settings_section_statistics']			= 'Statistik';
$lang['settings_section_twitter']				= 'Twitter';
$lang['settings_section_files']					= 'File'; #translate

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Buka';
$lang['settings_form_option_Closed']			= 'Tutup';
$lang['settings_form_option_Enabled']			= 'Dinyalakan';
$lang['settings_form_option_Disabled']			= 'Dimatikan';
$lang['settings_form_option_Required']			= 'Diperlukan';
$lang['settings_form_option_Optional']			= 'Opsional';
$lang['settings_form_option_Oldest First']		= 'Dahulukan yang Terlama'; #translate
$lang['settings_form_option_Newest First']		= 'Dahulukan yang Terbaru'; #translate
$lang['settings_form_option_Text Only']			= 'Teks Saja'; #translate
$lang['settings_form_option_Allow Markdown']	= 'Perbolehkan Markdown'; #translate
$lang['settings_form_option_Yes']				= 'Ya'; #translate
$lang['settings_form_option_No']				= 'Tidak'; #translate

// titles
$lang['settings_edit_title']					= 'Edit Pengaturan';

// messages
$lang['settings_no_settings']					= 'Tidak ada pengaturan untuk saat ini.';
$lang['settings_save_success']					= 'Pengaturan telah disimpan!';

/* End of file settings_lang.php */
