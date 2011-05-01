<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * The galleries module enables users to create albums, upload photos and manage their existing albums.
 *
 * @author 		Yorick Peterse - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Gallery Module
 * @category 	Modules
 * @license 	Apache License v2.0
 */
class Galleries_m extends MY_Model {

	/**
	 * Get all galleries along with the total number of photos in each gallery
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return mixed
	 */
	public function get_all()
	{
		$this->db
			->select('galleries.*, ff.slug as folder_slug, ff.name as folder_name')
			->join('file_folders ff', 'ff.id = galleries.folder_id', 'left');

		$galleries	= parent::get_all();
		$results	= array();

		// Loop through each gallery and add the count of photos to the results
		foreach ($galleries as $gallery)
		{
			$count = $this->db
				->select('f.id')
				->join('galleries g', 'g.folder_id = f.folder_id', 'left')
				->where('f.type', 'i')
				->where('g.id', $gallery->id)
				->count_all_results('files f');

			$gallery->photo_count = $count;
			$results[] = $gallery;
		}

		// Return the results
		return $results;
	}

	/**
	 * Get all galleries along with the thumbnail's filename and extension
	 *
	 * @access public
	 * @return mixed
	 */
	public function get_all_with_filename($where = NULL, $value = NULL)
	{
		$this->db
			->select('g.*, f.filename, f.extension, f.id as file_id, ff.parent_id as parent')
			->from('galleries g')
			->join('gallery_images gi', 'gi.file_id = g.thumbnail_id', 'left')
			->join('files f', 'f.id = gi.file_id', 'left')
			->join('file_folders ff', 'ff.id = g.folder_id', 'left')
			->where('g.published', '1');

		// Where clause provided?
		if ( ! empty($where) AND ! empty($value))
		{
			$this->db->where($where, $value);
		}

		return $this->db->get()->result();
	}

	/**
	 * Insert a new gallery into the database
	 *
	 * @author PyroCMS Dev Team
	 * @access public
	 * @param array $input The data to insert (a copy of $_POST)
	 * @return bool
	 */
	public function insert($input)
	{
		if (is_array($input['folder_id']))
		{
			$folder = $input['folder_id'];

			$input['folder_id'] = $this->file_folders_m->insert(array(
				'name'			=> $folder['name'],
				'parent_id'		=> 0,
				'slug'			=> $folder['slug'],
				'date_added'	=> now()
			));
		}

		return (int) parent::insert(array(
			'title'				=> $input['title'],
			'slug'				=> $input['slug'],
			'folder_id'			=> $input['folder_id'],
			'thumbnail_id'		=> ! empty($input['gallery_thumbnail']) ? (int) $input['gallery_thumbnail'] : NULL,
			'description'		=> $input['description'],
			'enable_comments'	=> $input['enable_comments'],
			'published'			=> $input['published'],
			'updated_on'		=> time(),
			'css'				=> $input['css'],
			'js'				=> $input['js']
		));
	}

	/**
	 * Update an existing gallery
	 *
	 * @author PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the row to update
	 * @param array $input The data to use for updating the DB record
	 * @return bool
	 */
	public function update($id, $input)
	{
        return parent::update($id, array(
			'title'				=> $input['title'],
			'slug'				=> $input['slug'],
			'folder_id'			=> $input['folder_id'],
			'description'		=> $input['description'],
			'enable_comments'	=> $input['enable_comments'],
			'thumbnail_id'		=> ! empty($input['gallery_thumbnail']) ? (int) $input['gallery_thumbnail'] : NULL,
			'published'			=> $input['published'],
			'updated_on'		=> time(),
			'css'				=> $input['css'],
			'js'				=> $input['js']
		));
	}

	/**
	 * Callback method for validating the slug
	 * @access public
	 * @param string $slug The slug to validate
	 * @param int $id The id of gallery
	 * @return bool
	 */
	public function check_slug($slug = '', $id = 0)
	{
		return parent::count_by(array(
			'id !='	=> $id,
			'slug'	=> $slug)
		) > 0;
	}

}