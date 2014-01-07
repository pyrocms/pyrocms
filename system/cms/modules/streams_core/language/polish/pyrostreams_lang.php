<?php defined('BASEPATH') or exit('No direct script access allowed');
/* Messages */

$lang['streams:save_field_error'] 						= "Wystąpił problem z zapisem pola.";
$lang['streams:field_add_success']						= "Dodanie pola zakończone sukcesem.";
$lang['streams:field_update_error']						= "Wystąpił problem z aktualizacją pola.";
$lang['streams:field_update_success']					= "Aktualizacja pola zakończona sukcesem.";
$lang['streams:field_delete_error']						= "Wystąpił problem ze skasowaniem pola.";
$lang['streams:field_delete_success']					= "Skasowanie pola zakończone sukcesem.";
$lang['streams:view_options_update_error']				= "Wystąpił problem z aktualizacją opcji widoku";
$lang['streams:view_options_update_success']			= "Aktualizacja opcji widoku zakończona sukcesem.";
$lang['streams:remove_field_error']						= "Wystąpił problem z usunięciem pola.";
$lang['streams:remove_field_success']					= "Usunięcie pola zakończone sukcesem.";
$lang['streams:create_stream_error']					= "Wystąpił problem z utworzeniem strumienia";
$lang['streams:create_stream_success']					= "Utworzenie strumienia zakończone sukcesem.";
$lang['streams:stream_update_error']					= "Wystąpił problem z aktualizacją strumienia";
$lang['streams:stream_update_success']					= "Aktualizacja strumienia zakończona sukcesem.";
$lang['streams:stream_delete_error']					= "Wystąpił problem ze skasowaniem strumienia";
$lang['streams:stream_delete_success']					= "Skasowanie strumienia zakończone sukcesem.";
$lang['streams:stream_field_ass_add_error']				= "Wystąpił problem z dodaniem pola do tego strumienia.";
$lang['streams:stream_field_ass_add_success']			= "Dodanie pola do strumienia zakończone sukcesem.";
$lang['streams:stream_field_ass_upd_error']				= "Wystąpił problem z aktualizacją przypisania tego pola.";
$lang['streams:stream_field_ass_upd_success']			= "Aktualizacja przypisania pola zakończona sukcesem.";
$lang['streams:delete_entry_error']						= "Wystąpił problem z usunięciem wpisu.";
$lang['streams:delete_entry_success']					= "Usunięcie wpisu zakończone sukcesem";
$lang['streams:new_entry_error']						= "Wystąpił problem z dodaniem wpisu.";
$lang['streams:new_entry_success']						= "Dodanie wpisu zakończone sukcesem";
$lang['streams:edit_entry_error']						= "Wystąpił problem z aktualizacją wpisu.";
$lang['streams:edit_entry_success']						= "Aktualizacja wpisu zakończona sukcesem";
$lang['streams:delete_summary']							= "Czy na pewno chcesz usunąć strumień <strong>%s</strong> ? Ta czynność <strong>usunie %s %s</strong> na stałe.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "Strumień nie został określony.";
$lang['streams:invalid_stream']							= "Nieprawidłowy strumień.";
$lang['streams:not_valid_stream']						= "nie jest prawidłowym strumieniem.";
$lang['streams:invalid_stream_id']						= "Niewłaściwy ID strumienia.";
$lang['streams:invalid_row']							= "Niewłaściwy wiersz.";
$lang['streams:invalid_id']								= "Niewłaściwe ID.";
$lang['streams:cannot_find_assign']						= "Nie można odnaleźć przypisania pola.";
$lang['streams:cannot_find_pyrostreams']				= "Nie można odnaleźć PyroStreams.";
$lang['streams:table_exists']							= "Tabela ze slugiem %s już istnieje.";
$lang['streams:no_results']								= "Brak wyników.";
$lang['streams:no_entry']								= "Nie można odnaleźć wpisu.";
$lang['streams:invalid_search_type']					= "nie jest prawidłowym typem wyszukiwania.";
$lang['streams:search_not_found']						= "Nie odnaleziono wyniku wyszukiwania.";

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "Slug tego pola jest już w użyciu.";
$lang['streams:not_mysql_safe_word']					= "Pole %s jest zarezerwowanym słowem MySQL.";
$lang['streams:not_mysql_safe_characters']				= "Pole %s zawiera niedozwolone znaki.";
$lang['streams:type_not_valid']							= "Wybierz właściwy typ pola.";
$lang['streams:stream_slug_not_unique']					= "Slug tego strumienia jest już w użyciu.";
$lang['streams:field_unique']							= "Pole %s musi być unikalne.";
$lang['streams:field_is_required']						= "Pole %s jest wymagane.";
$lang['streams:date_out_or_range']						= "Wybrana data znajduje się poza akceptowanym zakresem.";

/* Field Labels */

$lang['streams:label.field']							= "Pole";
$lang['streams:label.field_required']					= "Pole jest wymagane";
$lang['streams:label.field_unique']						= "Pole jest unikalne";
$lang['streams:label.field_instructions']				= "Instrukcja pola";
$lang['streams:label.make_field_title_column']			= "Utwórz tytuł kolumny z pola";
$lang['streams:label.field_name']						= "Nazwa pola";
$lang['streams:label.field_slug']						= "Slug pola";
$lang['streams:label.field_type']						= "Typ pola";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Utworzony przez";
$lang['streams:created_date']							= "Utworzony";
$lang['streams:updated_date']							= "Zaktualizowany";
$lang['streams:value']									= "Wartość";
$lang['streams:manage']									= "Zarządzaj";
$lang['streams:search']									= "Szukaj";
$lang['streams:stream_prefix']							= "Przedrostek strumienia";

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Wyświetlanie w formularzu przy wpisywaniu lub edycji danych.";
$lang['streams:instr.stream_full_name']					= "Pełna nazwa strumienia.";
$lang['streams:instr.slug']								= "Tylko małe litery i podkreślenia.";

/* Titles */

$lang['streams:assign_field']							= "Przypisz pole do strumienia";
$lang['streams:edit_assign']							= "Edytuj przypisanie strumienia";
$lang['streams:add_field']								= "Utwórz pole";
$lang['streams:edit_field']								= "Edytuj pole";
$lang['streams:fields']									= "Pola";
$lang['streams:streams']								= "Strumienie";
$lang['streams:list_fields']							= "Lista pól";
$lang['streams:new_entry']								= "Nowy wpis";
$lang['streams:stream_entries']							= "Wpisy strumieni";
$lang['streams:entries']								= "Wpisy";
$lang['streams:stream_admin']							= "Administrator strumieni";
$lang['streams:list_streams']							= "Lista strumieni";
$lang['streams:sure']									= "Z pewnością?";
$lang['streams:field_assignments'] 						= "Przypisanie pól strumienia";
$lang['streams:new_field_assign']						= "Nowe przypisanie pola";
$lang['streams:stream_name']							= "Nazwa strumienia";
$lang['streams:stream_slug']							= "Slug strumienia";
$lang['streams:about']									= "O";
$lang['streams:total_entries']							= "Wszystkie wpisy";
$lang['streams:add_stream']								= "Nowy strumień";
$lang['streams:edit_stream']							= "Edytuj strumień";
$lang['streams:about_stream']							= "O strumieniu";
$lang['streams:title_column']							= "Kolumna tytułu";
$lang['streams:sort_method']							= "Metoda sortowania";
$lang['streams:add_entry']								= "Dodaj wpis";
$lang['streams:edit_entry']								= "Edytuj wpis";
$lang['streams:view_options']							= "Wyświetl opcje";
$lang['streams:stream_view_options']					= "Opcje wyświetlania strumienia";
$lang['streams:backup_table']							= "Zapasowa tabela strumienia";
$lang['streams:delete_stream']							= "Skasuj strumień";
$lang['streams:entry']									= "Wpis";
$lang['streams:field_types']							= "Typy pól";
$lang['streams:field_type']								= "Typ pola";
$lang['streams:database_table']							= "Tabela bazy danych";
$lang['streams:size']									= "Rozmiar";
$lang['streams:num_of_entries']							= "Ilość wpisów";
$lang['streams:num_of_fields']							= "Iliość pól";
$lang['streams:last_updated']							= "Ostatnia aktualizacja";
$lang['streams:export_schema']							= "Eksportuj schemat";

/* Startup */

$lang['streams:start.add_one']							= "dodaj tutaj";
$lang['streams:start.no_fields']						= "Żadne pole nie zostało jeszcze utworzone. Na początek możesz";
$lang['streams:start.no_assign'] 						= "Wygląda na to, że strumień nie posiada jeszcze żadnych pól. Na początek możesz";
$lang['streams:start.add_field_here']					= "dodaj tutaj pole";
$lang['streams:start.create_field_here']				= "utwórz tutaj pole";
$lang['streams:start.no_streams']						= "Jeszcze nie ma żadnych strumieni, ale możesz rozpocząć";
$lang['streams:start.no_streams_yet']					= "Jeszcze nie ma żadnych strumieni.";
$lang['streams:start.adding_one']						= "dodając jedno";
$lang['streams:start.no_fields_to_add']					= "Brak pól do dodania";
$lang['streams:start.no_fields_msg']					= "Brak pól do dodania do tego strumienia. W PyroStreams, typy pól mogą być współdzielone między strumieniami i muszą być utworzone zanim zostaną dodane. Na początek możesz";
$lang['streams:start.adding_a_field_here']				= "tutaj dodając pole";
$lang['streams:start.no_entries']						= "Nie ma wpisów do <strong>%s</strong>. Na początek możesz";
$lang['streams:add_fields']								= "przypisz pole";
$lang['streams:no_entries']								= 'Brak wpisów';
$lang['streams:add_an_entry']							= "dodaj wpis";
$lang['streams:to_this_stream_or']						= "do tego strumienia lub";
$lang['streams:no_field_assign']						= "Brak przypisań pól";
$lang['streams:no_fields_msg_first']					= "Wygląda na to, że jeszcze nie ma żadnych pól w tym strumieniu.";
$lang['streams:no_field_assign_msg']					= "Zanim zaczniesz wprowadzać dane to powinieneś";
$lang['streams:add_some_fields']						= "przypisz kilka pól";
$lang['streams:start.before_assign']					= "Zanim przypiszesz pola do strumienia to powinienieś utworzyć pole. Możesz";
$lang['streams:start.no_fields_to_assign']				= "Wygląda na to, że jeszcze nie ma żadnych pól do przypisania. Zanim przypiszesz pole to musisz ";

/* Buttons */

$lang['streams:yes_delete']								= "Tak, skasuj";
$lang['streams:no_thanks']								= "Nie, dziękuję";
$lang['streams:new_field']								= "Nowe pole";
$lang['streams:edit']									= "Edytuj";
$lang['streams:delete']									= "Skasuj";
$lang['streams:remove']									= "Usuń";
$lang['streams:reset']									= "Reset";

/* Misc */

$lang['streams:field_singular']							= "pole";
$lang['streams:field_plural']							= "pola";
$lang['streams:by_title_column']						= "według tytułów kolumn";
$lang['streams:manual_order']							= "Sortowanie ręczne";
$lang['streams:stream_data_line']						= "Edycja podstawowych danych strumienia.";
$lang['streams:view_options_line'] 						= "Wybierz kolumny, które mają być widocznie na stronie listy danych.";
$lang['streams:backup_line']							= "Utwórz oraz pobierz kopię zapasową tabeli strumienia w postaci pliku zip.";
$lang['streams:permanent_delete_line']					= "Nieodwracalnie usuń strumień i wszystkie dane z nim związane.";
$lang['streams:choose_a_field_type']					= "Wybierz typ pola";
$lang['streams:choose_a_field']							= "Wybierz pole";

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "Biblioteka reCAPTCHA została zainicjowana";
$lang['recaptcha_no_private_key']						= "Klucz API reCAPTCHA nie został dostarczony";
$lang['recaptcha_no_remoteip'] 							= "Ze względów bezpieczeństwa należy podać zdalne IP dla reCAPTCHA";
$lang['recaptcha_socket_fail'] 							= "Nie można otworzyć gniazda";
$lang['recaptcha_incorrect_response'] 					= "Niewłaściwa odpowiedź na obrazek bezpieczeństwa";
$lang['recaptcha_field_name'] 							= "Obrazek bezpieczeństwa";
$lang['recaptcha_html_error'] 							= "Błąd wczytywania obrazka bezpieczeństwa. Spróbuj później";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Maksymalna długość";
$lang['streams:upload_location'] 						= "Miejsce wrzucenia pliku";
$lang['streams:default_value'] 							= "Domyślna wartość";

$lang['streams:menu_path']								= 'Ścieżka menu';
$lang['streams:about_instructions']						= 'Krótki opis strumienia.';
$lang['streams:slug_instructions']						= 'To również będzię nazwa tabeli strumienia w bazie danych.';
$lang['streams:prefix_instructions']					= 'Jeżeli użyte, to będzie przedrostkiem nazwy tabeli w bazie danych. Stosowane w celu uniknięcia kolizji nazw.';
$lang['streams:menu_path_instructions']					= 'Miejsce, gdzie sekcja i podsekcja strumienia ma się pojawić w menu. Rozdzielone slashem: <strong>Sekcja główna/ Podsekcja</strong>.';

/* End of file pyrostreams_lang.php */
