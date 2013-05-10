<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| A whitelist of functions that Lex can execute to modify variables
|--------------------------------------------------------------------------
*/

$config['allowed_functions']	=	array(
	'character_limiter',
	'count',
	'count_chars',
	'empty',
	'explode',
	'format_date',
	'html_entity_decode',
	'htmlentities',
	'htmlspecialchars',
	'htmlspecialchars_decode',
	'implode',
	'is_array',
	'is_int',
	'is_integer',
	'is_string',
	'isset',
	'ltrim',
	'md5',
	'money_format',
	'nl2br',
	'number_format',
	'preg_match',
	'preg_replace',
	'rtrim',
	'safe_mailto',
	'slugify',
	'sprintf',
	'str_replace',
	'str_word_count',
	'strip_tags',
	'strpos',
	'strtolower',
	'strtoupper',
	'substr',
	'trim',
	'ucfirst',
	'ucwords',
	'word_censor',
	'word_limiter',
	'word_wrap',
	'alternator'
	);

/* End of file parser.php */
