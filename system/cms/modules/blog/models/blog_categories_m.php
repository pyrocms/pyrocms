<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Categories model
 * 
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Blog\Models
 */
class Blog_categories_m extends MY_Model
{
	/**
	 * Insert a new category into the database
	 * 
	 * @param array $input The data to insert
	 * @return string
	 */
	public function insert($input = array())
	{
		parent::insert(array(
			'title'=>$input['title'],
			'slug'=>url_title(strtolower(convert_accented_characters($input['title'])))
		));
		
		return $input['title'];
	}

	/**
	 * Update an existing category
	 * 
	 * @param int $id The ID of the category
	 * @param array $input The data to update
	 * @return bool
	 */
	public function update($id, $input)
	{
		return parent::update($id, array(
			'title'	=> $input['title'],
		        'slug'	=> url_title(strtolower(convert_accented_characters($input['title'])))
		));
	}

	/**
	 * Callback method for validating the title
	 * 
	 * @param string $title The title to validate
	 * @param int $id The id to check
	 * @return mixed
	 */
	public function check_title($title = '', $id = 0)
	{
		return (bool) $this->db->where('slug', url_title($title))
			->where('id != ', $id)
			->from('blog_categories')
			->count_all_results();
	}
	
	/**
	 * Insert a new category into the database via ajax
	 * 
	 * @param array $input The data to insert
	 * @return int
	 */
	public function insert_ajax($input = array())
	{
		return parent::insert(array(
			'title'=>$input['title'],
			//is something wrong with convert_accented_characters?
			//'slug'=>url_title(strtolower(convert_accented_characters($input['title'])))
			'slug' => url_title(strtolower($input['title']))
		));
	}
}