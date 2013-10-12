<?php namespace Pyro\Module\Search\Model;

use Pyro\Model\Eloquent;
use Pyro\Model\Collection;

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
          *     'blog/'.date('Y/m/', $post->created_on).$post->slug,
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
	public static function index($module, $singular, $plural, $entry_id, $title, $description = null, $keywords = null, $uri = null, $cp_edit_uri = null, $cp_delete_uri = null, $group_access = null, $user_access = null){
		
		ci()->load->library('keywords/keywords');

		// Drop it so we can create a new index
		static::drop_index($module, $singular, $entry_id);


		// Get started
		$insert_data = array();


		// Hand over keywords without needing to look them up
		if ( ! empty($keywords)) {
			if (is_array($keywords)) {
				$insert_data['keywords'] = impode(',', $keywords);
			} elseif (is_string($keywords)) {
				$insert_data['keywords'] = ci()->keywords->get_string($keywords);
				$insert_data['keywords_hash'] = $keywords;
			}
		}


		$insert_data['title'] 			= $title;
		$insert_data['description'] 	= strip_tags($description);

		$insert_data['module'] 			= $module;
		$insert_data['entry_key'] 		= $singular;
		$insert_data['entry_plural'] 	= $plural;
		$insert_data['entry_id'] 		= $entry_id;
		$insert_data['uri'] 			= $uri;

		$insert_data['cp_edit_uri'] 	= $cp_edit_uri;
		$insert_data['cp_delete_uri'] 	= $cp_delete_uri;

		$insert_data['group_access']	= $uri;
		$insert_data['user_access']		= $uri;

		return static::insertGetId($insert_data);
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
	public static function drop_index($module, $singular, $entry_id){
		return static::where('module', '=', $module)
			->where('entry_key', '=', $singular)
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
	public static function filter($filter){
		
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
		$results = static::select('title', 'description', 'keywords', 'module', 'entry_key', 'entry_plural', 'uri', 'cp_edit_uri');


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
