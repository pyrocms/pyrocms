<?php

use Pyro\Module\Keywords\Model\Keyword as KeywordModel;
use Pyro\Module\Keywords\Model\Applied as AppliedModel;

/**
 * Keywords Library
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Keywords\Libraries
 */

class Keywords
{
    /**
     * Get keywords
     *
     * Gets all the keywords as a comma-delimited string
     *
     * @param  string $hash The unique hash stored for a entry
     * @return string
     */
    public static function get_string($hash)
    {
        $keywords = array();

        // @todo - This needs refactoring
        return null;

        foreach (AppliedModel::getNamesByHash($hash) as $keyword) {
            $keywords[] = $keyword->name;
        }

        return implode(', ', $keywords);
    }

    /**
     * Get keywords
     *
     * Gets just the keywords, no other data
     *
     * @param  string $hash The unique hash stored for a entry
     * @return array
     */
    public static function get_array($hash)
    {
        $keywords = array();

        // @todo - This needs refactoring
        return array();

        foreach (Applied::getNamesByHash($hash) as $keyword) {
            $keywords[] = $keyword->name;
        }

        return $keywords;
    }

    /**
     * Get full array of keywords
     *
     * Returns keywords with all data
     *
     * @param  string $hash The unique hash stored for a entry
     * @return array
     */
    public static function get($hash)
    {
        return AppliedModel::getNamesByHash($hash);
    }

    /**
     * Add Keyword
     *
     * Adds a new keyword to the database
     *
     * @param  array $keyword
     * @return int
     */
    public static function add($keyword)
    {
        return KeywordModel::add(static::prep($keyword));
    }

    /**
     * Prepare Keyword
     *
     * Gets a keyword ready to be saved
     *
     * @param  string $keyword
     * @return string
     */
    public static function prep($keyword)
    {
        if (function_exists('mb_strtolower')) {
            return mb_strtolower(trim($keyword));
        }

        return strtolower(trim($keyword));
    }

    /**
     * Process Keywords
     *
     * Process a posted list of keywords into the db
     *
     * @param string $keywords  String containing unprocessed list of keywords
     * @param string $model     @TODO
     *
     * @return string
     */
    public static function process($keywords, $model)
    {
        // No keywords? Let's not bother then
        if (! ($keywords = trim($keywords))) {
            return '';
        }

        $assignmenHash = md5(microtime().mt_rand());

        AppliedModel::deleteByEntryIdAndEntryType($model->getKey(), get_class($model));

        // Split em up and prep away
        $keywords = explode(',', $keywords);

        foreach ($keywords as &$keyword) {
            $keyword = self::prep($keyword);

            // Keyword already exists
            if (! ($row = KeywordModel::findByName($keyword))) {
                $row = static::add($keyword);
            }

            $model->keywords()->save($row);
        }

        return $assignmenHash;
    }
}
