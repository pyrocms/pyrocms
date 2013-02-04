<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Pliki';
$lang['files:fetching']						= 'Pobieranie danych...';
$lang['files:fetch_completed']				= 'Zakończono';
$lang['files:save_failed']					= 'Przepraszamy. Zmiany te nie mogą być zapisane';
$lang['files:item_created']					= '"%s" został utworzony';
$lang['files:item_updated']					= '"%s" został zaktualizowany';
$lang['files:item_deleted']					= '"%s" został usunięty';
$lang['files:item_not_deleted']				= '"%s" nie mógł zostać usunięty';
$lang['files:item_not_found']				= 'Przepraszamy. "%s" nie został znaleziony';
$lang['files:sort_saved']					= 'Porządek sortowania został zapisany';
$lang['files:no_permissions']				= 'Nie masz wystarczających uprawnień';

// Labels
$lang['files:activity']						= 'Działanie';
$lang['files:places']						= 'Miejsca';
$lang['files:back']							= 'Wstecz';
$lang['files:forward']						= 'Do przodu';
$lang['files:start']						= 'Wczytaj';
$lang['files:details']						= 'Sczegóły';
$lang['files:id']							= 'ID';
$lang['files:name']							= 'Nazwa';
$lang['files:slug']							= 'Ścieżka';
$lang['files:path']							= 'Ścieżka';
$lang['files:added']						= 'Data dodania';
$lang['files:width']						= 'Szerokość';
$lang['files:height']						= 'Wysokość';
$lang['files:ratio']						= 'Proporcja';
$lang['files:alt_attribute']				= 'Atrybut Alt';
$lang['files:full_size']					= 'Pełny rozmiar';
$lang['files:filename']						= 'Nazwa pliku';
$lang['files:filesize']						= 'Rozmiar pliku';
$lang['files:download_count']				= 'Ilość pobrań';
$lang['files:download']						= 'Pobierz';
$lang['files:location']						= 'Miejsce';
$lang['files:keywords']						= 'Keywords';
$lang['files:toggle_data_display']			= 'Przełącz wyświetlanie informacji';
$lang['files:description']					= 'Opis';
$lang['files:container']					= 'Kontener';
$lang['files:bucket']						= 'Komora';
$lang['files:check_container']				= 'Sprawdź poprawność';
$lang['files:search_message']				= 'Wpisz i wciśnij Enter';
$lang['files:search']						= 'Szukaj';
$lang['files:synchronize']					= 'Synchronizuj';
$lang['files:uploader']						= 'Przeciągnij pliki tu <br />lub<br />Kliknij by je wybrać';
$lang['files:replace_file']					= 'Zamień pliki';

// Context Menu
$lang['files:refresh']						= 'Odśwież';
$lang['files:open']							= 'Otwórz';
$lang['files:new_folder']					= 'Utwórz nowy folder';
$lang['files:upload']						= 'Wczytaj';
$lang['files:rename']						= 'Zmień nazwę';
$lang['files:replace']						= 'Zamień';
$lang['files:delete']						= 'Usuń';
$lang['files:edit']							= 'Eytuj';
$lang['files:details']						= 'Szczegóły';

// Folders

$lang['files:no_folders']					= 'Plikami i folderami zarządza się tak jak byłyby one na twoim pulpicie. Kliknij prawym przyciskiem myszy w obszarze poniżej tej wiadomości, aby utworzyć swój pierwszy folder. Następnie kliknij prawym przyciskiem myszy na folder aby go zmienić, usunąć, wysłać do niego pliki lub zmienić szczegóły, takie jak powiązanie go do miejsca w chmurze.';
$lang['files:no_folders_places']			= 'Foldery, które utworzysz pojawią się tutaj w widoku drzewa, które może być rozwijane i zwijane. Kliknij na "Miejsca", aby wyświetlić folder główny.';
$lang['files:no_folders_wysiwyg']			= 'No folders have been created yet';
$lang['files:new_folder_name']				= 'Folder domyślny';
$lang['files:folder']						= 'Folder';
$lang['files:folders']						= 'Foldery';
$lang['files:select_folder']				= 'Wybierz Folder';
$lang['files:subfolders']					= 'Subfoldery';
$lang['files:root']							= 'Root';
$lang['files:no_subfolders']				= 'Brak subfolderów';
$lang['files:folder_not_empty']				= 'Najpierw musisz usunąć zawarość "%s"';
$lang['files:mkdir_error']					= 'Nie jesteśmy w stanie utworzyć %s. Musisz utworzyć go ręcznie';
$lang['files:chmod_error']					= 'Katalog wczytywania nie jest zapisywalny. Musi być 0777';
$lang['files:location_saved']				= 'Lokalizacja folderu została zapisana';
$lang['files:container_exists']				= '"%s" istnieje. Zapisz by połączyć jego zawartość z tym folderem';
$lang['files:container_not_exists']			= '"%s" nie istnieje na twoim koncie. Zapisz a spróbujemy go utworzyć';
$lang['files:error_container']				= '"%s" nie może być utworzony i nie możemy określić powodu';
$lang['files:container_created']			= '"%s" został utworzony i jest obecnie powiązany z tym folderem';
$lang['files:unwritable']					= '"%s" jest niezapisywalny, sprawdż uprawnienia 0777';
$lang['files:specify_valid_folder']			= 'Musisz podać prawidłowy folder, aby przesłać do niego plik';
$lang['files:enable_cdn']					= 'Musisz mieć włączone CDN dla "%s" ściezki twego Rackspace w panelu kontrolnym zanim zaczniesz synchronizację';
$lang['files:synchronization_started']		= 'Start synchronizacji';
$lang['files:synchronization_complete']		= 'Synchronizacja dla "%s" została ukończona';
$lang['files:untitled_folder']				= 'Folder bez nazwy';

// Files
$lang['files:no_files']						= 'Nie znaleziono plików';
$lang['files:file_uploaded']				= '"%s" został wczytany';
$lang['files:unsuccessful_fetch']			= 'Nie udalo sie pobrać "%s". Czy jestes pewien, że to plik publiczny?';
$lang['files:invalid_container']			= '"%s" nie wydaje się by to był prawidłowy kontener.';
$lang['files:no_records_found']				= 'Żadne rekordy nie zostałyznalezione';
$lang['files:invalid_extension']			= '"%s" ma rozszerzenie pliku, które nie jest dozwolone';
$lang['files:upload_error']					= 'Wczytanie pliku nie powiodlo się';
$lang['files:description_saved']			= 'Sczegóły pliku zostały zapisane';
$lang['files:alt_saved']					= 'Atrybut Alt obrazka został zapisany';
$lang['files:file_moved']					= '"%s" został usunięty pomyślnie';
$lang['files:exceeds_server_setting']		= 'Serwer nie może obsłużyć pliku w tym rozmiarze';
$lang['files:exceeds_allowed']				= 'Plik przekracza maksymalny dozwolony rozmiar';
$lang['files:file_type_not_allowed']		= 'Ten typ pliku nie jest dozwolony';
$lang['files:replace_warning']				= 'Ostrzeżenie: Nie zamieniaj plików o innym typie (np.: .jpg z .png)';
$lang['files:type_a']						= 'Audio';
$lang['files:type_v']						= 'Video';
$lang['files:type_d']						= 'Dokument';
$lang['files:type_i']						= 'Obrazek';
$lang['files:type_o']						= 'Inny';

/* End of file files_lang.php */