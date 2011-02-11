<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * The galleries module enables users to create albums, upload photos and manage their existing albums.
 *
 * @author 		Yorick Peterse - PyroCMS Dev Team
 * @modified	Jerel Unruh - PyroCMS Dev Team
 * @package 	PyroCMS
 * @subpackage 	Gallery Module
 * @category 	Modules
 * @license 	Apache License v2.0
 */
class Gallery_images_m extends MY_Model
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
		
		// Load all required classes
		$this->config->load('gallery_config');
		$this->load->library('upload');
		$this->load->library('image_lib');
	}
	
	/**
	 * Get all gallery images in a folder
	 *
	 * @author Phil Sturgeon - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the gallery
	 * @return mixed
	 */
	public function get_images_by_gallery($id)
	{
		$images = $this->db
				->select('gi.*, f.name as title, f.filename, f.extension, g.folder_id, g.slug as gallery_slug')
				->join('galleries g', 'gi.gallery_id = g.id')
				->join('files f', 'gi.file_id = f.id')
				->where('g.folder_id', $id)
				->order_by('`order`', 'asc')
				->get('gallery_images gi')
				->result();

		// Nothing? Return nothing
		if ( ! isset($images[0]))
		{
			return array();
		}

		// Which folder is this gallery lookig at? There may be unknown images
		$folder_id = $images[0]->folder_id;

		$file_ids = array();
		foreach ($images as &$image)
		{
			$file_ids[] = $image->file_id;
		}

		// Add these images to the array
		$images += $new_images = $this->db
			->select('id as file_id, name as title, filename, extension, date_added as `order`')
			->where('folder_id', $folder_id)
			->where('type', 'i')
			->where_not_in('id', $file_ids)
			->get('files')
			->result();

		// To avoid messing about with this in the future, add these to the gallery
		foreach ($new_images as $new_image)
		{
			$this->db->insert('gallery_images', array(
				'gallery_id' => $id,
				'file_id' => $new_image->file_id,
				'`order`' => $new_image->order
			));
		}

		return $images;
	}
	
	/**
	 * Get an image along with the gallery slug
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the image
	 * @return mixed
	 */
	public function get_image($id)
	{
		$query = $this->db->select('gallery_images.*, galleries.id as galleries_table_id, galleries.slug')
				 		  ->from('gallery_images')
				 		  ->join('galleries', 'gallery_images.gallery_id = galleries.id')
				    	  ->where('gallery_images.id', $id)
				 		  ->get();
				
		if ( $query->num_rows() > 0 )
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Upload an image to the server and add it to the DB
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param array $input The data sent by the form
	 * @return bool
	 */
	public function upload_image($input)
	{
		// Get the name of the gallery we're uploading the image to
		$gallery = $this->db->select('slug')
							->from('galleries')
							->where('id', $input['gallery_id'])
							->get()
							->row();

		$gallery_slug 	= $gallery->slug;
		
		// First we need to upload the image to the server
		$upload_conf['upload_path'] 	= 'uploads/galleries/' . $gallery_slug . '/full';
		$upload_conf['allowed_types'] 	= $this->config->item('image_allowed_filetypes');
		$this->upload->initialize($upload_conf);
		
		// Let's see if we can upload the file
		if ( $this->upload->do_upload() )
		{
			$uploaded_data 	= $this->upload->data();
			
			// Set the data for creating a thumbnail
			$source			= 'uploads/galleries/' . $gallery_slug . '/full/' . $uploaded_data['file_name'];
			$destination	= 'uploads/galleries/' . $gallery_slug . '/thumbs';
			$options['create_thumb']	= FALSE;
			$options['quality']			= '85';
			
			// Is the current size larger? If so, resize to a width/height of X pixels (determined by the config file)
			if ( $uploaded_data['image_width'] > $this->config->item('image_width'))
			{
				$options['width'] = $this->config->item('image_width');
			}
			if ( $uploaded_data['image_height'] > $this->config->item('image_height'))
			{
				$options['height'] = $this->config->item('image_height');
			}
			
			// resize the main image
			if ( $this->resize('resize', $source, $source, $options) === TRUE )
			{
				// Is the current size larger? If so, resize to a width/height of X pixels (determined by the config file)
				if ( $uploaded_data['image_width'] > $this->config->item('image_thumb_width'))
				{
					$options['width'] = $this->config->item('image_thumb_width');
				}
				if ( $uploaded_data['image_height'] > $this->config->item('image_thumb_height'))
				{
					$options['height'] = $this->config->item('image_thumb_height');
				}
				
				$options['create_thumb'] = TRUE;
				
					// Great, time to create a thumbnail
					if ( $this->resize('resize', $source, $destination, $options) === TRUE )
					{
						// Image has been uploaded, thumbnail has been created, time to add it to the DB!
						$to_insert['gallery_id'] = $input['gallery_id'];
						$to_insert['filename']	 = $uploaded_data['raw_name'];
						$to_insert['extension']	 = $uploaded_data['file_ext'];
						$to_insert['title']		 = $input['title'];
						$to_insert['description']= $input['description'];
						$to_insert['uploaded_on']= time();
						$to_insert['updated_on'] = time();
						
						// Insert it
						if ( $id = parent::insert($to_insert) )
						{
							if($this->db->where('id', $input['gallery_id'])
										->update('galleries', array('thumbnail_id' => $id)) )
							{
								return TRUE;
							}
						}
					}	
			}
		}
		return FALSE;
	}
	
	/**
	 * Update an existing image
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @modified by Jerel Unruh - PyroCMS Dev Team to add crop
	 * @access public
	 * @param int $id The ID of the image
	 * @param array $input The data used for updating the image
	 * @return mixed
	 */
	public function update_image($id, $input)
	{
		// Get the data related to the image we're working with
		$image = $this->db->from('gallery_images')
						  ->join('galleries', 'gallery_images.gallery_id = galleries.id')
						  ->where('gallery_images.id', $id)
						  ->get()
						  ->row();
		// Set the paths
		$full_path 	= 'uploads/galleries/' . $image->slug . '/full/' 	. $image->filename . $image->extension;	
		$thumb_path = 'uploads/galleries/' . $image->slug . '/thumbs/' 	. $image->filename 	. '_thumb' . $image->extension;
		
		// Crop an existing thumbnail
		if ( $input['thumb_width'] && $input['thumb_height'] > '1')
		{
			// Get the required values for cropping the thumbnail
			$size_array = getimagesize($full_path);
			$width 		= $size_array[0];
			$height 	= $size_array[1];
			$scaled_height		 	= $input['scaled_height'];
			$scaled_percent			= $scaled_height/$height;
			
			$options['width'] 			= $input['thumb_width']/$scaled_percent;
			$options['height']			= $input['thumb_height']/$scaled_percent;
			$options['x_axis']			= $input['thumb_x']/$scaled_percent;
			$options['y_axis']			= $input['thumb_y']/$scaled_percent;			
			$options['create_thumb']	= FALSE;
			$options['maintain_ratio']	= $input['ratio'];
			
			// Crop the fullsize image first
			if ($this->resize('crop', $full_path, $full_path, $options) !== TRUE)
			{
				return FALSE;
			}
			
			//Create a new thumbnail from the newly cropped image
			// Is the current size larger? If so, resize to a width/height of X pixels (determined by the config file)
			if ( $options['width'] > $this->config->item('image_thumb_width'))
			{
				$options['width'] = $this->config->item('image_thumb_width');
			}
			if ( $options['height'] > $this->config->item('image_thumb_height'))
			{
				$options['height'] = $this->config->item('image_thumb_height');
			}
					
			// Set the thumbnail option
			$options['create_thumb'] = TRUE;
			$options['maintain_ratio'] = TRUE;
					
			//create the thumbnail
			if ( $this->resize('resize', $full_path, 'uploads/galleries/' . $image->slug . '/thumbs/', $options) !== TRUE )
			{
				return FALSE;
			}
		} 
		
		// Delete the image from the DB and the filesystem
		else if ( isset($input['delete']) )
		{
			// First we'll delete it from the DB
			if ( parent::delete($id) )
			{	
				// Change the table
				$this->_table = 'galleries';
						
				// Unset the thumbnail for each gallery that was using this image
				if ( parent::update_by('thumbnail_id', $id, array('thumbnail_id' => NULL)) )
				{
					// Change the table back
					$this->_table = 'gallery_images';
					
					// Delete the files
					if ( unlink($full_path) === TRUE AND unlink($thumb_path) === TRUE )
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
			else
			{
				return FALSE;
			}
		}
		//are we moving the image to a new gallery?
		elseif($input['gallery_id'] != $image->gallery_id)
		{
			//it looks like it lets move those assets
			$new_slug = $this->_find_slug($input['gallery_id']);  
			
			$rename = array(
				'slug' => $image->slug,
				'new_slug' => $new_slug,
				'filename' => $image->filename,
				'extension' => $image->extension
			);
			
			if($this->_move_image($rename))
			{
				$to_update['gallery_id'] = $input['gallery_id'];
			}
		}
		
		// Just save it already, do note that data isn't saved if the user decides to delete an image
		$to_update['title'] 		= $input['title'];
		$to_update['description'] 	= $input['description'];
		$to_update['updated_on']	= time();
		
		return parent::update($id, $to_update);
	}
	
	/**
	 * HELPER METHODS
	 * 
	 * The methods below perform tasks such as resizing thumbnails, counting photos, etc
	 */
	
	/**
	 * Create a thumbnail
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param string $mode The mode of image manipulation, either "resize" or "crop"
	 * @param string $source The image to use for creating the thumbnail
	 * @param string $destination The location of the new file
	 * @param array $options Optional array that may contain data such as the new width, height, etc
	 * @return bool
	 */
	public function resize($mode, $source, $destination, $options = array())
	{		
		// Time to resize the image
		$image_conf['image_library'] 	= 'gd2';
		$image_conf['source_image']  	= $source;
		
		// Save a new image somewhere else?
		if ( !empty($destination) )
		{
			$image_conf['new_image']	= $destination;
		}
		
		$image_conf['thumb_marker']		= '_thumb';
		$image_conf['create_thumb']  	= TRUE; 
		$image_conf['quality']			= '100';
		
		// Optional parameters set?
		if ( !empty($options) )
		{
			// Loop through each option and add it to the $image_conf array
			foreach ( $options as $key => $option )
			{
				$image_conf[$key] = $option;
			}
		}
		
		$this->image_lib->initialize($image_conf);
		
		if ( $mode == 'resize' )
		{
			return $this->image_lib->resize();
		}
		else if ( $mode == 'crop' )
		{
			return $this->image_lib->crop();
		}
		
		return FALSE;
	}
	
	/**
	 * Move thumbnail and full image to a new gallery
	 *
	 * @access private
	 * @return bool
	 * @param $data (array)
	 *
	 * array(
	 *		'slug' => 'the current slug',
	 *		'filename' => 'the image filename',
	 *		'extension' => 'the image extension,
	 *		'new_slug' => 'the new album slug'
	 * )
	 */
	private function _move_image($data = array())
	{
		
		if( !empty($data) )
		{
			$original_thumb = "uploads/galleries/{$data['slug']}/thumbs/{$data['filename']}_thumb{$data['extension']}";
			$original_full = "uploads/galleries/{$data['slug']}/full/{$data['filename']}{$data['extension']}";
			
			$new_thumb = "uploads/galleries/{$data['new_slug']}/thumbs/{$data['filename']}_thumb{$data['extension']}";
			$new_full = "uploads/galleries/{$data['new_slug']}/full/{$data['filename']}{$data['extension']}";
			
			if(rename($original_thumb, $new_thumb))
			{
				return rename($original_full, $new_full);
			}
			return FALSE;
		}
	}
	
	/**
	 * Find a gallery slug
	 *
	 * @access private
	 * @return mixed (bool, string)
	 * @param $id (int)
	 */
	private function _find_slug($id = FALSE)
	{
		$gallery = $this->db->where('id', $id)
							->from('galleries')
							->get()
							->row();
					
		return !empty($gallery) ? $gallery->slug : FALSE ;
	}
}
