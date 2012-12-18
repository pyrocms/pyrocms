<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Add User Profile Field'; #translate
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user:profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user:register_header'] 			= 'Rejestracja';
$lang['user:register_step1'] 			= '<strong>Krok 1:</strong> Zarejestruj się';
$lang['user:register_step2'] 			= '<strong>Krok 2:</strong> Aktywuj konto';

$lang['user:login_header'] 			= 'Login';

// titles
$lang['user:add_title'] 			= 'Dodaj użytkownika';
$lang['user:list_title'] 			= 'Lista użytkowników';
$lang['user:inactive_title']			= 'Nieaktywni użytkownicy';
$lang['user:active_title'] 			= 'Aktywni użytkownicy';
$lang['user:registred_title'] 			= 'Zarejestrowani użytkownicy';

// labels
$lang['user:edit_title'] 			= 'Edytuj użytkownika "%s"';
$lang['user:details_label'] 			= 'Szczegóły';
$lang['user:first_name_label']			= 'Imię';
$lang['user:last_name_label']			= 'Nazwisko';
$lang['user:group_label'] 			= 'Grupa';
$lang['user:activate_label'] 			= 'Aktywuj';
$lang['user:password_label'] 			= 'Hasło';
$lang['user:password_confirm_label'] 		= 'Potwierdź hasło';
$lang['user:name_label'] 			= 'Nazwa';
$lang['user:joined_label'] 			= 'Utworzony';
$lang['user:last_visit_label'] 			= 'Ostatnia wizyta';
$lang['user:never_label'] 			= 'Nigdy';

$lang['user:no_inactives'] 			= 'Nie ma nieaktywnych użytkowników.';
$lang['user:no_registred'] 			= 'Nie ma zarejestrowanych użytkowników.';

$lang['account_changes_saved'] 			= 'Zmiany konta zostały pomyślnie zapisane.';

$lang['indicates_required'] 			= 'Wskazuje wymagane pola';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title'] 			= 'Zarejestruj';
$lang['user:activate_account_title'] 		= 'Aktywuj konto';
$lang['user:activate_label'] 			= 'Aktywuj';
$lang['user:activated_account_title'] 		= 'Konto aktywowane';
$lang['user:reset_password_title'] 		= 'Resetuj hasło';
$lang['user:password_reset_title'] 		= 'Reset hasła';

$lang['user:error_username']           		= 'Wybrana nazwa użytkownika jest już zajęta';
$lang['user:error_email']              		= 'Podany adres e-mail jest już w użyciu';

$lang['user:full_name'] 			= 'Imię i nazwisko';
$lang['user:first_name'] 			= 'Imię';
$lang['user:last_name'] 			= 'Nazwisko';
$lang['user:username']                  	= 'Nazwa użytkownika';
$lang['user:display_name']              	= 'Wyświetlana nazwa';
$lang['user:email_use'] 			= 'używany do logowania';
$lang['user:remember']                  	= 'Pamiętaj mnie';
$lang['user:group_id_label']            	= 'ID grupy';

$lang['user:level']				= 'Rola użytkownika';
$lang['user:active']				= 'Aktywuj';
$lang['user:lang']				= 'Język';

$lang['user:activation_code']			= 'Kod aktywacyjny';

$lang['user:reset_instructions']		= 'Wpisz swój adres e-mail lub nazwę użytkownika';
$lang['user:reset_password_link']		= 'Zapomniałeś hasła?';

$lang['user:activation_code_sent_notice']	= 'Na twoją skrzynkę pocztową został wysłany email z kodem aktywacyjnym.';
$lang['user:activation_by_admin_notice']	= 'Twoje rejestracja oczekuje na zatwierdzenie przez administratora.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section'] 			= 'Nazwa';
$lang['user:password_section'] 			= 'Zmień hasło';
$lang['user:other_settings_section']		= 'Inne ustawienia';

$lang['user:settings_saved_success'] 		= 'Ustawienia Twojego konta zostały zapisane.';
$lang['user:settings_saved_error'] 		= 'Wystąpił błąd.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']			= 'Zarejestruj się';
$lang['user:activate_btn']			= 'Aktywuj';
$lang['user:reset_pass_btn']   			= 'Resetuj hasło';
$lang['user:login_btn'] 			= 'Zaloguj się';
$lang['user:settings_btn'] 			= 'Zapisz ustawienia';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success'] 	= 'Nowy użytkownik został utworzony i aktywowany.';
$lang['user:added_not_activated_success'] 	= 'Nowy użytkownik został utworzony i musi aktywować swoje konta.';

// Edit
$lang['user:edit_user_not_found_error']		= 'Użytkownik nie znaleziony.';
$lang['user:edit_success'] 			= 'Użytkownik zaktualizowany pomyślnie.';
$lang['user:edit_error'] 			= 'Wystąpił błąd podczas aktualizowania danych użytkownika.';

// Activate
$lang['user:activate_success'] 			= '%s użytkowników z %s pomyślnie aktywowało konto.';
$lang['user:activate_error'] 			= 'Najpierw musisz wybrać użytkowników.';

// Delete
$lang['user:delete_self_error'] 		= 'Nie możesz sam usunąć swojego konta!';
$lang['user:mass_delete_success'] 		= '%s z %s użytkowników usunięto pomyślnie.';
$lang['user:mass_delete_error'] 		= 'Najpierw musisz wybrać użytkowników.';

// Register
$lang['user:email_pass_missing'] 		= 'Pola email lub hasło nie zostały wypełnione.';
$lang['user:email_exists'] 			= 'Adres email który wybrałeś jest już używany przez innego użytkownika.';
$lang['user:register_error']			= 'Uważamy że jesteś botem. Jeśli jest inaczej, przyjmij nasze przeprosiny.';
$lang['user:register_reasons'] 			= 'Dołącz do nas, aby uzyskać dostęp do treści zarezerwowanych tylko dla zarejestrowanych użytkowników.';

// Activation
$lang['user:activation_incorrect']   		= 'Aktywacja nie powiodła się. Sprawdź dane i upewnij się, że klawisz CAPS LOCK nie jest wciśnięty.';
$lang['user:activated_message']   		= 'Twoje konto zostało aktywowane, możesz teraz się zalogować.';

// Login
$lang['user:logged_in']				= 'Logowanie przebiegło pomyślnie.';
$lang['user:already_logged_in'] 		= 'Jesteś już zalogowany. Proszę się wylogować zanim spróbujesz ponowanie się zalogować.';
$lang['user:login_incorrect'] 			= 'Podany email i hasło nie pasują. Sprawdź dane i upewnij się, że klawisz CAPS LOCK nie jest wciśnięty.';
$lang['user:inactive']   			= 'Konto do którego próbujesz uzyskać dostęp jest w tym momencie nieaktywne.<br />Sprawdź czy na Twojej skrzynce pocztowej nie ma wiadomości z instrukcjami jak aktywować konto - <em>wiadomość może znajdować się w folderze ze SPAMem</em>.';

// Logged Out
$lang['user:logged_out']   			= 'Zostałeś wylogowany.';

// Forgot Pass
$lang['user:forgot_incorrect']   		= "Nie znaleziono konta z takimi danymi.";

$lang['user:password_reset_message']   		= "Twoje hasło zostało zresetowane. Powinieneś otrzymać wiadomość na skrzynkę pocztową w ciągu następnych 2 godzin. Jeżeli nie ma jej w skrzynce odbiorczej, mogła trafić do katalogu ze SPAMem.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject'] 		= 'Wymagana aktywacja';
$lang['user:activation_email_body'] 		= 'Dziękujemy za aktywację Twojego konta na %s. Aby zalogować się na stronie, kliknij link poniżej:';

$lang['user:activated_email_subject'] 		= 'Aktywacja zakończona';
$lang['user:activated_email_content_line1']	= 'Dziękujemy za rejestrację na %s. Zanim Twoje konto będzie aktywne, dokończ proces rejestracji klikając w poniższy link:';
$lang['user:activated_email_content_line2']	= 'W przypadku gdy Twój klient poczy nie rozpoznaje linku poniżej, wpisz w swojej przeglądarce następujący adres URL i wpisz kod aktywacyjny:';

// Reset Pass
$lang['user:reset_pass_email_subject'] 		= 'Reset hasła';
$lang['user:reset_pass_email_body'] 		= 'Twoje hasło na stronie %s zostało zresetowane. Jeśli nie żądałeś zmiany hasła, skontaktuj się z nami wysyłąc email na adres %s, a postaramy się rozwiązać problem.';

// Profile
$lang['profile_of_title'] 			= 'Profil użytkownika %s';

$lang['profile_user_details_label'] 		= 'Szczegóły profilu użytkownika';
$lang['profile_role_label'] 			= 'Rola';
$lang['profile_registred_on_label'] 		= 'Zarejestrowany';
$lang['profile_last_login_label'] 		= 'Ostatnie logowanie';
$lang['profile_male_label'] 			= 'Mężczyzna';
$lang['profile_female_label'] 			= 'Kobieta';

$lang['profile_not_set_up'] 			= 'Ten użytkownik jeszcze nie ustawił swojego profilu.';

$lang['profile_edit'] 				= 'Edytuj swój profil';

$lang['profile_personal_section'] 		= 'Osobiste';

$lang['profile_display_name']         		= 'Wyświetlana nazwa';
$lang['profile_dob']				= 'Data urodzenia';
$lang['profile_dob_day']		      	= 'Dzień';
$lang['profile_dob_month']		  	= 'Miesiąc';
$lang['profile_dob_year']			= 'Rok';
$lang['profile_gender']				= 'Płeć';
$lang['profile_gender_nt']            		= 'Nie ujawniam';
$lang['profile_gender_male']          		= 'Mężczyzna';
$lang['profile_gender_female']        		= 'Kobieta';
$lang['profile_bio']				= 'O mnie';

$lang['profile_contact_section'] 		= 'Kontakt';

$lang['profile_phone']				= 'Telefon stacjonarny';
$lang['profile_mobile']				= 'Telefon komórkowy';
$lang['profile_address']			= 'Adres';
$lang['profile_address_line1'] 			= 'Linia #1';
$lang['profile_address_line2'] 			= 'Linia #2';
$lang['profile_address_line3'] 			= 'Linia #3';
$lang['profile_address_postcode']		= 'Kod pocztowy';
$lang['profile_website']              		= 'Strona WWW';

$lang['profile_messenger_section'] 		= 'Komunikatory';

$lang['profile_msn_handle'] 			= 'MSN';
$lang['profile_aim_handle'] 			= 'AIM';
$lang['profile_yim_handle'] 			= 'Yahoo! messenger';
$lang['profile_gtalk_handle'] 			= 'GTalk';

$lang['profile_avatar_section'] 		= 'Avatar';
$lang['profile_social_section']       		= 'Społeczności';

$lang['profile_gravatar'] 			= 'Gravatar';
$lang['profile_twitter']             		= 'Twitter';

$lang['profile_edit_success'] 			= 'Twój profil został zapisany.';
$lang['profile_edit_error'] 			= 'Wystąpił błąd.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] 			= 'Zapisz profil';

/* End of file user_lang.php */