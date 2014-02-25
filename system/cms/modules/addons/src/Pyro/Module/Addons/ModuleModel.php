<?php namespace Pyro\Module\Addons;

use Pyro\Model\Eloquent;

/**
 * Module Model
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.ModuleModel.html
 */
class ModuleModel extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'modules';

    /**
     * Cache minutes
     * @var int
     */
    public $cacheMinutes = 30;

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
    public $timestamps = true;

    /**
     * Find All
     *
     * Return module data for a specific module
     *
     * @param   string  $slug  The name of the module to load
     * @return  ModuleModel
     */
    public function findBySlug($slug)
    {
        return $this
            ->where('slug', '=', $slug)
            ->take(1)
            ->first();
    }

    /**
     * Find All Modules
     *
     * Return all known (installed) modules as ModuleModel objects
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Find With Filter
     *
     * Return an array of objects containing module related data
     *
     * @param   array   $params             The array containing the modules to load
     * @param   bool    $return_disabled    Whether to return disabled modules
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function findWithFilter($params = null, $return_disabled)
    {
        $modules = array();

        // For each param, filter key => val
        if (is_array($params)) {
            foreach ($params as $field => $value) {
                if (in_array($field, array('is_frontend', 'is_backend', 'menu', 'is_core'))) {
                    $this->where($field, '=', $value);
                }
            }
        }

        // Skip the disabled modules
        if ($return_disabled === false) {
            $this->where('enabled', true);
        }

        return $this->get();
    }

    /**
     * Module Exists
     *
     * Checks if a module exists
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function moduleExists($slug)
    {
        if (( ! $slug)) {
            return false;
        }

        if (is_numeric($slug)) {
            return false;
        }

        return 1 === $this
            ->where('slug', $slug)
            ->take(1)
            ->count();
    }

    /**
     * Module Enabled
     *
     * Checks if a module is enabled
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function moduleEnabled($slug)
    {
        if (( ! $slug)) {
            return false;
        }

        return 1 === $this
            ->where('slug', $slug)
            ->where('enabled', true)
            ->take(1)
            ->count();
    }

    /**
     * Module Installed
     *
     * Checks if a module is installed
     *
     * @param   string  $slug   The module slug
     * @return  bool
     */
    public function moduleInstalled($slug)
    {
        if (( ! $slug)) {
            return false;
        }

        return 1 === $this
            ->where('slug', $slug)
            ->where('installed', true)
            ->take(1)
            ->count();
    }

    /**
     * Disable
     *
     * @return  bool
     */
    public function disable()
    {
        $this->enabled = false;
        return $this->save();
    }

    /**
     * Enable
     *
     * @return  bool
     */
    public function enable()
    {
        $this->enabled = true;
        return $this->save();
    }

    /**
     * Is Core
     *
     * @return  bool
     */
    public function isCore()
    {
        return (bool) $this->is_core;
    }

    /**
     * Is Backend
     *
     * @return  bool
     */
    public function isBackend()
    {
        return (bool) $this->is_backend;
    }

    /**
     * Is Enabled
     *
     * @return  bool
     */
    public function isEnabled()
    {
        return (bool) $this->enabled;
    }

    /**
     * Is Backend
     *
     * @return  bool
     */
    public function isFrontend()
    {
        return (bool) $this->is_frontend;
    }

    /**
     * Is Installed
     *
     * @return  bool
     */
    public function isInstalled()
    {
        return (bool) $this->installed;
    }

    // Accessors and Mutators ----

    /**
     * Is Installed
     *
     * @return  bool
     */
    public function getNameAttribute()
    {
        $names = unserialize($this->attributes['name']);
        return ! isset($names[CURRENT_LANGUAGE]) ? $names['en'] : $names[CURRENT_LANGUAGE];
    }

    /**
     * Is Installed
     *
     * @return  bool
     */
    public function getDescriptionAttribute()
    {
        $desc = unserialize($this->attributes['description']);
        return ! isset($desc[CURRENT_LANGUAGE]) ? $desc['en'] : $desc[CURRENT_LANGUAGE];
    }
}
