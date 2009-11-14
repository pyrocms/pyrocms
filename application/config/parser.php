<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// The directory where compiled templates are located
$config['parser_compile_dir']   = APPPATH.'cache/dwoo/compiled/';

//This tells Dwoo whether or not to cache the output of the templates to the $cache_dir.
$config['parser_cache_dir']     = APPPATH.'cache/dwoo/';
$config['parser_cache_time']    = 0; // 0 = off
