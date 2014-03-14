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
 * @copyright	Copyright (c) 2008 - 2013, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['db_invalid_connection_str']      = 'មិនអាចកំណត់លក្ខណៈប្រព័ន្ធផ្ទុកទិន្នន័យដោយផ្អែកទៅលើ Connection string ។';
$lang['db_unable_to_connect']           = 'មិនអាចភ្ជាប់ទៅកាន់ប្រព័ន្ធផ្ទុកទិន្នន័យបានទេ។';
$lang['db_unable_to_select']            = 'មិនអាចជ្រើសរើសប្រព័ន្ធផ្ទុកទិន្នន័យ %s នេះបានទេ។';
$lang['db_unable_to_create']            = 'មិនអាចបង្កើតប្រព័ន្ធផ្ទុកទិន្នន័យ %s នេះបានទេ។';
$lang['db_invalid_query']               = 'ការទាញយកទិន្នន័យមិនត្រឹមត្រូវទេ។';
$lang['db_must_set_table']              = 'អ្នកត្រូវតែកំណត់តារាងប្រព័ន្ធផ្ទុកទិន្នន័យដើម្បីប្រើប្រាស់ក្នុងការទាញយកទិន្នន័យ។';
$lang['db_must_use_set']                = 'អ្នកត្រូវតែប្រើវិធី​សាស្រ្ត​ "set" ដើម្បីកែសម្រួលទិន្នន័យ។';
$lang['db_must_use_index']              = 'អ្នកត្រូវតែបញ្ជាក់ index ណាមួយឲ្យបានច្បាស់លាស់​ដើម្បីអេាយត្រូវនឹងប្រតិបត្តិការកែសម្រួលជាបណ្តុំ។';
$lang['db_batch_missing_index']         = 'ជួរដេក(row) មួយឬច្រើនដែលបានស្នើរការកែសម្រួលជាបណ្តុំបានបាត់បង់​the specified index។';
$lang['db_must_use_where']              = 'ប្រតិបត្តិការកែសម្រួលមិនអនុញ្ញាត ​លើកលែតែមានលក្ខ័ណ where';
$lang['db_del_must_use_where']          = 'ប្រតិបត្តិការលប់មិនអនុញ្ញាត ​លើកលែតែមានលក្ខ័ណ where ឬ like។';
$lang['db_field_param_missing']         = 'ដើម្បីទាញយក​ fields តម្រូវឲ្យមានឈ្មេាះតារាងដូចទៅនឹងប៉ារ៉ាម៉ែត្រ។';
$lang['db_unsupported_function']        = 'លក្ខណៈពិសេសនេះមិនអាចប្រតិបត្តិការជាមួយប្រព័ន្ធផ្ទុកទិន្នន័យរបស់អ្នកបានទេ។';
$lang['db_transaction_failure']         = 'ប្រតិបត្តិការបរាជ័យ : អនុវត្តប្រតិបត្តិការឡើងវិញ។';
$lang['db_unable_to_drop']              = 'ប្រព័ន្ធផ្ទុកទិន្នន័យនេះមិនអាចលុបបានទេ។';
$lang['db_unsupported_feature']         = 'លក្ខណៈពិសេសរបស់ប្រព័ន្ធផ្ទុកទិន្នន័យនេះមិនត្រឹមត្រូវទេ។';
$lang['db_unsupported_compression']     = 'ទំរង់ File compression នេះមិនត្រឹមត្រូវទេ។';
$lang['db_filepath_error']              = 'File path មិនអាចកែសម្រួលបាន។';
$lang['db_invalid_cache_path']          = 'ទីតាំង cache មិនត្រឹមត្រូវ​ ឬមិនអាចកែសម្រួលបាន។';
$lang['db_table_name_required']         = 'ឈ្មេាះតារាង (table name) តម្រូវឲ្យមានសំរាប់ប្រតិបត្តិការនេះ។';
$lang['db_column_name_required']        = 'ឈ្មេាះជួរឈរ (column name) តម្រូវឲ្យមានសំរាប់ប្រតិបត្តិការនេះ។';
$lang['db_column_definition_required']  = 'និយមន័យជួរឈរ (column definition) តម្រូវឲ្យមានប្រតិបត្តិការ​ សំរាប់ប្រតិបត្តិការនេះ។';
$lang['db_unable_to_set_charset']       = 'មិនអាចកំណត់តួអក្សអ្នកប្រើប្រាស់​: %s';
$lang['db_error_heading']               = 'ប្រព័ន្ធផ្ទុកទិន្នន័យមានបញ្ហា។';

/* End of file db_lang.php */
/* Location: ./system/language/english/db_lang.php */