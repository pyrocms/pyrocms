<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Contact\Models
 */
class Contact_m extends \Illuminate\Database\Eloquent\Model 
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'contact_log';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;
	
}

/* End of file contact_m.php */