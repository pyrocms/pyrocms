<?php namespace Pyro\Module\Settings;

use Pyro\Model\Eloquent;

class SettingModel extends Eloquent
{
    /**
     * The table
     * @var string
     */
    protected $table = 'settings';

    public $timestamps = false;

    /**
     * Gets a single setting using the key.
     *
     * @param	mixed	$where
     * @return	object
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', '=', $slug)->first();
    }

    /**
     * Gets all settings
     *
     * @param	mixed  $where
     * @return	array  Settings with is_gui set to true
     */
    public function getAll(array $columns = array())
    {
        return $this->orderBy('order', 'DESC')
            ->get($columns);
    }

    /**
     * Gets all settings that should be visible in the settings GUI.
     *
     * @return	array  Settings with is_gui set to true
     */
    public function getGui()
    {
        return $this->where('is_gui', '=', 1)
            ->orderBy('order', 'DESC')
            ->get();
    }

    /**
     * Sections
     *
     * Gets all the sections (modules) from the settings table.
     *
     * @return	array
     */
    public function sections()
    {
        $sections = $this->table('module')
            ->distinct()
            ->where('module', '!=', "")
            ->get();

        // Take just the module name
        #TODO rename to "section"
        return array_map(function ($section){
            return $section->module;
        }, $sections);
    }
}
