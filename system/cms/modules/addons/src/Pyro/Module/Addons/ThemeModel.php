<?php namespace Pyro\Module\Addons;

use Pyro\Model\Eloquent;

/**
 * Theme Model
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.ThemeModel.html
 */
class ThemeModel extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'themes';

    /**
     * Cache minutes
     *
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
    public $timestamps = false;

    /**
     * Relationship: Options
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany('Pyro\Module\Addons\ThemeOptionModel', 'theme_id');
    }

    public function getOptionValues()
    {
        $options = array();

        foreach ($this->options()->select('slug', 'default', 'value')->get() as $option) {
            $options[$option->slug] = is_null($option->value) ? $option->default : $option->value;
        }

        return $options;
    }

    /**
     * Find All
     * Return theme data for a specific theme
     *
     * @param   string $slug The name of the theme to load
     * @return  ThemeModel
     */
    public function findBySlug($slug)
    {
        return $this
            ->with('options')
            ->where('slug', '=', $slug)
            ->take(1)
            ->first();
    }

    /**
     * Find many themes by type
     * Return theme data for a specific theme
     *
     * @param   string $slug The name of the theme to load
     * @return  ThemeModel
     */
    public function findManyByType($type)
    {
        return $this
            ->with('options')
            ->where('type', '=', $type)
            ->get();
    }

    /**
     * Find non-admin themes
     * Return theme data for a specific theme
     *
     * @param   string $slug The name of the theme to load
     * @return  ThemeModel
     */
    public function findGeneralThemes()
    {
        return $this
            ->with('options')
            ->get();
    }

    /**
     * Find All Themes
     * Return all known (installed) themes as ThemeModel objects
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function findAll()
    {
        return $this->with('options')->get();
    }

    // In Scope

    /**
     * Reset Options
     * Go through each option and reset it to its default value
     *
     * @return  bool
     */
    public function resetOptions()
    {
        $options = new \Pyro\Module\Addons\ThemeOptionModel();
        $manager = new ThemeManager();

        $manager->setLocations(ci()->template->theme_locations());

        $theme = $manager->get($this->slug);

        $options->whereThemeId($this->id)->delete();

        foreach ($theme->options as $key => $option) {

            if(!isset($option['slug'])) {
                $option['slug'] = $key;
            }

            $options->insert(
                array(
                    'slug'        => $option['slug'],
                    'title'       => $option['title'],
                    'description' => isset($option['description']) ? $option['description'] : $option['description'],
                    'default'     => isset($option['default']) ? $option['default'] : '',
                    'value'       => isset($option['default']) ? $option['default'] : '',
                    'type'        => isset($option['type']) ? $option['type'] : 'text',
                    'options'     => isset($option['options']) ? $option['options'] : '',
                    'is_required' => isset($option['is_required']) ? $option['is_required'] : false,
                    'theme_id'    => $this->id,
                )
            );
        }
    }

}
