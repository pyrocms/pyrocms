<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Passo 1: Configura Database e Server';
$lang['intro_text']		=	'Prima di verificare il database, abbiamo bisogno di sapere dov\' è e quali sono i parametri di accesso.';

$lang['db_settings']	=	'Impostazioni del Database';
$lang['db_text']		=	'Per verificare la versione del tuo server MySQL devi inserire hostname, username e password nel modulo sottostante. Questi parametri saranno inoltre usati per installare il database.';
$lang['db_missing']		=	'I driver PHP per il database MySQL non sono stati trovati, non è possibile continuare con l\'installazione. Chiedi all\'amminsitratore del tuo server o al tuo hosting di installarli.';

$lang['server']			=	'Server';
$lang['username']		=	'Username';
$lang['password']		=	'Password';
$lang['portnr']			=	'Porta';
$lang['server_settings']=	'Impostazioni Server';
$lang['httpserver']		=	'HTTP Server';
$lang['httpserver_text']=	'PyroCMS richiede un Server HTTP per mostrare il contenuto dinamico quando un utente visita il tuo sito. Sembra che ne possiedi già uno, infatti puoi vedere questa pagina, ma se sai esattamente quale PyroCMS  puà configurarsi automaticamente al meglio. Se non sai quale è o non sai cosa tutto questo vuol dire ignora semplicemente il messaggio e vai avanti con l\'installazione.';
$lang['rewrite_fail']	=	'Hai selezionato "(Apache con mod_rewrite)" ma non siamo in grado di assicurarti che il mod_rewrite sia abilitato sul tuo server. Prova a chiedere al tuo hosting se il mod_rewrite è abilitato o prova ad installarlo a tuo rischio.';
$lang['mod_rewrite']	=	'Hai selezionato "(Apache con mod_rewrite)" ma il tuo server non ha il modulo abilitato. Chiedi al tuo hosting di abilitarlo o installa PyroCMS utilizzando l\'opzione "(Apache senza mod_rewrite)".';
$lang['step2']			=	'Passo 2';

// messages
$lang['db_success']		=	'Le impostazioni del database sono state testate e funzionano correttamente.';
$lang['db_failure']		=	'Problemi di connessione al database: ';
