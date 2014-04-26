<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Search Index model
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Search\Models
 * @copyright   Copyright (c) 2012, PyroCMS LLC
 */
class Search_index_m extends MY_Model
{
	/**
	 * Index
	 *
	 * Store an entry in the search index.
	 * 
	 * <code>
	 * $this->search_index_m->index(
     *     'blog',
     *     'blog:post',
     *     'blog:posts',
     *     $id,
     *     'blog/'.date('Y/m/', $post->created_on).$post->slug,
     *     $post->title,
     *     $post->intro,
     *     array(
     *         'cp_edit_uri'    => 'admin/blog/edit/'.$id,
     *         'cp_delete_uri'  => 'admin/blog/delete/'.$id,
     *         'keywords'       => $post->keywords, 
     *     )
     * );
     * </code>
	 *
	 * @param	string	$module		The module that owns this entry 
	 * @param	string	$singular	The unique singular language key for this piece of data
	 * @param	string	$plural		The unique plural language key that describes many pieces of this data
	 * @param	int 	$entry_id	The id for this entry
	 * @param	string 	$uri		The relative uri to installation root
	 * @param	string 	$title		Title or Name of this entry
	 * @param	string 	$description Description of this entry
	 * @param	array 	$options	Options such as keywords (array or string - hash of keywords) and cp_edit_url/cp_delete_url
	 * @return	array
	 */
	public function index($module, $singular, $plural, $entry_id, $uri, $title, $description = null, array $options = array())
	{
		// Drop it so we can create a new index
		$this->drop_index($module, $singular, $entry_id);

		// Hand over keywords without needing to look them up
		if ( ! empty($options['keywords']))
		{
			if (is_array($options['keywords']))
			{
				$this->db->set('keywords', implode(',', $options['keywords']));
			}
			elseif (is_string($options['keywords']))
			{
				$this->db->set(array(
					'keywords' 		=> Keywords::get_string($options['keywords']),
					'keyword_hash' 	=> $options['keywords'],
				));
			}
		}

		// Store a link to edit this entry
		if ( ! empty($options['cp_edit_uri']))
		{
			$this->db->set('cp_edit_uri', $options['cp_edit_uri']);
		}

		// Store a link to delete this entry
		if ( ! empty($options['cp_delete_uri']))
		{
			$this->db->set('cp_delete_uri', $options['cp_delete_uri']);
		}

		return $this->db->insert('search_index', array(
			'title' 		=> $title,
			'description' 	=> strip_tags($description),
			'module' 		=> $module,
			'entry_key' 	=> $singular,
			'entry_plural' 	=> $plural,
			'entry_id' 		=> $entry_id,
			'uri' 			=> $uri,
		));
	}

	/**
	 * Drop index
	 *
	 * Delete an index for an entry
	 *
	 * <code>
	 * $this->search_index_m->drop_index('blog', 'blog:post', $id);
	 * </code>
	 *
	 * @param	string	$module		The module that owns this entry 
	 * @param	string	$singular	The unique singular "key" for this piece of data
	 * @param	int 	$entry_id	The id for this entry
	 * @return	array
	 */
	public function drop_index($module, $singular, $entry_id)
	{
		return $this->db
			->where(array(
				'module'     => $module,
				'entry_key'  => $singular,
				'entry_id'   => $entry_id,
			))
			->delete('search_index');
	}

	/**
	 * Filter
	 *
	 * Breaks down a search result by module and entity
	 *
	 * @param	array	$filter	Modules will be the key and the values are entity_plural (string or array)
	 * @return	array
	 */
	public function filter($filter)
	{
		// Filter Logic
		if ( ! $filter)
		{
			return $this;
		}
		
		$this->db->or_group_start();

		foreach ($filter as $module => $plural)
		{
			$this->db
				->group_start()
				->where('module', $module)
				->where_in('entry_plural', (array) $plural)
				->group_end();
		}

		$this->db->group_end();

		return $this;
	}

	/**
	 * Count
	 *
	 * Count relevant search results for a specific term
	 *
	 * @param	string	$query	Query or terms to search for
	 * @return	array
	 */
	public function count($query)
	{
		return $this->db
			->where('MATCH(title, description, keywords) AGAINST ("*'.$this->db->escape_str($query).'*" IN BOOLEAN MODE) > 0', null, false)
			->count_all_results('search_index');
	}

	/**
	 * Search
	 *
	 * Delete an index for an entry
	 *
	 * @param	string	$query	Query or terms to search for
	 * @return	array
	 */
	public function search($query)
	{
		return $this->db
			->select('title, description, keywords, module, entry_key, entry_plural, uri, cp_edit_uri')
			->select('MATCH(title, description, keywords) AGAINST ("*'.$this->db->escape_str($query).'*" IN BOOLEAN MODE) as bool_relevance', false)
			->select('MATCH(title, description, keywords) AGAINST ("*'.$this->db->escape_str($query).'*") AS relevance', false)
			->having('bool_relevance > 0')
			->order_by('relevance', 'desc')
			->get('search_index')
			->result();
	}
}
