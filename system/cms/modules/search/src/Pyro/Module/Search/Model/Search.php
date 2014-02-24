<?php namespace Pyro\Module\Search\Model;

use Pyro\Module\Addons\ModuleModel;
use Pyro\Model\Eloquent;
use Pyro\Module\Search\Model\Exception\SearchPluralAttributeNotSetException;
use Pyro\Module\Search\Model\Exception\SearchSingularAttributeNotSetException;
use Pyro\Module\Search\Model\Exception\SearchTitleAttributeNotSetException;
use Pyro\Module\Streams\Entry\EntryModel;

/**
 * Search Index model
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Search\Models
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
class Search extends Eloquent
{
    /**
     * Define the table name
     *
     * @var string
     */
    protected $table = 'search_index';

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
    protected $guarded = array('id');

    /**
     * Disable updated_at and created_at on table
     *
     * @var boolean
     */
    public $timestamps = false;


    /**
     * Index
     *
     * Store an entry in the search index.
     *
     * <code>
     * Search::index(
     *     'blog',
     *     'blog:post',
     *     'blog:posts',
     *     $id,
     *     $post->title,
     *     $post->intro,
     *     'keywords'       => $post->keywords,
          *     'blog/'.date('Y/m/', $post->created_at).$post->slug,
     *     'cp_edit_uri'    => 'admin/blog/edit/'.$id,
     *     'cp_delete_uri'  => 'admin/blog/delete/'.$id,
     *     'group_access'	=> json_encode($ids),
     *     'user_access'	=> json_encode($ids),
     *     );
     * </code>
     *
     * @param	string	$module		The module that owns this entry
     * @param	string	$singular	The unique singular language key for this piece of data
     * @param	string	$plural		The unique plural language key that describes many pieces of this data
     * @param	int 	$entry_id	The id for this entry
     * @param	string 	$uri		The relative uri to installation root
     * @param	string 	$title		Title or Name of this entry
     * @param	string 	$description Description of this entry
     * @param	array 	$options	Options such as keywords (array or string - hash of keywords) and cp_edit_uri/cp_delete_uri
     * @return	array
     */
    public static function index($module, $scope, $singular, $plural, $entry_id, $title, $description = null, $keywords = null, $uri = null, $cp_uri = null, $group_access = null, $user_access = null)
    {
        ci()->load->library('keywords/keywords');

        // Drop it so we can create a new index
        static::dropIndex($module, $scope, $entry_id);


        // Get started
        $insert_data = array();

        // Hand over keywords without needing to look them up
        if ( ! empty($keywords)) {
            if (is_array($keywords)) {
                $insert_data['keywords'] = implode(',', $keywords);
            } elseif (is_string($keywords)) {
                $insert_data['keywords'] = ci()->keywords->get_string($keywords);
                $insert_data['keywords_hash'] = $keywords;
            }
        }

        $insert_data['module'] 			= $module;
        $insert_data['scope'] 			= $scope;
        $insert_data['entry_singular'] 	= $singular;
        $insert_data['entry_plural'] 	= $plural;
        $insert_data['entry_id'] 		= $entry_id;
        $insert_data['title'] 			= $title;
        $insert_data['description'] 	= strip_tags($description);
        $insert_data['uri'] 			= $uri;
        $insert_data['cp_uri'] 			= $cp_uri;
        $insert_data['group_access']	= $group_access;
        $insert_data['user_access']		= $user_access;

        return static::insertGetId($insert_data);
    }

    public static function indexEntry(EntryModel $entry, $index_template = array())
    {
        if ( ! empty($index_template)) {
            $attributes = array(
                'module',
                'scope',
                'singular',
                'plural',
                'title',
                'description',
                'keywords',
                'uri',
                'cp_uri',
                'group_access',
                'user_access'
            );

            // Set null values for undefined keys
            foreach ($attributes as $key) {
                $index_template[$key] = isset($index_template[$key])? $index_template[$key] : null;
            }

            // Try to guess the module slug or set the namespace as the module sl
            $default_module = ($slug = $entry->getModuleSlug()) ? $slug : $entry->getStream()->stream_namespace;

            // Set the stream_namespace as the module if it was not passed
            $index_template['module'] = isset($index_template['module']) ? $index_template['module'] : $default_module;

            // If a scope was not passed, autogenerate one from the stream
            $index_template['scope'] = isset($index_template['scope']) ? $index_template['scope'] : $entry->getStreamTypeSlug();

            if ( ! $index_template['title']) {
                throw new SearchTitleAttributeNotSetException;
            }

            if ( ! $index_template['singular']) {
                throw new SearchSingularAttributeNotSetException;
            }

            if ( ! $index_template['plural']) {
                throw new SearchPluralAttributeNotSetException;
            }

            return static::index(
                $index_template['module'],
                $index_template['scope'],
                $index_template['singular'],
                $index_template['plural'],
                $entry->getKey(),
                ci()->parser->parse_string($index_template['title'], array('entry' => $entry->toArray(), 'post' => $_POST), true),
                ci()->parser->parse_string($index_template['description'], array('entry' => $entry->toArray(), 'post' => $_POST), true),
                ci()->parser->parse_string($index_template['keywords'], array('entry' => $entry->toArray(), 'post' => $_POST), true),
                ci()->parser->parse_string($index_template['uri'], array('entry' => $entry->toArray(), 'post' => $_POST), true),
                ci()->parser->parse_string($index_template['cp_uri'], array('entry' => $entry->toArray(), 'post' => $_POST), true),
                $index_template['group_access'],
                $index_template['user_access']
            );
        }
        return false;
    }

    /**
     * Drop index
     *
     * Delete an index for an entry
     *
     * <code>
     * Search::drop_index('blog', 'blog:post', $id);
     * </code>
     *
     * @param	string	$module		The module that owns this entry
     * @param	string	$singular	The unique singular "key" for this piece of data
     * @param	int 	$entry_id	The id for this entry
     * @return	array
     */
    public static function dropIndex($module, $scope, $entry_id)
    {
        return static::where('module', '=', $module)
            ->where('scope', '=', $scope)
            ->where('entry_id', '=', $entry_id)
            ->delete();
    }

    /**
     * Filter
     *
     * Breaks down a search result by module and entity
     *
     * @param	array	$filter	Modules will be the key and the values are entity_plural (string or array)
     * @return	array
     */
    public static function filter($filter)
    {
        // Filter Logic
        if (! $filter){
            return $this;
        }

        static::orwhere(function($mainQuery){
            foreach ($filter as $module => $plural){
                $mainQuery->orwhere(function($subQuery){
                    $subQuery->where('module', '=', $module);
                    $subQuery->whereIn('entry_plural', (array) $plural);
                });
            }
        });

        return $this;
    }

    /**
     * Search
     *
     * Delete an index for an entry
     *
     * @param	string	$query	Query or terms to search for
     * @return	array
     */
    public static function getResults($terms)
    {
        // Go!
        $results = static::select('title', 'description', 'keywords', 'module', 'scope', 'entry_singular', 'entry_plural', 'uri', 'cp_uri');


        /**
         * Limit scope: module:
         */
        $scope = false;

        foreach ($terms as $k => $term) {
            if (substr($term, '-1') == ':') {
                $results->where('module', '=', substr($term, 0, -1));
                unset($terms[$k]);
                break;
            }
        }


        /**
         * Now process all the terms
         */
        foreach ($terms as $term) {

            if (substr($term, 0, 1) == '-') {

                /**
                 * Exlclude entries: -term
                 */
                $results->where(function ($query) use ($term) {
                    $query->where('title', 'NOT LIKE', '%'.substr($term, 1).'%');
                    $query->where('description', 'NOT LIKE', '%'.substr($term, 1).'%');
                });
            } elseif (substr($term, 0, 1) == '#') {

                /**
                 * Exlclude keywords: #keyword
                 */
                $results->where(function ($query) use ($term) {
                    $query->where('keywords', 'LIKE', '%'.substr($term, 1).'%');
                });
            } else {

                /**
                 * Normal: term
                 */
                $results->where(function ($query) use ($term) {
                    $query->where('title', 'LIKE', '%'.$term.'%');
                    $query->orWhere('description', 'LIKE', '%'.$term.'%');
                });
            }
        }

        // Limit to results I have access for
        if (! ci()->current_user->isAdmin()) {
            $results->where(function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('user_access');
                    $q->orWhere('user_access', 'LIKE', '%"'.ci()->current_user->id.'"%');
                });
            });
        }

        return $results->take(10)->get();
    }
}
