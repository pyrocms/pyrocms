<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']			=	'Krok 2: Kontrola požadavků';
$lang['intro_text']		= 	'Druhým krokem je kontrola, zda váš server podporuje PyroCMS. Na většině serverů by měl být PyroCMS schopen běžet.';
$lang['mandatory']		= 	'Povinné';
$lang['recommended']	= 	'Doporučené';

$lang['server_settings']= 	'Nastavení HTTP serveru';
$lang['server_version']	=	'Váš server:';
$lang['server_fail']	=	'Váš server není podporován, takže je možné, že PyroCMS nebude pracovat správně. Pokud je ale vaše instalace PHP a MySQL aktuální, PyroCMS by měl běžet v pořádku, pouze bez pěkných URL adres.';

$lang['php_settings']	=	'Nastavení PHP';
$lang['php_required']	=	'PyroCMS potřebuje PHP ve verzi %s nebo vyšší.';
$lang['php_version']	=	'Na vašem serveru je v tuto chvíli verze';
$lang['php_fail']		=	'Vaše verze PHP není podporována. PyroCMS potřebuje PHP ve verzi %s nebo vyšší, aby pracoval správně.';

$lang['mysql_settings']	=	'Nastavení MySQL';
$lang['mysql_required']	=	'PyroCMS požaduje databázi MySQL ve verzi 5.0 nebo vyšší.';
$lang['mysql_version1']	=	'Na vašem serveru je v tuto chvíli';
$lang['mysql_version2']	=	'Na klientu je v tuto chvíli';
$lang['mysql_fail']		=	'Vaše verze MySQL není podporována. PyroCMS potřebuje MySQL ve verzi 5.0 nebo vyšší, aby pracoval správně.';

$lang['gd_settings']	=	'Nastavení GD';
$lang['gd_required']	= 	'PyroCMS vyžaduje GD knihovnu ve verzi 1.0 nebo vyšší pro práci s obrázky.';
$lang['gd_version']		= 	'Na vašem serveru je v tuto chvíli verze';
$lang['gd_fail']		=	'Nedokážeme rozpoznat verzi GD knihovny. To obvykle znamená, že není nainstalována. PyroCMS poběží správně, ale některé obrázkové funkce nemusí fungovat. Doporučujeme povolit GD knihovnu.';

$lang['summary']		=	'Souhrn';

$lang['zlib']			=	'Zlib';
$lang['zlib_required']	= 	'PyroCMS vyžaduje Zlib pro rozbalování a instalaci vzhledů.';
$lang['zlib_fail']		=	'Zlib nejde nalézt. To obvykle znamená, že není nainstalována. PyroCMS poběží správně, ale instalace vzhledů nebude fungovat. Doporučujeme Zlib nainstalovat.';

$lang['curl']			=	'Curl';
$lang['curl_required']	=	'PyroCMS vyžaduje Curl pro navazování spojení s jinými weby.';
$lang['curl_fail']		=	'Curl nejde nalézt. To obvykle znamená, že není nainstalován. PyroCMS poběží správně, ale některé funkce nemusí fungovat. Doporučujeme povolit Curl.';

$lang['summary_success']	=	'Váš server vyhovuje všem požadavkům pro PyroCMS. Pokračujte na další krok kliknutím na tlačítko níže.';
$lang['summary_partial']	=	'Váš server vyhovuje <em>většině</em> požadavků pro PyroCMS. To znamená, že že PyroCMS by mělo běžet v pořádku, ale je tu šance, že nastanou problémy s věcmi jako zmenšování obrázků či vytváření jejich náhledů.';
$lang['summary_failure']	=	'Vypadá to, že váš server nevyhovuje požadavkům pro PyroCMS. Kontaktujte prosím vašeho administrátora serveru nebo hostingovou společnost pro řešení.';
$lang['next_step']		=	'Pokračujte na dalšíkrok';
$lang['step3']			=	'Krok 3';
$lang['retry']			=	'Zkusit znovu';

// messages
$lang['step1_failure']	=	'Prosím vyplňte požadovaná pole ve formuláři níže.';

/* End of file step_2_lang.php */
/* Location: ./installer/language/english/step_2_lang.php */