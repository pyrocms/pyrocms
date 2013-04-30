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
	 * Enable
	 *
	 * Enabling allows the widget to be used.
	 *
	 * @return bool
	 */
	public function enable()
	{
		return $this->save(array(
        	'enabled' => true
		));
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
		return $this->save(array(
        	'enabled' => false
		));
	}

	/**
	 * Set Title Attribute
	 *
	 * @return void
	 */
	protected function setTitleAttribute($value)
	{
		$this->attributes['title'] = serialize($value);
	}

	/**
	 * Get Title Attribute
	 *
	 * @return array
	 */
	protected function getTitleAttribute($value)
	{
		return unserialize($value);
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
		return unserialize($value);
	}
}
