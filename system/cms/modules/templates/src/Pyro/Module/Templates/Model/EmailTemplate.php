<?php namespace Pyro\Module\Templates\Model;

/**
 * Email Template model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Templates\Models 
 */
class EmailTemplate extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'email_templates';

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Find email template by slug
     *
     * @param string $slug The slug of the email template
     *
     * @return void
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', '=', $slug)->get();
    }

    /**
     * Find email template by is_default
     *
     * @param bool $default 
     *
     * @return void
     */
    public static function findByIsDefault($default)
    {
        return static::where('is_default', '=', $default)->get();
    }
}