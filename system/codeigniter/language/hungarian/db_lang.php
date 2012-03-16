<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Open Software License version 3.0
 * 
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

$lang['db_invalid_connection_str'] 		= 'A megadott karaterláncből nem sikerült megállapítani az adatbázis beállításait';
$lang['db_unable_to_connect'] 			= 'Nem sikerült az adatbázishoz kapcsolódni a megadott beállításokkal.';
$lang['db_unable_to_select']			= 'A megadott adatbázis kiválasztása sikertelen: %s';
$lang['db_unable_to_create']			= 'A megadott adatbázis létrehozása sikertelen: %s';
$lang['db_invalid_query']			= 'A megadott lekérdezés nem érvényes.';
$lang['db_must_set_table']			= 'Az adatbázis táblát létre kell hozni a lekérdezés futtatásához.';
$lang['db_must_use_set']			= 'A "set" eljárást kell használni egy bejegyzés frissítéséhez.';
$lang['db_must_use_index'] 			= 'You must specify an index to match on for batch updates.';
$lang['db_batch_missing_index'] 		= 'One or more rows submitted for batch updating is missing the specified index.';
$lang['db_must_use_where']			= 'A frissítés csak "where" megadásával használható.';
$lang['db_del_must_use_where'] 			= 'A törlés csak "where" vagy "like" megadásával használható.';
$lang['db_field_param_missing'] 		= 'A mezők megragadása csak a tábla nevének magadásával lehetséges.';
$lang['db_unsupported_function']		= 'Ez a szolgáltatás nem elérhető a megadott adatbázishoz.';
$lang['db_transaction_failure'] 		= 'Tranzakciós hiba: Visszaállítás [Rollback] megtörtént.';
$lang['db_unable_to_drop'] 			= 'A megadott táblák eldobása sikertelen.';
$lang['db_unsuported_feature'] 			= 'A használt adatbázison nem elérhető szolgáltatás.';
$lang['db_unsuported_compression'] 		= 'A választott fájl tömörítési eljárást nem támogatja a szerver.';
$lang['db_filepath_error'] 			= 'Nem sikerült adatot írni a megadott elérési útba.';
$lang['db_invalid_cache_path'] 			= 'A megadott gyorsítótár könyvtár érvénytelen vagy nem írható.';
$lang['db_table_name_required'] 		= 'Ehhez a művelethez egy táblanév megadása kötelező.';
$lang['db_column_name_required'] 		= 'Ehhez a művelethez egy oszlopnév megadása kötelező.';
$lang['db_column_definition_required']          = 'Ehhez a művelethez egy oszlopspecifikáció megadása kötelező.';
$lang['db_unable_to_set_charset'] 		= 'Nem sikerült az adatbázis kapcsolat karakterkészletét beállítani: %s';
$lang['db_error_heading'] 			= 'Adatbázis hiba!';

/* End of file db_lang.php */
/* Location: ./system/language/hungarian/db_lang.php */