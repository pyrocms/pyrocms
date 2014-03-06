<?php namespace Pyro\Module\Templates\Model;

use Pyro\Model\Eloquent;

/**
 * Email Template model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Templates\Models
 */
class EmailTemplate extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'email_templates';

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
        $templates = static::where('slug', '=', $slug)->get();
        
        $data = array();
        foreach ($templates as $template) {
            $data[$template->lang] = $template;
        }

        return $data;
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

    /**
     * Find email template by slug and language
     *
     * @param string $slug The slug of the email template
	 * @param string $language The language of the email template
     *
     * @return void
     */
    public static function findBySlugAndLanguage($slug, $language)
    {
        $tpl = static::where('slug', '=', $slug)
			->where('lang', '=', $language)
        	->first();

		return (null != $tpl)
			? $tpl
			: static::where('slug', '=', $slug)
				->where('lang', '=', 'en')
	        	->first();
    }
}
