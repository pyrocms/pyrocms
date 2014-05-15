<?php namespace Pyro\Module\Addons;

use Pyro\Model\Eloquent;

/**
 * Widget Model
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.WidgetModel.html
 */
class WidgetModel extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'widgets';

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
     * Find By Slug
     *
     * @param  string $slug
     * @return WidgetModel
     */
    public function findBySlug($slug)
    {
        return $this
            ->where('slug', '=', $slug)
            ->take(1)
            ->first();
    }

    /**
     * Find Many In ID
     *
     * @param  array $ids
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function findManyInId(array $ids)
    {
        return $this
            ->orderBy('slug')
            ->whereIn('id', $ids)
            ->get();
    }

    /**
     * Find All Installed
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function findAllInstalled()
    {
        return $this->orderBy('slug')->get();
    }

    /**
     * Find All Enabled
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function findAllEnabledOrder()
    {
        return $this
            ->where('enabled', '=', true)
            ->orderBy('order')
            ->get();
    }

    /**
     * Enable
     *
     * Enabling allows the widget to be used.
     *
     * @return bool
     */
    public function enable()
    {
        $this->enabled = true;
        return $this->save();
    }

    /**
     * Disable
     *
     * Disabling stops the widget from being used.
     *
     * @return bool
     */
    public function disable()
    {
        $this->enabled = false;
        return $this->save();
    }

    /**
     * Set Name Attribute
     *
     * @return void
     */
    protected function setNameAttribute($value)
    {
        $this->attributes['name'] = serialize($value);
    }

    /**
     * Get Name Attribute
     *
     * @return array
     */
    protected function getNameAttribute($value)
    {
        $names = unserialize($value);

        if (is_string($names)) {
            return $names;
        }

        return ! isset($names[CURRENT_LANGUAGE]) ? $names['en'] : $names[CURRENT_LANGUAGE];
    }

    /**
     * Set Description Attribute
     *
     * @return void
     */
    protected function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = serialize($value);
    }

    /**
     * Get Description Attribute
     *
     * @return array
     */
    protected function getDescriptionAttribute($value)
    {
        $descriptions = unserialize($value);
        return ! isset($descriptions[CURRENT_LANGUAGE]) ? $descriptions['en'] : $descriptions[CURRENT_LANGUAGE];
    }
}
