<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| Textile
| -------------------------------------------------------------------
| This file contains the Textile editor button config
|
*/

$config['textile_buttons'] = array(
	"b"     => "javascript:insert_code('*', '*');return(false)",
	"i"     => "javascript:insert_code('_', '_');return(false)",
	"u"     => "javascript:insert_code('+', '+');return(false)",
	"code"  => "javascript:insert_code('@', '@');return(false)",
	"quote" => "javascript:insert_code('bq.  ', '');return(false)",
	"url"   => "javascript:insert_code('&quot;%display%&quot;:', '%url%', true);return(false)"
);


