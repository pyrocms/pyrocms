<?php

/**
 * PyroCMS Setting Model
 *
 * Allows for an easy interface for site settings
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Settings\Models
 */

class Setting_m extends CI_Model
{
    /**
     * Gets a single setting using the key.
     *
     * @param	mixed	$where
     * @return	object
     */
    public function get($key)
    {
        return $this->pdb
            ->table('settings')
            ->where('slug', '=', $key)
            ->first();
    }

    /**
     * Gets all settings
     *
     * @param	mixed  $where
     * @return	array  Settings with is_gui set to true
     */
    public function getAll()
    {
        return $this->pdb
            ->table('settings')
            ->orderBy('order', 'DESC')
            ->get();
    }

    /**
     * Gets all settings that should be visible in the settings GUI.
     *
     * @return	array  Settings with is_gui set to true
     */
    public function getGui()
    {
        return $this->pdb
            ->table('settings')
            ->where('is_gui', '=', 1)
            ->orderBy('order', 'DESC')
            ->get();
    }

    /**
     * Update
     *
     * Updates a setting for a given $key.
     *
     * @param	string	$key
     * @param	array	$params
     * @return	bool
     */
    public function update($key, array $params = array())
    {
        return $this->pdb
            ->table('settings')
            ->where('slug', '=', $key)
            ->update($params);
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
        $sections = $this->pdb
            ->table('module')
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

/* End of file setting_m.php */
