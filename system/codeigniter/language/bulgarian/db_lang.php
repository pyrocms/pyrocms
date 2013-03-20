<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
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

$lang['db_invalid_connection_str'] 		= 'Невъзможно е да се определят настройките за БД от connection string-a, който сте въвели.';
$lang['db_unable_to_connect'] 			= 'Не може да се свърже с вашата база данни чрез посочените данни.';
$lang['db_unable_to_select'] 			= 'Не може да бъде изберете определена база данни: %s';
$lang['db_unable_to_create'] 			= 'Не може да бъде създадена посочената база данни: %s';
$lang['db_invalid_query'] 				= 'Подадената заявка не е валидна.';
$lang['db_must_set_table'] 				= 'Трябва да зададете на таблицата за да се използва с вашата заявка.';
$lang['db_must_use_set'] 				= 'Трябва да използвате "set" метод за актуализиране и влизане.';
$lang['db_must_use_index'] 				= 'Трябва да посочите съответен индекс за пакетно обновяване..';
$lang['db_batch_missing_index'] 		= 'Един или повече редове, представени за актуализиране на пакетното обновяване са с липсващ индекс.';
$lang['db_must_use_where'] 				= 'Актуализации не са позволени, освен ако не съдържат "WHERE" клауза.';
$lang['db_del_must_use_where'] 			= 'Изтриването не е позволено, освен ако не съдържа  "where" или "like" клауза.';
$lang['db_field_param_missing'] 		= 'При изтеглянето на полета се изисква името на таблицата като параметър.';
$lang['db_unsupported_function'] 		= 'Тази функция не е достъпна за базата данни, която използвате.';
$lang['db_transaction_failure'] 		= 'Грешка в транзакция: Връщане на предишното състояние.';
$lang['db_unable_to_drop'] 				= 'Не може да се изтрие специфичната база данни.';
$lang['db_unsuported_feature'] 			= 'Тази функция не се поддържа от Вашата база данни.';
$lang['db_unsuported_compression'] 		= 'Формата за компресиране който сте избрали, не се поддържа от вашия сървър.';
$lang['db_filepath_error'] 				= 'Не е възможно записването на данни в пътя на файла, който сте подали.';
$lang['db_invalid_cache_path'] 			= 'Пътят до кеш папката, който сте описали не е правилен или без права.';
$lang['db_table_name_required'] 		= 'Името на таблицата е задължително за тази операция.';
$lang['db_column_name_required'] 		= 'Името на колоната е задължително за тази операция.';
$lang['db_column_definition_required']	= 'Определянето на колона е задължително за тази операция.';
$lang['db_unable_to_set_charset'] 		= 'Не може да настрои клиента с правилен енкодинг: %s';
$lang['db_error_heading'] 				= 'Възникна грешка в базата данни';

/* End of file db_lang.php */
/* Location: ./system/language/bulgarian/db_lang.php */