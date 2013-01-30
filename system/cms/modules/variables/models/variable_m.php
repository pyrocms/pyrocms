<?php 
/**
 * Variable model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Variables\Models
 */

class Variable_m extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'variables';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Find variable by Name with ID
     *
     * @param string $name The name of the variable
     * @param int $id of the variable
     *
     * @return void
     */
    public static function findByNameWithId($name, $id = 0)
    {
        return self::where('id', '!=', $id)
                    ->where('name', '=', $name)->first();
    }
}

/* End of file variable_m.php */