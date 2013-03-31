<?php namespace Pyro\Module\Variables\Model;

/**
 * Variable model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Variables\Models
 */
class Variable extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'variables';

    /**
     * The attributes that aren't mass assignable
     *
     * @var array
     */
    protected $guarded = array();

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
     * @param int    $id   of the variable
     *
     * @return void
     */
    public static function findByNameWithId($name, $id = 0)
    {
        return static::where('id', '!=', $id)
                    ->where('name', '=', $name)->first();
    }
}

/* End of file variable_m.php */
