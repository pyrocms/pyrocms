<?php

// Provision for the installer
if ( ! defined('UPLOAD_PATH')) define('UPLOAD_PATH', null);

$config['files:path'] = UPLOAD_PATH.'files/';

$config['files:image_cache_path'] = APPPATH . 'cache/' . SITE_REF . '/image_files/';

$config['files:encrypt_filename'] = true;

$config['files:allowed_file_ext'] = array(
    'a'	=> array('mpga', 'mp2', 'mp3', 'ra', 'rv', 'wav'),
	'v'	=> array('mpeg', 'mpg', 'mpe', 'mp4', 'flv', 'qt', 'mov', 'avi', 'movie', 'ogv', 'webm'),
	'd'	=> array('pdf', 'xls', 'ppt', 'pptx', 'txt', 'text', 'log', 'rtx', 'rtf', 'xml', 'xsl', 'doc', 'docx', 'xlsx', 'word', 'xl', 'csv', 'pages', 'numbers'),
	'i'	=> array('bmp', 'gif', 'jpeg', 'jpg', 'jpe', 'png', 'tiff', 'tif'),
	'o'	=> array('psd', 'gtar', 'swf', 'tar', 'tgz', 'xhtml', 'zip', 'css', 'html', 'htm', 'shtml', 'svg'),
);
