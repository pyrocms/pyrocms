<?php defined('BASEPATH') OR exit('No direct script access allowed');

// General
$lang['files:files_title']					= 'Pliki';
$lang['files:fetching']						= 'Odbieranie danych...';
$lang['files:fetch_completed']				= 'Ukończone';
$lang['files:save_failed']					= 'Przepraszamy. Zamiany nie zostały zapisane.';
$lang['files:item_created']					= '"%s" został utworzony';
$lang['files:item_updated']					= '"%s" został zaktualizowany';
$lang['files:item_deleted']					= '"%s" został usunięty';
$lang['files:item_not_deleted']				= '"%s" nie mógł zostać usunięty';
$lang['files:item_not_found']				= 'Przepraszamy. "%s" nie mógł zostać znaleziony';
$lang['files:sort_saved']					= 'Kolejność sortowania została zapisana';
$lang['files:no_permissions']				= 'Nie masz wystarczających uprawnień';

// Labels
$lang['files:activity']						= 'Aktywność';
$lang['files:places']						= 'Miejsca';
$lang['files:back']							= 'Z powrotem';
$lang['files:forward']						= 'Naprzód';
$lang['files:start']						= 'Zacznij wczytywanie';
$lang['files:details']						= 'Szczegóły';
$lang['files:id']							= 'ID';
$lang['files:name']							= 'Nazwa';
$lang['files:slug']							= 'Slug'; //not traslatable to polish
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
$lang['files:location']						= 'Lokacja';
$lang['files:keywords']						= 'Słowa kluczowe';
$lang['files:toggle_data_display']			= 'Przełącz widok danych';
$lang['files:description']					= 'Opis';
$lang['files:container']					= 'Kontener';
$lang['files:bucket']						= 'Pojemnik';
$lang['files:check_container']				= 'Sprawdź poprawność';
$lang['files:search_message']				= 'Wpisz i kliknij Enter';
$lang['files:search']						= 'Szukaj';
$lang['files:synchronize']					= 'Synchronizuj';
$lang['files:uploader']						= 'Przeciągnij pliki tu <br />lub<br />Kliknij by wybrać pliki';
$lang['files:replace_file']					= 'Zamień plik';

// Context Menu
$lang['files:refresh']						= 'Odśwież';
$lang['files:open']							= 'Otwórz';
$lang['files:new_folder']					= 'Nowy folder';
$lang['files:upload']						= 'Wczytaj';
$lang['files:rename']						= 'Zmień nazwę';
$lang['files:replace']						= 'Zamień';
$lang['files:delete']						= 'Usuń';
$lang['files:edit']							= 'Edytuj';
$lang['files:details']						= 'Szczegóły';

// Folders

$lang['files:no_folders']					= 'Pliki i foldery są zarządzane tak jak na pulpicie komputera. Kliknij prawym przyciskiem myszy w obszarze poniżej tej wiadomości, aby utworzyć pierwszy folder. Następnie kliknij prawym przyciskiem myszy na folder, aby zmienić nazwę, usunąć go, wgrać do niego pliki, zmienić dane, takie jak połączenie go z miejscem w chmurze.';
$lang['files:no_folders_places']			= 'Foldery utworzone pojawią się tutaj w drzewie, które można rozszerzyć i rozwijać. Kliknij na "Miejsca", aby zobaczyć folder główny.';
$lang['files:no_folders_wysiwyg']			= 'Żadnych folderów jescze nie utworzono.';
$lang['files:new_folder_name']				= 'Folder bez nazwy';
$lang['files:folder']						= 'Folder';
$lang['files:folders']						= 'Foldery';
$lang['files:select_folder']				= 'Wybierz folder';
$lang['files:subfolders']					= 'Subfoldery';
$lang['files:root']							= 'Root'; //not traslatable to polish
$lang['files:no_subfolders']				= 'Brak subfolderów';
$lang['files:folder_not_empty']				= 'Najpierw musisz usunąć zawartość folderu "%s"';
$lang['files:mkdir_error']					= 'Nie możemy utworzyć folderu %s. Musisz go utworzyć manualnie.';
$lang['files:chmod_error']					= 'Katalog wczytywania nie ma uprawnień do zapisu. Musi mieć prawa 0777';
$lang['files:location_saved']				= 'Lokalizacja folderu została zapisana';
$lang['files:container_exists']				= '"%s" istnieje. Zapisz by przyłączyć jego zawartość do folderu';
$lang['files:container_not_exists']			= '"%s" nie istnieje na twoim koncie. Zapisz a postaramy się go utworzyć.';
$lang['files:error_container']				= '"%s" nie mogże być utworzony i nie mogliśmy ustalić przyczyny';
$lang['files:container_created']			= '"%s" został utworzony i jest obecnie powiązany z tym folderem';
$lang['files:unwritable']					= '"%s" nie ma uprawnień do zapisu, prosimy zmienić jego prawa do 0777';
$lang['files:specify_valid_folder']			= 'Musisz podać prawidłowy folder, aby przesłać pliki do niego';
$lang['files:enable_cdn']					= 'Musisz włączyć CDN dla "%s" za pośrednictwem panelu kontrolnego Rackspace zanim będzimy mogli synchronizować';
$lang['files:synchronization_started']		= 'Rozpocznij synchronizację';
$lang['files:synchronization_complete']		= 'Synchronizacja dla katalogu "%s" została zakończona';
$lang['files:untitled_folder']				= 'Folder bez nazwy';

// Files
$lang['files:no_files']						= 'Pliki nie zostały znalezione';
$lang['files:file_uploaded']				= '"%s" został wczytany';
$lang['files:unsuccessful_fetch']			= 'Nie udało nam się przyłączyć "%s". Czy jesteś pewien, że to jest plik publiczny?';
$lang['files:invalid_container']			= '"%s" nie wydaje się być prawidłowym kontenerem.';
$lang['files:no_records_found']				= 'Nie można znaleźć żadnych rekordów';
$lang['files:invalid_extension']			= '"%s" posiada rozszerzenie, które jest niedozwolone';
$lang['files:upload_error']					= 'Nie udało się przesłać pliku';
$lang['files:description_saved']			= 'Szczegóły pliku zostały zapisane';
$lang['files:alt_saved']					= 'Atrybut Alt obrazka został zapisany';
$lang['files:file_moved']					= '"%s" został usunięty z powodzeniem';
$lang['files:exceeds_server_setting']		= 'Serwer nie może tego obsłużyć, to zbyt duży plik';
$lang['files:exceeds_allowed']				= 'Plik przekracza dozwolony maksymalny rozmiar';
$lang['files:file_type_not_allowed']		= 'Ten typ pliku nie jest dozwolony';
$lang['files:replace_warning']				= 'Uwaga: Nie zastępuj plików z różnymi rozszerzeniami (np: .jpg z .png)';
$lang['files:type_a']						= 'Audio';//not traslatable to polish
$lang['files:type_v']						= 'Video';//not traslatable to polish
$lang['files:type_d']						= 'Dokument';
$lang['files:type_i']						= 'Obrazek';
$lang['files:type_o']						= 'Inny';

/* End of file files_lang.php */
