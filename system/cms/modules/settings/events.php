<?php

/**
 * Settings Events Class
 *
 * @package			CMS
 * @subpackage    	Settings Module
 * @category    	Events
 * @author        	Ryan Thompson - AI Web Systems, Inc.
 * @website       	http://aiwebsystems.com/
 */
class Events_Settings
{
    public function __construct()
    {
        // Clean up
        Events::register('module_uninstalled', array($this, 'remove_settings'));
        Events::register('module_disabled', array($this, 'remove_settings'));
    }

    /**
     *	Remove module settings
     *
     *	object $module
     *	return void
     */
    public function remove_settings($module)
    {
        ci()->pdb->table('settings')->where('module', '=', $module->slug)->delete();
    }
}
