<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Amazon S3
$config['storage']['s3_access_key'] = Settings::get('files_s3_access_key');
$config['storage']['s3_secret_key'] = Settings::get('files_s3_secret_key');

// Rackspace Cloud Files 
$config['storage']['cf_username'] 	= Settings::get('files_cf_username');
$config['storage']['cf_api_key'] 	= Settings::get('files_cf_api_key');
$config['storage']['cf_auth_url'] 	= array('library' => '', 'method' => '');

/* End File */