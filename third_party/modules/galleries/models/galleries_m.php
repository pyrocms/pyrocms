<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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
class Galleries_m extends MY_Model
{

	/**
	 * Constructor method
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Call the parent's constructor
		parent::__construct();
	}
	
	/**
	 * Get all galleries along with the total number of photos in each gallery
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function get_all()
	{
		$galleries 		= parent::get_all();
		$results		= array();
		
		// Loop through each gallery and add the count of photos to the results
		foreach ( $galleries as $gallery )
		{
			$count = $this->db->select('id')
					 		  ->from('gallery_images')
					 		  ->where('gallery_id', $gallery->id)
							  ->count_all_results();

			$gallery->photo_count 	= $count;
			$results[] 				= $gallery;
		}
		
		// Return the results
		return $results;
	}
	
	/**
	 * Insert a new gallery into the database
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param array $input The data to insert (a copy of $_POST)
	 * @return bool
	 */
	public function insert_gallery($input)
	{		
		// Get rid of everything we don't need
		$to_insert = array(
			'title' 		=> $input['title'],
			'slug'			=> $this->generate_slug($input['title']),
			'description' 	=> $input['description'],
			'updated_on'	=> time() 
		);
		
		// Determine the gallery parent
		if ( $input['parent'] !== 'NONE' )
		{
			$to_insert['parent'] = $input['parent'];
		}
		
		// First we create the directories (so that we can delete them in case something goes wrong)
		if ( $this->create_folders($input['title']) === TRUE )
		{						
			// Insert the data into the database
			$insert_id = parent::insert( $to_insert );

			// Everything ok?
			if ( $insert_id >= 0 )
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Update an existing gallery
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the row to update
	 * @param array $input The data to use for updating the DB record
	 * @return bool
	 */
	public function update_gallery($id, $input)
	{
		// Prepare the data
		unset($input['btnAction']);
		$input['slug'] = $this->generate_slug($input['slug']);
		
		if ( $input['parent'] === 'NONE' )
		{
			$input['parent'] = NULL;
		}
		
		if ( !empty($input['gallery_thumbnail']) )
		{
			$input['thumbnail_id'] = $input['gallery_thumbnail'];
			unset($input['gallery_thumbnail']);
		}
		
		// Update the DB
		return parent::update($id, $input);
	}
	
	/**
	 * HELPER METHODS
	 * 
	 * The methods below perform tasks such as resizing thumbnails, counting photos, etc
	 */
	
	/**
	 * Create the required folders for a gallery
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param string $gallery The name of the gallery
	 * @return bool
	 */
	public function create_folders($gallery)
	{		
		// Generate the slug
		$slug = $this->generate_slug($gallery);
		
		// Does the galleries directory exist?
		if ( !is_dir('uploads/galleries') )
		{
			mkdir('uploads/galleries');
		}
		
		// Create the directories
		if ( mkdir("uploads/galleries/$slug") )
		{
			// Create the full and thumbs directory
			mkdir("uploads/galleries/$slug/full");
			mkdir("uploads/galleries/$slug/thumbs");
			
			return TRUE;
		}
		
		return FALSE;		
	}
	
	/**
	 * Remove a gallery's directory
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param string $gallery The name of the gallery
	 * @return bool
	 */
	public function rm_gallery_dir($gallery)
	{
		$slug = $this->generate_slug($gallery);
		$path = 'uploads/galleries/' . $slug;
		$this->load->helper('file');
		
		if ( is_dir($path) )
		{
			delete_files($path, TRUE);
			rmdir($path);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Create a gallery slug based on the title
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param string $name The name of the gallery
	 * @return string
	 */
	public function generate_slug($name)
	{
		$slug = strtolower($name);
		$slug = preg_replace('/\s+/', '-', $slug);
		
		return $slug;
	}
}