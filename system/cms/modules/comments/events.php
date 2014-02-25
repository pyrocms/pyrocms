<?php

/**
 * Comments Events Class
 *
 * @package			CMS
 * @subpackage    	Comments Module
 * @category    	Events
 * @author        	Ryan Thompson - AI Web Systems, Inc.
 * @website       	http://aiwebsystems.com/
 */
class Events_Comments
{
    public function __construct()
    {
        // Clean up
        Events::register('module_uninstalled', array($this, 'remove_comments'));
        Events::register('module_disabled', array($this, 'remove_settings'));
    }

    /**
     *	Remove module comments
     *
     *	object $module
     *	return void
     */
    public function remove_comments($module)
    {
        ci()->pdb->table('comments')->where('module', '=', $module->slug)->delete();
    }
}
