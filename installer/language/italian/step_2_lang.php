<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Passo 2: Verifica Requisiti';
$lang['intro_text']		= 	'Il primo passo del processo di installazione è la verifica che il tuo server supporti PyroCMS. Molti server dovrebbero essere in grado di farlo funzionare senza nessun problema.';
$lang['mandatory']		= 	'Obbligatorio';
$lang['recommended']	        = 	'Raccomandato';

$lang['server_settings']        = 	'Impostazioni Server HTTP';
$lang['server_version']	        =	'Il tuo software server:';
$lang['server_fail']	        =	'Il tuo software server non è supportato, nonostante ciò PyroCMS potrebbe funzionare. Dopo l\' aggiornamento delle installazioni di PHP e MySQL PyroCMS dovrebbe funzionare correttamente, ma senza le URL pulite.';

$lang['php_settings']	        =	'Impostazioni PHP';
$lang['php_required']	        =	'PyroCMS richiede PHP versione %s o superiore.';
$lang['php_version']	        =	'Versione di PHP installata sul tuo server';
$lang['php_fail']		=	'La versione del tuo PHP non è supportata. PyroCMS richiede PHP versione %s o superiore per funzionare correttamente.';

$lang['mysql_settings']	        =	'Impostazioni MySQL';
$lang['mysql_required']	        =	'PyroCMS richiede l\' accesso al database MySQL versione 5.0 o superiore.';
$lang['mysql_version1']	        =	'Versione del server MySQL installato';
$lang['mysql_version2']	        =	'Versione del client MySQL installato';
$lang['mysql_fail']		=	'La tua versione di MySQL non è supportata. PyroCMS richiede MySQL versione 5.0 o superiore per funzionare correttamente.';

$lang['gd_settings']	        =	'Impostazioni GD';
$lang['gd_required']	        = 	'PyroCMS richiede la libreris GD versione 1.0 o superiore per manipolare le immagini.';
$lang['gd_version']		= 	'Versione della libreria GD installata sul tuo server';
$lang['gd_fail']		=	'Non possiamo determinare la versione della libreria GD. Questo solitamente significa che la libreria GD non è installata. PyroCMS funzionerà correttamente ma non alcune funzioni riguardo le immagini. E\' caldamente raccomandato abilitare la libreria GD.';

$lang['summary']		=	'Sommario';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	        = 	'PyroCMS richiede Zlib per decomprimere ed installare i temi.';
$lang['zlib_fail']		=	'Zlib non è stato trovato. Questo solitamente significa che Zlib non è installato. PyroCMS funzionerà correttamente ma l\' installazione dei temi non funzionerà. E\' caldamente raccomandata l\' installazione di Zlib.';

$lang['curl']			=	'Curl';
$lang['curl_required']	        =	'PyroCMS richiede Curl per connettersi ad altri siti.';
$lang['curl_fail']		=	'Curl non è stato trovato. Questo solitamente significa che Curl non è installato. PyroCMS funzionerà correttamente ma non alcune funzioni. E\' caldamente raccomandato abilitare la libreria Curl.';

$lang['summary_success']	=	'Il tuo server soddisfa tutti i prerequisiti di PyroCMS per funzionare correttamente, vai al prossimo passo cliccando sul bottone sottostante.';
$lang['summary_partial']	=	'Il tuo server soddisfa <em>molti</em> dei prerequisiti di PyroCMS. Ciò significa che PyroCMS dovrebbe funzionare correttamente ma potresti avere problemi con funzioni come il ridimensionamento delle immagini o la creazione delle anteprime.';
$lang['summary_failure']	=	'Il tuo server non soddisfa tutti i prerequisiti di PyroCMS per funzionare correttamente. Contatta l\'amministratore del server o il tuo hosting provider per risolverli.';
$lang['next_step']		=	'Vai al passo successivo';
$lang['step3']			=	'Passo 3';
$lang['retry']			=	'Riprova';

// messages
$lang['step1_failure']	        =	'Inserisci le impostazioni del database richieste nel modulo sottostante.';

/* End of file step_2_lang.php */
/* Location: ./installer/language/italian/step_2_lang.php */