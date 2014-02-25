<?php defined('BASEPATH') or exit('No direct script access allowed');

$lang['streams:field.name']							= 'Field';
$lang['streams:field.exceeded_limit']				= 'Exceeded character limit';
$lang['streams:field.param_default']				= 'Default';
$lang['streams:field.param_custom']					= 'Custom';
$lang['streams:field.must_add_field']				= 'First, you must add selectable fields';
$lang['streams:field.namespace_instructions']		= '<b>Selectable Fields Namespace</b><br>
                                                        * Default will be the same as the Stream namespace.';

$lang['streams:field.storage_instructions']			= '<b>Storage</b><br>
                                                        * Default - The selected field type and value will be saved for each entry.<br>
                                                        * Custom - The selected field type will be saved but the value will NOT be saved.
                                                          This allows developers to write their own pre save logic. See docs for more details.';
