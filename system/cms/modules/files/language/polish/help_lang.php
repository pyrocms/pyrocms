<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = "
<h6>Skrót</h6><hr>
<p>Moduł plików jest doskonałym narzędziem administratora witryny do zarządzania plikami na stronie.
Wszystkie zdjęcia lub pliki, które są wprowadzone do treści stron, galerii, czy użyte w blogach są przechowywane tutaj.
W przypadku obrazów w zawartości strony możesz przesłać je bezpośrednio z edytora WYSIWYG lub wgrać je tutaj i po prostu wstawić je do treści przez edytor WYSIWYG.</p>
<p>Interfejs tego modułu działa podobnie jak pliki w lokalnym systemie plików komputera: używamy prawego przycisku myszy, aby wyświetlić menu kontekstowe. Wszystko w środkowym okienku jest klikalne.</p>

<h6>Zarządzanie folderami</h6>
<p>Po utworzeniu folderu najwyższego poziomu lub folderów można utworzyć dowolną liczbę podfolderów, wg potrzeby, np: blog/obrazki/screenshots/ lub strony/audio/.
Nazwy folderów są tylko do użytku własnego. Jego nazwa nie jest wyświetlana w linku do pobrania na stronie.
Aby zarządzać folderem kliknij prawym przyciskiem myszy na niego i wybierz akcję z wyświetlonego menu kontekstowego lub kliknij dwukrotnie folder, aby go otworzyć.
Możesz też kliknąć na foldery w lewej kolumnie, aby je otworzyć.</p>
<p>Jeżeli włączeni są dostawcy usług w Chmurze będzie można ustawić lokalizację folderu klikając prawym przyciskiem myszy na folder, a następnie wybierając szczegóły.
Możesz wybrać lokalizację (np: \"Amazon S3\") i umieścić w nazwie twój zdalny pojemnik lub kontener. Jeżeli pojemnik lub kontener nie istnieje zostanie utworzony jeśli klikniesz zapisz.
pamiętaj, że możesz zmienić lokalizację jedynie pustego folderu.</p>

<h6>Zarządzanie plikami</h6>
<p>By zarządzać plikami przejdź do folderu za pomocą drzewa folderów w lewej kolumnie lub przez kliknięcie dwukrotne na folder, w środkowym okienku.
Kiedy zobaczysz pliki możesz je edytować klikając prawym przyciskiem myszy. Możesz je także ustawiać we własnej kolejności przeciągając je względem siebie.</p>

<h6>Wczytywanie plików</h6>
<p>Po kliknięciu prawym przyciskiem myszy wewnątrz jakiegoś folderu i wybraniu opcji Wczytaj pojawi się okienko wczytywania.
Możesz dodac pliki przeciągając je na okno przesyłania lub klikając w nie i wybierając pliki.
Możesz wybrać wiele plików przytrzymując Control/Command lub Shift kiedy w nie klikasz. Wybrane pliki pojawią się na liście w dolnej części okna wczytywania.
Następnie można albo usunąć niepotrzebne pliki z listy lub jeśli chcesz je dodać kliknik Wczytaj, aby rozpocząć proces wysyłania.</p>
<p>Jeśli pojawi się ostrzeżenie, że rozmiar pliku jest zbyt duży, należy pamiętać, że wielu dostawców hostingu nie pozwala na przesyłanie plików większych niż 2MB.
Aby zaradzić tym ograniczeniom można albo zwrócić się do dostawcy hostingu, aby zmienił limity lub po prostu sam zmniejsz rozmiar pliku.
Zmiana rozmiaru ma dodatkową zaletę, szybszego wysyłania pliku. Własne limity możesz zmienić w
Kokpit > Pliki > Ustawienia ale będą wtórne względem limitów hostingu.</p>

<h6>Synchronizowanie plików</h6>
<p>Jesli przechowujesz pliki w Cmurze możesz je zsynchronizować ze swoją biblioteką. To umożliwia opcja Odświeżanie i pozwala na synchronizację plików w momencie odświeżenia. Na przykład jeśli hostujesz pliki 
na Amazon po kliknięciu synchronizuj zostaną pobrane. Jeśli je usuniesz z Amazona po kliknięciu Synchronizuj pliki zostaną usunięte 
z twojej biblioteki.</p>

<h6>Wyszukiwanie</h6>
<p>Możesz wyszukać wszystkie pliki i foldery, wpisując szukaną frazę w prawej kolumnie, a następnie naciskając Enter. 
Najpierw otrzymasz 5 znalezionych folderów a potem 5 plików. Gdy coś klikniesz przejdziesz do miejsca gdzie się element znajduje.
Elementy są przeszukiwane przy użyciu nazwy folderu, nazwy pliku, rozszerzenia,
lokalizacji i nazwy zdalnego pojemnika.</p>";
