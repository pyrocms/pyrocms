<?php namespace Pyro\Module\Addons;

use Pyro\Model;

/**
 * Theme Model
 *
 * @package     PyroCMS\Core\Addons
 * @author      PyroCMS Dev Team
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 * @link        http://docs.pyrocms.com/2.3/api/classes/Pyro.Module.Addons.ThemeModel.html
 */
class ThemeModel extends Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'themes';

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
}