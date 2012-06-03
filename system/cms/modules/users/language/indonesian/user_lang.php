<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_add_field']                        	= 'Add User Profile Field'; #translate
$lang['user_profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user_profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user_profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user_register_header']                  = 'Registrasi';
$lang['user_register_step1']                   = '<strong>Tahap 1:</strong> Registrasi';
$lang['user_register_step2']                   = '<strong>Tahap 2:</strong> Aktivasi';

$lang['user_login_header']                     = 'Masuk';

// titles
$lang['user_add_title']                        = 'Tambah Pengguna';
$lang['user_list_title'] 					   = 'Pengguna';
$lang['user_inactive_title']                   = 'Pengguna Tidak Aktif';
$lang['user_active_title']                     = 'Pengguna Aktif';
$lang['user_registred_title']                  = 'Pengguna Terdaftar';

// labels
$lang['user_edit_title']                       = 'Edit Pengguna "%s"';
$lang['user_details_label']                    = 'Detail';
$lang['user_first_name_label']                 = 'Nama Depan';
$lang['user_last_name_label']                  = 'Nama Belakang';
$lang['user_email_label']                      = 'E-mail';
$lang['user_group_label']                      = 'Grup';
$lang['user_activate_label']                   = 'Aktifkan';
$lang['user_password_label']                   = 'Password';
$lang['user_password_confirm_label']           = 'Ulangi Password';
$lang['user_name_label']                       = 'Nama';
$lang['user_joined_label']                     = 'Tergabung';
$lang['user_last_visit_label']                 = 'Terakhir Berkunjung';
$lang['user_never_label']                      = 'Tidak Pernah';

$lang['user_no_inactives']                     = 'Tidak ada penguna tidak aktif.';
$lang['user_no_registred']                     = 'Tidak ada penguna terdaftar.';

$lang['account_changes_saved']                 = 'Perubahan pada akun Anda berhasil disimpan.';

$lang['indicates_required']                    = 'Indikasi kolom harus diisi';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title']                   = 'Registrasi';
$lang['user_activate_account_title']           = 'Aktifkan Akun';
$lang['user_activate_label']                   = 'Aktifkan';
$lang['user_activated_account_title']          = 'Akun Aktif';
$lang['user_reset_password_title']             = 'Set Ulang Password';
$lang['user_password_reset_title']             = 'Password Diset Ulang';


$lang['user_error_username']                   = 'Username yang Anda pilih sudah digunakan';
$lang['user_error_email']                      = 'Alamat email yang Anda masukkan sudah digunakan';

$lang['user_full_name']                        = 'Nama Lengkap';
$lang['user_first_name']                       = 'Nama Depan';
$lang['user_last_name']                        = 'Nama Belakang';
$lang['user_username']                         = 'Username';
$lang['user_display_name']                     = 'Nama yang Tampil';
$lang['user_email_use'] 					   = 'digunakan untuk masuk';
$lang['user_email']                            = 'E-mail';
$lang['user_confirm_email']                    = 'Konfirmasi E-mail';
$lang['user_password']                         = 'Password';
$lang['user_remember']                         = 'Ingat Saya';
$lang['user_group_id_label']                   = 'ID Grup';

$lang['user_level']                            = 'Peran Pengguna';
$lang['user_active']                           = 'Aktif';
$lang['user_lang']                             = 'Bahasa';

$lang['user_activation_code']                  = 'Kode Aktivasi';

$lang['user_reset_instructions']			   = 'Masukkan alamat email address atau username';
$lang['user_reset_password_link']              = 'Lupa Password?';

$lang['user_activation_code_sent_notice']      = 'Kode aktivasi sudah dikirimkan ke alamat email Anda.';
$lang['user_activation_by_admin_notice']       = 'Permohonan registrasi Anda sedang menunggu persetujuan Administrator.';
$lang['user_registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section']                  = 'Nama';
$lang['user_password_section']                 = 'Ubah password';
$lang['user_other_settings_section']           = 'Pengaturan lain';

$lang['user_settings_saved_success']           = 'Pengaturan untuk akun Anda telah disimpan.';
$lang['user_settings_saved_error']             = 'Terjadi kesalahan.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']                     = 'Registrasi';
$lang['user_activate_btn']                     = 'Aktifkan';
$lang['user_reset_pass_btn']                   = 'Set Ulang';
$lang['user_login_btn']                        = 'Masuk';
$lang['user_settings_btn']                     = 'Simpan Pengaturan';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success']      = 'Pengguna baru telah dibuat dan aktif.';
$lang['user_added_not_activated_success']      = 'Pengguna baru telah dibuat, akun harus diaktifkan.';

// Edit
$lang['user_edit_user_not_found_error']        = 'Pengguna tidak ditemukan.';
$lang['user_edit_success']                     = 'Pengguna telah diperbaharui.';
$lang['user_edit_error']                       = 'Terjadi kesalahan saat akan memperbaharui data pengguna.';

// Activate
$lang['user_activate_success']                 = '%s pengguna dari total %s berhasil diaktifkan.';
$lang['user_activate_error']                   = 'Anda harus memilih penguna terlebih dahulu.';

// Delete
$lang['user_delete_self_error']                = 'Anda tidak dapat menghapus akun sendiri!';
$lang['user_mass_delete_success']              = '%s penguna dari total %s berhasil dihapus.';
$lang['user_mass_delete_error']                = 'Anda harus memilih penguna terlebih dahulu.';

// Register
$lang['user_email_pass_missing']               = 'Email atau password tidak lengkap.';
$lang['user_email_exists']                     = 'Alamat email yang Anda pilih sudah digunakan oleh pengguna lain.';
$lang['user_register_error']				   = 'Kami kira Anda adalah bot. Apabila kami salah mohon maaf.';
$lang['user_register_reasons']                 = 'Bergabung untuk mengakses area spesial secara umum dibatasi. Ini artinya pengaturan Anda akan diingat, dengan lebih banyak konten dan sedikit iklan.';


// Activation
$lang['user_activation_incorrect']             = 'Aktivasi gagal. Silakan cek detail Anda dan pastikan CAPS LOCK tidak dinyalakan.';
$lang['user_activated_message']                = 'Akun Anda telah aktif, Anda sekarang dapat masuk ke akun Anda.';


// Login
$lang['user_logged_in']                        = 'Anda telah berhasil masuk.'; # TODO: Translate this in spanish
$lang['user_already_logged_in']                = 'Anda sudah masuk. Silakan keluar sebelum mencoba lagi.';
$lang['user_login_incorrect']                  = 'E-mail atau password tidak cocok. Silakan cek login Anda dan pastikan CAPS LOCK tidak dinyalakan.';
$lang['user_inactive']                         = 'Akun yang Anda coba masuki ternyata tidak aktif.<br />Cek e-mail Anda untuk instruksi dan cara aktivasi akun - <em>kemungkinan ada di berkas spam</em>.';


// Logged Out
$lang['user_logged_out']                       = 'Anda telah keluar.';

// Forgot Pass
$lang['user_forgot_incorrect']                 = "Tidak ada akun ditemukan dengan detail tersebut.";

$lang['user_password_reset_message']           = "Password Anda telah diset ulang. Anda seharusnya mendapatkan email dalam rentang waktu 2 jam. Apabila tidak, kemungkinan email yang kami kirimkan masuk ke folder spam tanpa sengaja.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject']         = 'Aktivasi Diperlukan';
$lang['user_activation_email_body']            = 'Terima kasih telah mengaktifkan akun Anda dengan %s. Untuk masuk ke dalam situs, ikuti tautan berikut:';


$lang['user_activated_email_subject']          = 'Aktivasi Selesai';
$lang['user_activated_email_content_line1']    = 'Terima kasih telah registrasi di %s. Sebelum kami dapat mengaktifkan akun Anda, silakan lengkapi dahulu proses registrasi dengan mengklik tautan berikut:';
$lang['user_activated_email_content_line2']    = 'Nampaknya program email Anda tidak mendeteksi tautan diatas, silakan akses langsung tautan berikut melalui browser Anda lalu masukkan kode aktivasi:';

// Reset Pass
$lang['user_reset_pass_email_subject']         = 'Set Ulang Password';
$lang['user_reset_pass_email_body']            = 'Password Anda di %s sudah diset ulang. Apabila Anda tidak meminta perubahan ini, silakan email kami di %s dan kami akan perbaiki semestinya.';

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
