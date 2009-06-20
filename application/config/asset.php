<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Asset Directory
|--------------------------------------------------------------------------
|
| Absolute path from the webroot to your CodeIgniter root. Typically this will be your APPPATH,
| WITH a trailing slash:
|
|	/assets/
|
*/

// This crazy line means it will use the app path whether its in the web root or not
// Feel free to change this to something more normal lookin!
$config['asset_dir'] = parse_url(config_item('base_url'), PHP_URL_PATH).APPPATH;

/*
|--------------------------------------------------------------------------
| Asset URL
|--------------------------------------------------------------------------
|
| URL to your CodeIgniter root. Typically this will be your base URL,
| WITH a trailing slash:
|
|	/assets/
|
*/

// Right now its pointing to the same place as the base_url.
// You can move this to anywhere if you like
$config['asset_url'] = config_item('base_url').APPPATH;

/*
|--------------------------------------------------------------------------
| Asset Sub-folders
|--------------------------------------------------------------------------
|
| Names for the img, js and css folders. Can be renamed to anything
|
|	/assets/
|
*/
$config['asset_img_dir'] = 'img';
$config['asset_js_dir'] = 'js';
$config['asset_css_dir'] = 'css';

?>