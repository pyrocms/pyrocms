<?php namespace Pyro\Module\Templates\Model;

use Pyro\Module\Streams\Model\TemplatesTemplatesEntryModel;

/**
 * Email Template model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Templates\Models
 */
class TemplateEntryModel extends TemplatesTemplatesEntryModel
{
    /**
     * Presenter class
     *
     * @var string
     */
    protected $presenterClass = 'Pyro\Module\Templates\Presenter\TemplateEntryPresenter';

    /**
     * Collection class
     *
     * @var string
     */
    protected $collectionClass = 'Pyro\Module\Templates\Collection\TemplateEntryCollection';

    /**
     * Find email template by slug
     *
     * @param string $slug The slug of the email template
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
     * @return void
     */
    public static function findByIsDefault($default)
    {
        return static::where('is_default', '=', $default)->get();
    }

    /**
     * Find email template by slug and language
     *
     * @param string $slug     The slug of the email template
     * @param string $language The language of the email template
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
