<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Parser Enabled
|--------------------------------------------------------------------------
|
| Should the Parser library be used for the entire page?
|
| Can be overridden with $this->template->enable_parser(true/false);
|
|   Default: true
|
*/

$config['parser_enabled'] = true;

/*
|--------------------------------------------------------------------------
| Parser Enabled for Body
|--------------------------------------------------------------------------
|
| If the parser is enabled, do you want it to parse the body or not?
|
| Can be overridden with $this->template->enable_parser(true/false);
|
|   Default: false
|
*/

$config['parser_body_enabled'] = true;

/*
|--------------------------------------------------------------------------
| Title Separator
|--------------------------------------------------------------------------
|
| What string should be used to separate title segments sent via $this->template->title('Foo', 'Bar');
|
|   Default: ' | '
|
*/

$config['title_separator'] = ' | ';

/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
|
| Which theme to use by default?
|
| Can be overriden with $this->template->set_theme('foo');
|
|   Default: ''
|
*/

$config['theme'] = null;

/*
|--------------------------------------------------------------------------
| Theme
|--------------------------------------------------------------------------
|
| Where should we expect to see themes?
|
|	Default: array(APPPATH.'themes/')
|
*/

$config['theme_locations'] = array(
	APPPATH.'themes/',
	SHARED_ADDONPATH . 'themes/'
);

/*
|--------------------------------------------------------------------------
| Minify HTML output
|--------------------------------------------------------------------------
|
| You want try remove unnecessary white spaces before send the HTML to browser?
|
| Can be overridden with $this->template->enable_minify(true/false);
|
|   Default: false
|
*/

$config['minify_enabled'] = false;