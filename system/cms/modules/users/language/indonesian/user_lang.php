<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Add User Profile Field'; #translate
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user:profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user:register_header']                  = 'Registrasi';
$lang['user:register_step1']                   = '<strong>Tahap 1:</strong> Registrasi';
$lang['user:register_step2']                   = '<strong>Tahap 2:</strong> Aktivasi';

$lang['user:login_header']                     = 'Masuk';

// titles
$lang['user:add_title']                        = 'Tambah Pengguna';
$lang['user:list_title'] 					   = 'Pengguna';
$lang['user:inactive_title']                   = 'Pengguna Tidak Aktif';
$lang['user:active_title']                     = 'Pengguna Aktif';
$lang['user:registred_title']                  = 'Pengguna Terdaftar';

// labels
$lang['user:edit_title']                       = 'Edit Pengguna "%s"';
$lang['user:details_label']                    = 'Detail';
$lang['user:first_name_label']                 = 'Nama Depan';
$lang['user:last_name_label']                  = 'Nama Belakang';
$lang['user:group_label']                      = 'Grup';
$lang['user:activate_label']                   = 'Aktifkan';
$lang['user:password_label']                   = 'Password';
$lang['user:password_confirm_label']           = 'Ulangi Password';
$lang['user:name_label']                       = 'Nama';
$lang['user:joined_label']                     = 'Tergabung';
$lang['user:last_visit_label']                 = 'Terakhir Berkunjung';
$lang['user:never_label']                      = 'Tidak Pernah';

$lang['user:no_inactives']                     = 'Tidak ada penguna tidak aktif.';
$lang['user:no_registred']                     = 'Tidak ada penguna terdaftar.';

$lang['account_changes_saved']                 = 'Perubahan pada akun Anda berhasil disimpan.';

$lang['indicates_required']                    = 'Indikasi kolom harus diisi';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title']                   = 'Registrasi';
$lang['user:activate_account_title']           = 'Aktifkan Akun';
$lang['user:activate_label']                   = 'Aktifkan';
$lang['user:activated_account_title']          = 'Akun Aktif';
$lang['user:reset_password_title']             = 'Set Ulang Password';
$lang['user:password_reset_title']             = 'Password Diset Ulang';


$lang['user:error_username']                   = 'Username yang Anda pilih sudah digunakan';
$lang['user:error_email']                      = 'Alamat email yang Anda masukkan sudah digunakan';

$lang['user:full_name']                        = 'Nama Lengkap';
$lang['user:first_name']                       = 'Nama Depan';
$lang['user:last_name']                        = 'Nama Belakang';
$lang['user:username']                         = 'Username';
$lang['user:display_name']                     = 'Nama yang Tampil';
$lang['user:email_use'] 					   = 'digunakan untuk masuk';
$lang['user:remember']                         = 'Ingat Saya';
$lang['user:group_id_label']                   = 'ID Grup';

$lang['user:level']                            = 'Peran Pengguna';
$lang['user:active']                           = 'Aktif';
$lang['user:lang']                             = 'Bahasa';

$lang['user:activation_code']                  = 'Kode Aktivasi';

$lang['user:reset_instructions']			   = 'Masukkan alamat email address atau username';
$lang['user:reset_password_link']              = 'Lupa Password?';

$lang['user:activation_code_sent_notice']      = 'Kode aktivasi sudah dikirimkan ke alamat email Anda.';
$lang['user:activation_by_admin_notice']       = 'Permohonan registrasi Anda sedang menunggu persetujuan Administrator.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section']                  = 'Nama';
$lang['user:password_section']                 = 'Ubah password';
$lang['user:other_settings_section']           = 'Pengaturan lain';

$lang['user:settings_saved_success']           = 'Pengaturan untuk akun Anda telah disimpan.';
$lang['user:settings_saved_error']             = 'Terjadi kesalahan.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']                     = 'Registrasi';
$lang['user:activate_btn']                     = 'Aktifkan';
$lang['user:reset_pass_btn']                   = 'Set Ulang';
$lang['user:login_btn']                        = 'Masuk';
$lang['user:settings_btn']                     = 'Simpan Pengaturan';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success']      = 'Pengguna baru telah dibuat dan aktif.';
$lang['user:added_not_activated_success']      = 'Pengguna baru telah dibuat, akun harus diaktifkan.';

// Edit
$lang['user:edit_user_not_found_error']        = 'Pengguna tidak ditemukan.';
$lang['user:edit_success']                     = 'Pengguna telah diperbaharui.';
$lang['user:edit_error']                       = 'Terjadi kesalahan saat akan memperbaharui data pengguna.';

// Activate
$lang['user:activate_success']                 = '%s pengguna dari total %s berhasil diaktifkan.';
$lang['user:activate_error']                   = 'Anda harus memilih penguna terlebih dahulu.';

// Delete
$lang['user:delete_self_error']                = 'Anda tidak dapat menghapus akun sendiri!';
$lang['user:mass_delete_success']              = '%s penguna dari total %s berhasil dihapus.';
$lang['user:mass_delete_error']                = 'Anda harus memilih penguna terlebih dahulu.';

// Register
$lang['user:email_pass_missing']               = 'Email atau password tidak lengkap.';
$lang['user:email_exists']                     = 'Alamat email yang Anda pilih sudah digunakan oleh pengguna lain.';
$lang['user:register_error']				   = 'Kami kira Anda adalah bot. Apabila kami salah mohon maaf.';
$lang['user:register_reasons']                 = 'Bergabung untuk mengakses area spesial secara umum dibatasi. Ini artinya pengaturan Anda akan diingat, dengan lebih banyak konten dan sedikit iklan.';


// Activation
$lang['user:activation_incorrect']             = 'Aktivasi gagal. Silakan cek detail Anda dan pastikan CAPS LOCK tidak dinyalakan.';
$lang['user:activated_message']                = 'Akun Anda telah aktif, Anda sekarang dapat masuk ke akun Anda.';


// Login
$lang['user:logged_in']                        = 'Anda telah berhasil masuk.'; # TODO: Translate this in spanish
$lang['user:already_logged_in']                = 'Anda sudah masuk. Silakan keluar sebelum mencoba lagi.';
$lang['user:login_incorrect']                  = 'E-mail atau password tidak cocok. Silakan cek login Anda dan pastikan CAPS LOCK tidak dinyalakan.';
$lang['user:inactive']                         = 'Akun yang Anda coba masuki ternyata tidak aktif.<br />Cek e-mail Anda untuk instruksi dan cara aktivasi akun - <em>kemungkinan ada di berkas spam</em>.';


// Logged Out
$lang['user:logged_out']                       = 'Anda telah keluar.';

// Forgot Pass
$lang['user:forgot_incorrect']                 = "Tidak ada akun ditemukan dengan detail tersebut.";

$lang['user:password_reset_message']           = "Password Anda telah diset ulang. Anda seharusnya mendapatkan email dalam rentang waktu 2 jam. Apabila tidak, kemungkinan email yang kami kirimkan masuk ke folder spam tanpa sengaja.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject']         = 'Aktivasi Diperlukan';
$lang['user:activation_email_body']            = 'Terima kasih telah mengaktifkan akun Anda dengan %s. Untuk masuk ke dalam situs, ikuti tautan berikut:';


$lang['user:activated_email_subject']          = 'Aktivasi Selesai';
$lang['user:activated_email_content_line1']    = 'Terima kasih telah registrasi di %s. Sebelum kami dapat mengaktifkan akun Anda, silakan lengkapi dahulu proses registrasi dengan mengklik tautan berikut:';
$lang['user:activated_email_content_line2']    = 'Nampaknya program email Anda tidak mendeteksi tautan diatas, silakan akses langsung tautan berikut melalui browser Anda lalu masukkan kode aktivasi:';

// Reset Pass
$lang['user:reset_pass_email_subject']         = 'Set Ulang Password';
$lang['user:reset_pass_email_body']            = 'Password Anda di %s sudah diset ulang. Apabila Anda tidak meminta perubahan ini, silakan email kami di %s dan kami akan perbaiki semestinya.';

// Profile
$lang['profile_of_title']             = 'Profil %s';

$lang['profile_user_details_label']   = 'Ddetail Pengguna';
$lang['profile_role_label']           = 'Peran';
$lang['profile_registred_on_label']   = 'Registrasi pada';
$lang['profile_last_login_label']     = 'Terakhir masuk';
$lang['profile_male_label']           = 'Laki-laki';
$lang['profile_female_label']         = 'Perempuan';

$lang['profile_not_set_up']           = 'Pengguna ini belum melengkapi profil.';

$lang['profile_edit']                 = 'Edit profil Anda';

$lang['profile_personal_section']     = 'Personal';

$lang['profile_display_name']         = 'Nama yang Tampil';
$lang['profile_dob']                  = 'Tanggal Lahir';
$lang['profile_dob_day']              = 'Hari';
$lang['profile_dob_month']            = 'Bulan';
$lang['profile_dob_year']             = 'Tahun';
$lang['profile_gender']               = 'Jenis kelamin';
$lang['profile_gender_nt']            = 'Jangan sebutkan';
$lang['profile_gender_male']          = 'Laki-laki';
$lang['profile_gender_female']        = 'Perempuan';
$lang['profile_bio']                  = 'Tentang saya';

$lang['profile_contact_section']      = 'Kontak';

$lang['profile_phone']                = 'Telepon';
$lang['profile_mobile']               = 'Selular';
$lang['profile_address']              = 'Alamat';
$lang['profile_address_line1']        = 'Baris #1';
$lang['profile_address_line2']        = 'Baris #2';
$lang['profile_address_line3']        = 'Baris #3';
$lang['profile_address_postcode']     = 'Kode Pos';
$lang['profile_website']              = 'Situs';

$lang['profile_avatar_section']       = 'Avatar';

$lang['profile_edit_success']         = 'Profile Anda telah disimpan.';
$lang['profile_edit_error']           = 'Terjadi kesalahan.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']             = 'Simpan profil';
/* End of file user_lang.php */
