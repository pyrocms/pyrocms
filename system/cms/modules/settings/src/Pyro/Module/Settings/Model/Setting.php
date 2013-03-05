<?php namespace Pyro\Module\Settings\Model;

/**
 * Settings model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Settings\Models 
 */
class Setting extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Gets a single setting using the key.
     *
     * @param   mixed   $where
     * @return  object
     */
    public function get($key)
    {
        return DB::table('settings')->where('slug',$key)->first();
    }

    /**
     * Gets all settings
     *
     * @param   mixed  $where
     * @return  array  Settings with is_gui set to true
     */
    public function getAll()
    {
        return DB::table('settings')->orderBy('order', 'DESC')->get();
    }

    /**
     * Gets all settings that should be visible in the settings GUI.
     *
     * @param   mixed  $where
     * @return  array  Settings with is_gui set to true
     */
    public function getGui($key)
    {
        return DB::table('settings')->where('slug', '=', $key)->where('is_gui', '=', 1)->orderBy('order', 'DESC')->get();
    }

    /**
     * Insert
     *
     * Insert a setting into the table.
     *
     * @param   array   $setting
     * @return  bool
     */
    public function insert(array $setting = array())
    {
        return DB::table('settings')->insert($setting);
    }

    /**
     * Update
     *
     * Updates a setting for a given $key.
     *
     * @param   string  $key
     * @param   array   $params
     * @return  bool
     */
    public function update($key, array $params = array())
    {
        return DB::table('settings')->where('slug', '=', $key)->update($params);
    }

    /**
     * Sections
     *
     * Gets all the sections (modules) from the settings table.
     *
     * @return  array
     */
    public function sections()
    {
        $sections = DB::table('module')->distinct()->where('module', '!=', "")->get();

        // Take just the module name
        #TODO rename to "section"
        return array_map(function ($section){
            return $section->module;
        }, $sections);
    }

}

/* End of file Setting.php */