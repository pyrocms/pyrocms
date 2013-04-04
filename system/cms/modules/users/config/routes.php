<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Admin Routes
$route['users/admin/fields(/:any)?']    = 'admin_fields$1';
$route['users/admin/groups(/:any)?']    = 'admin_groups$1';
