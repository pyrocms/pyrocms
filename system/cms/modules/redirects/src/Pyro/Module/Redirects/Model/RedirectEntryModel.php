<?php namespace Pyro\Module\Redirects\Model;

use Pyro\Module\Streams\Model\RedirectsRedirectsEntryModel;

/**
 * Redirect model
 *
 * @author      PyroCMS Dev Team
 * @package     PyroCMS\Core\Modules\Redirects\Models
 */
class RedirectEntryModel extends RedirectsRedirectsEntryModel
{
    /**
     * Find redirect by URI
     *
     * @param string $uri The URI of the redirect
     *
     * @return void
     */
    public static function findByUri($uri)
    {
        return static::where('from', '=', $uri)->first();
    }

    /**
     * Find redirect by From
     *
     * @param string $from The from of the redirect
     *
     * @return void
     */
    public static function findByFrom($from)
    {
        return static::where('from','=',$from)->first();
    }

    /**
     * Find redirect by From with ID
     *
     * @param string $from The from of the redirect
     * @param int    $id   of the redirect
     *
     * @return void
     */
    public static function findByFromAndId($from, $id = 0)
    {
        return static::where('id', '!=', $id)
                    ->where('from', '=', $from)->first();
    }
}
