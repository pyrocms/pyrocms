<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pages Event Class
 *
 * Current functionality is to add chunks field type.
 * 
 * @package		Pages
 * @category	events
 * @author		PyroCMS - Adam Fairholm
 */
class Events_Pages {
    
    protected $CI;
 
  	// --------------------------------------------------------------------------
   
    public function __construct()
    {        
        Events::register('streams_core_add_addon_path', array($this, 'add_pages_ft_folder'));
    }
 
 	// --------------------------------------------------------------------------
   
    /**
     * Add pages field_types folder to the
     * field type folder list. 
     *
     * @access	public
     * @return	void
     */
    public function add_pages_ft_folder($type)
    {
        $type->add_ft_path('pages_ft_path', APPPATH.'modules/pages/field_types/');
    }

}