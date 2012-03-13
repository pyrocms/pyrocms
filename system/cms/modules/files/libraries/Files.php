<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PyroCMS File library. 
 *
 * This handles all file manipulation 
 * both locally and in the cloud
 * 
 * @author		Jerel Unruh - PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Libraries
 */
class Files
{
	public		static $providers;
	public 	static $_path;
	protected 	static $_ext;
	protected	static $_type = '';
	protected	static $_filename = NULL;

	// ------------------------------------------------------------------------

	public function __construct()
	{
		ci()->load->config('files/files');

		self::$_path = config_item('files:path');
		self::$providers = explode(',', Settings::get('files_enabled_providers'));

		set_exception_handler(array($this, 'exception_handler'));
		set_error_handler(array($this, 'error_handler'));

		ci()->load->model('files/file_m');
		ci()->load->model('files/file_folders_m');
		ci()->load->spark('cloudmanic-storage/1.0.4');
	}

	// ------------------------------------------------------------------------

	/**
	 * Create an empty folder
	 *
	 * @param	int		$parent	The id of this folder's parent
	 * @param	string	$name	Desired Name. If left empty a name will be assigned
	 * @return	array
	 *
	**/
	public static function create_folder($parent = 0, $name = 'Untitled Folder')
	{
		$i = '';
		$original_slug = self::create_slug($name);
		$original_name = $name;

		$slug = $original_slug;

		while (ci()->file_folders_m->count_by('slug', $slug))
		{
			$i++;
			$slug = $original_slug.'-'.$i;
			$name = $original_name.'-'.$i;
		}

		$insert = array('parent_id' => $parent, 
						'slug' => $slug, 
						'name' => $name, 
						'date_added' => now(), 
						'sort' => now()
						);

		$id = ci()->file_folders_m->insert($insert);

		$insert['id'] = $id;

		return self::result(TRUE, lang('files:item_created'), $insert['name'], $insert);
	}

	// ------------------------------------------------------------------------

	/**
	 * Create a container with the cloud provider
	 *
	 * @param	string	$container	Container name
	 * @param	string	$location	The cloud provider
	 * @return	array
	 *
	**/
	public static function create_container($container, $location, $id = 0)
	{
		ci()->storage->load_driver($location);

		$result = ci()->storage->create_container($container);

		// if they are also linking a local folder then we save that
		if ($id)
		{
			ci()->db->where('id', $id)->update('file_folders', array('remote_container' => $container));
		}

		if ($result AND $location == 'amazon-s3' OR $result === NULL AND $location == 'rackspace-cf')
		{
			return self::result(TRUE, lang('files:container_created'), $container);
		}
		else
		{
			return self::result(FALSE, lang('files:error_container'), $container);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all folders and files within a folder
	 *
	 * @param	int		$parent	The id of this folder
	 * @return	array
	 *
	**/
	public static function folder_contents($parent = 0)
	{

		$folders = ci()->file_folders_m->where('parent_id', $parent)
			->order_by('sort')
			->get_all();

		$files = ci()->file_m->where('folder_id', $parent)
			->order_by('sort')
			->get_all();

		// let's be nice and add a date in that's formatted like the rest of the CMS
		if ($folders)
		{
			foreach ($folders as &$folder) 
			{
				$folder->formatted_date = format_date($folder->date_added);

				$folder->file_count = ci()->file_m->count_by('folder_id', $folder->id);
			}
		}

		if ($files)
		{
			foreach ($files as &$file) 
			{
				$file->formatted_date = format_date($file->date_added);
			}
		}

		return self::result(TRUE, NULL, NULL, array('folder' => $folders, 'file' => $files));
	}

	// ------------------------------------------------------------------------

	/**
	 * Get all folders in a tree
	 *
	 * @param	int		$parent	The id of this folder
	 * @return	array
	 *
	**/
	public function folder_tree()
	{
		$folders = array();
		$folder_array = array();

		$all_folders = $this->file_folders_m
			->select('id, parent_id, slug, name')
			 ->order_by('sort')
			 ->get_all();
	
		// we must reindex the array first
		foreach ($all_folders as $row)
		{
			$folders[$row->id] = (array) $row;
		}
		
		unset($all_folders);
	
		// build a multidimensional array of parent > children
		foreach ($folders as $row)
		{
			if (array_key_exists($row['parent_id'], $folders))
			{
				// add this folder to the children array of the parent folder
				$folders[$row['parent_id']]['children'][] =& $folders[$row['id']];
			}
			
			// this is a root folder
			if ($row['parent_id'] == 0)
			{
				$folder_array[] =& $folders[$row['id']];
			}
		}
	
		return $folder_array;
	}

	// ------------------------------------------------------------------------

	/**
	 * Check if an unindexed container exists in the cloud
	 *
	 * @param	string	$name		The container name
	 * @param	string	$location	Amazon/Rackspace
	 * @return	array
	 *
	**/
	public function check_container($name, $location)
	{
		ci()->storage->load_driver($location);

		$containers = ci()->storage->list_containers();

		foreach($containers AS $container)
		{
			if ($name === $container)
			{
				return self::result(TRUE, lang('files:container_exists'), $name);
			}
		}
		return self::result(TRUE, lang('files:container_not_exists'), $name);
	}

	// ------------------------------------------------------------------------

	/**
	 * Rename a folder
	 *
	 * @param	int		$id		The id of the folder
	 * @param	string	$name	The new name
	 * @return	array
	 *
	**/
	public static function rename_folder($id = 0, $name)
	{
		$i = '';
		$original_slug = self::create_slug($name);
		$original_name = $name;

		$slug = $original_slug;

		while (ci()->file_folders_m->where('id !=', $id)->count_by('slug', $slug))
		{
			$i++;
			$slug = $original_slug.'-'.$i;
			$name = $original_name.'-'.$i;
		}

		$insert = array('slug' => $slug, 
						'name' => $name
						);

		ci()->file_folders_m->update($id, $insert);

		return self::result(TRUE, lang('files:item_updated'), $insert['name'], $insert);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete an empty folder
	 *
	 * @param	int		$id		The id of the folder
	 * @return	array
	 *
	**/
	public static function delete_folder($id = 0)
	{
		$folder = ci()->file_folders_m->get($id);

		if ( ! $files = ci()->file_m->get_by('folder_id', $id) AND ! ci()->file_folders_m->get_by('parent_id', $id))
		{
			ci()->file_folders_m->delete($id);

			return self::result(TRUE, lang('files:item_deleted'), $folder->name);
		}
		else
		{
			return self::result(FALSE, lang('files:folder_not_empty'), $folder->name);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Upload a file
	 *
	 * @param	int		$folder_id	The folder to upload it to
	 * @param	string	$name		The filename
	 * @param	string	$field		Like CI this defaults to "userfile"
	 * @return	array
	 *
	**/
	public static function upload($folder_id, $name, $field = 'userfile')
	{
		if ( ! $check_dir = self::_check_dir()) return $check_dir;

		if ( ! $check_ext = self::_check_ext($field)) return $check_ext;

		// this keeps a long running upload from stalling the site
		session_write_close();

		$folder = ci()->file_folders_m->get($folder_id);

		if ($folder)
		{
			ci()->load->library('upload', array(
				'upload_path'	=> self::$_path,
				'allowed_types'	=> self::$_ext,
				'file_name'		=> self::$_filename
			));

			if (ci()->upload->do_upload($field))
			{
				$file = ci()->upload->data();
				$data = array(
					'folder_id'		=> (int) $folder_id,
					'user_id'		=> (int) ci()->current_user->id,
					'type'			=> self::$_type,
					'name'			=> $name,
					'path'			=> '{{ url:site }}files/large/'.$file['file_name'],
					'description'	=> '',
					'filename'		=> $file['file_name'],
					'extension'		=> $file['file_ext'],
					'mimetype'		=> $file['file_type'],
					'filesize'		=> $file['file_size'],
					'width'			=> (int) $file['image_width'],
					'height'		=> (int) $file['image_height'],
					'date_added'	=> now()
				);

				$file_id = ci()->file_m->insert($data);

				if ($folder->location !== 'local')
				{
					return Files::move($file_id, $data['filename'], 'local', $folder->location, $folder->remote_container);
				}

				return self::result(TRUE, lang('files:file_uploaded'), $name);
			}
			else
			{
				$errors = ci()->upload->display_errors();

				return self::result(FALSE, $errors);
			}
		}

		// a catch-all to let them know something failed if it happens to make it this far
		return self::result(FALSE, lang('files:upload_error'));
	}

	// ------------------------------------------------------------------------

	/**
	 * Rename files on the local filesystem or in the cloud
	 *
	 * @param	string	$file_id		The file's database record
	 * @param	string	$new_file		The desired filename
	 * @param	string	$location		Its current location, except in the case of an upload this will be found from the db
	 * @param	string	$new_location	The desired provider to move the file to
	 * @param	string	$container		The bucket, container, or folder to move the file to
	 * @return	array
	**/
	public static function move($file_id, $new_name = FALSE, $location = FALSE, $new_location = 'local', $container = '')
	{
		$file = ci()->file_m->select('files.*, file_folders.name foldername, file_folders.slug, file_folders.location')
			->join('file_folders', 'files.folder_id = file_folders.id')
			->get_by('files.id', $file_id);

		if ( ! $file)
		{
			return self::result(FALSE, lang('files:item_not_found'), $new_name ? $new_name : $file_id);
		}

		// this keeps a long running transaction from stalling the site
		session_write_close();

		// this would be used when move() is used during a rackspace or amazon upload as the location in the 
		// database is not the actual file location, its location is local temporarily
		if ($location) $file->location = $location;

		// if both locations are on the local filesystem then we just rename
		if ($file->location === 'local' AND $new_location === 'local')
		{
			// if they were helpful enough to provide an extension then remove it
			$filename = str_replace($file->extension, '', $new_name);

			// force the correct extension
			$filename = self::create_slug($filename).$file->extension;

			$data = array('id' => $file_id,
						  'name' => $new_name,
						  'filename' => $filename,
						  'location' => $new_location,
						  'container' => $container);

			if (file_exists(self::$_path.$file->filename))
			{
				ci()->file_m->update($file_id, array('filename' => $filename, 'name' => $new_name));

				@rename(self::$_path.$file->filename, self::$_path.$filename);

				return self::result(TRUE, lang('files:item_updated'), $new_name, $data);
			}
			else
			{
				return self::result(FALSE, lang('files:item_not_found'), $file->name, $data);
			}
		}
		// we'll be pushing the file from here to the cloud
		elseif ($file->location === 'local' AND $new_location)
		{
			ci()->storage->load_driver($new_location);

			$containers = ci()->storage->list_containers();

			// if we try uploading to a non-existant container it gets ugly
			if (in_array($container, $containers))
			{
				// make a unique object name
				$object = now().'.'.$new_name;

				$path = ci()->storage->upload_file($container, self::$_path.$file->filename, $object, NULL, 'public');

				if ($new_location === 'amazon-s3')
				{
					// if amazon didn't throw an error we'll create a path to store like rackspace does
					$path = 'http://'.$container.'.'.'s3.amazonaws.com/'.$object;
				}

				$data = array('filename' => $object, 'path' => $path);
				// save its location
				ci()->file_m->update($file->id, $data);

				// get rid of the "temp" file
				@unlink(self::$_path.$file->filename);

				return self::result(TRUE, lang('files:file_uploaded'), $new_name, $data);
			}

			return self::result(FALSE, lang('files:invalid_container'), $container);
		}
		// pull it from the cloud to our filesystem
		elseif ($file->location AND $new_location === 'local')
		{
			ci()->load->helper('file');
			ci()->load->spark('curl/1.2.1');

			// download the file... dum de dum
			$curl_result = ci()->curl->simple_get($file);

			if ($curl_result)
			{
				// ...and save it
				write_file(self::$_path.$new_name, $curl_result, 'wb');
			}
			else
			{
				return self::result(FALSE, lang('files:unsuccessful_fetch'), $file);
			}
		}
		// pulling from the cloud and then pushing to another part of the cloud :P
		elseif ($file->location AND $new_location)
		{
			ci()->load->helper('file');
			ci()->storage->load_driver($new_location);

			// make a really random temp file name
			$temp_file = self::$_path.md5(time()).'_temp_'.$new_name;

			// and we download...
			$curl_result = ci()->curl->simple_get($file);

			if ($curl_result)
			{
				write_file($temp_file, $curl_result, 'wb');
			}
			else
			{
				return self::result(FALSE, lang('files:unsuccessful_fetch'), $file);
			}

			// make a unique object name
			$object = now().'.'.$new_name;

			$path = ci()->storage->upload_file($container, $temp_file, $object, NULL, 'public');

			if ($new_location === 'amazon-s3')
			{
				// if amazon didn't throw an error we'll create a path to store like rackspace does
				$path = 'http://'.$container.'.'.'s3.amazonaws.com/'.$object;
			}

			$data = array('filename' => $object, 'path' => $path);

			// save its new location
			ci()->file_m->update($file->id, $data);

			// get rid of the "temp" file
			@unlink($temp_file);

			return self::result(TRUE, lang('files:file_moved'), $file->name, $data);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Get A Single File
	 *
	 * @param	int		$identifier	The id or filename
	 * @return	array
	 *
	**/
	public static function get_file($identifier = 0)
	{
		// they could have specified the row id or the actual filename
		$column = is_numeric($identifier) ? 'files.id' : 'filename';

		$results = ci()->file_m->select('files.*, file_folders.name folder_name, file_folders.slug folder_slug')
			->join('file_folders', 'file_folders.id = files.folder_id')
			->get_by($column, $identifier);

		$message = $results ? NULL : lang('files:no_records_found');

		return self::result( (bool) $results, $message, NULL, $results);
	}

	// ------------------------------------------------------------------------

	/**
	 * Get Known Files
	 *
	 * @param	string	$location	The cloud provider or local
	 * @param	string	$container	The container or folder to get files from
	 * @return	array
	 *
	**/
	public static function get_files($location = 'local', $container = '')
	{
		$results = ci()->file_m->select('files.*, file_folders.name folder_name, file_folders.slug folder_slug')
			->join('file_folders', 'file_folders.id = files.folder_id')
			->where('location', $location)
			->where('slug', $container)
			->get_all();

		$message = $results ? NULL : lang('files:no_records_found');

		return self::result( (bool) $results, $message, NULL, $results);
	}

	// ------------------------------------------------------------------------

	/**
	 * List Files -- get_files() returns database records. This pulls from
	 * the cloud instead but for completeness it will fetch local file names 
	 * from the database if the location is "local"
	 *
	 * @param	string	$location	The cloud provider or local
	 * @param	string	$container	The container or folder to list files from
	 * @return	array
	 *
	**/
	public static function list_files($location = 'local', $container = '')
	{
		$i = 0;
		$files = array();

		// yup they want real live file names from the cloud
		if ($location !== 'local')
		{
			ci()->storage->load_driver($location);

			$cloud_list = ci()->storage->list_files($container);

			if ($cloud_list)
			{
				foreach ($cloud_list as $value) 
				{
					$files[$i]['filesize'] 		= (int) $value['size'];
					$files[$i]['filename'] 		= $value['name'];
					$files[$i]['file_exists']	= TRUE;
					$i++;
				}
			}
		}
		// they're wanting a local list... give it to 'em but only if the file really exists
		elseif ($location === 'local') 
		{
			$results = ci()->file_m->select('filename, filesize')
				->join('file_folders', 'file_folders.id = files.folder_id')
				->where('slug', $container)
				->get_all();

			if ($results)
			{
				foreach ($results as $value) 
				{
					$files[$i]['filesize'] 		= $value->filesize;
					$files[$i]['filename'] 		= $value->filename;
					$files[$i]['file_exists'] 	= file_exists(self::$_path.$value->filename) ? TRUE : FALSE;
					$i++;
				}
			}
		}

		$message = $files ? NULL : lang('files:no_records_found');

		return self::result( (bool) $files, $message, NULL, $files);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a file
	 *
	 * @param	int		$id		The id of the file
	 * @return	array
	 *
	**/
	public static function delete_file($id = 0)
	{
		if ($file = ci()->file_m->select('files.*, file_folders.name foldername, file_folders.slug, file_folders.location, file_folders.remote_container')
			->join('file_folders', 'files.folder_id = file_folders.id')
			->get_by('files.id', $id))
		{
			ci()->file_m->delete($id);

			if ($file->location === 'local')
			{
				@unlink(self::$_path.$file->filename);
			}
			else
			{
				ci()->storage->load_driver($file->location);
				ci()->storage->delete_file($file->remote_container, $file->filename);
			}

			return self::result(TRUE, lang('files:item_deleted'), $file->name);
		}

		return self::result(FALSE, lang('files:item_not_found'), $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Result
	 * 
	 * Return a message in a uniform format for the entire library
	 *
	 * @param	bool	$status		Operation was a success or failure
	 * @param	string	$message	The failure message to return
	 * @param	mixed	$args		Arguments to pass to sprint_f
	 * @param	mixed	$data		Any data to be returned
	 * @return	array
	 *
	**/
	public static function result($status = TRUE, $message = '', $args = FALSE, $data = '')
	{
		return array('status' 	=> $status, 
					 'message' 	=> $args ? sprintf($message, $args) : $message, 
					 'data' 	=> $data
					 );
	}

	// ------------------------------------------------------------------------

	/**
	 * Exception Handler
	 * 
	 * Return a the error message thrown by Cloud Files
	 *
	 * @return	array
	 *
	**/
	public static function exception_handler($e)
	{
		echo json_encode( 
			array('status' 	=> FALSE, 
				  'message' => $e->getMessage(),
				  'data' 	=> ''
				 )
		);
	}

	// ------------------------------------------------------------------------

	/**
	 * Error Handler
	 * 
	 * Return the error message thrown by Amazon S3
	 *
	 * @return	array
	 *
	**/
	public static function error_handler($e_number, $error)
	{
		// only output the S3 error messages
		if (strpos($error, 'S3') !== FALSE)
		{
			echo json_encode( 
				array('status' 	=> FALSE, // clean up the error message to make it more readable
					  'message' => preg_replace('@S3.*?\[.*?\](.*)$@ms', '$1', $error),
					  'data' 	=> ''
					 )
			);
			die();
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Create Slug
	 * 
	 * Strip all odd characters out of a name and lowercase it
	 *
	 * @param	string	$name	The uncleaned name string
	 * @return	string
	 *
	**/
	protected static function create_slug($name)
	{
		return strtolower(preg_replace('/-+/', '-', preg_replace('/[^a-zA-Z0-9]/', '-', $name)));
	}

	// ------------------------------------------------------------------------

	/**
	 * Check our upload directory
	 * 
	 * This is used on the local filesystem
	 *
	 * @return	bool
	 *
	**/
	private static function _check_dir()
	{
		if (is_dir(self::$_path) AND is_really_writable(self::$_path))
		{
			return self::result(TRUE);
		}
		elseif ( ! is_dir(self::$_path))
		{
			if ( ! @mkdir(self::$_path, 0777, TRUE))
			{
				return self::result(FALSE, lang('files:mkdir_error'));
			}
			else
			{
				// create a catch all html file for safety
				$uph = fopen(self::$_path . 'index.html', 'w');
				fclose($uph);
			}
		}
		else
		{
			if ( ! chmod(self::$_path, 0777))
			{
				return self::result(FALSE, lang('files:chmod_error'));
			}
		}
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Check the extension and clean the file name
	 * 
	 *
	 * @return	bool
	 *
	**/
	private static function _check_ext($field)
	{
		if ( ! empty($_FILES[$field]['name']))
		{
			$ext		= pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
			$allowed	= config_item('files:allowed_file_ext');

			foreach ($allowed as $type => $ext_arr)
			{				
				if (in_array(strtolower($ext), $ext_arr))
				{
					self::$_type		= $type;
					self::$_ext			= implode('|', $ext_arr);
					self::$_filename	= trim(url_title($_FILES[$field]['name'], 'dash', TRUE), '-');

					break;
				}
			}

			if ( ! self::$_ext)
			{
				return self::result(FALSE, lang('files:invalid_extension'), $_FILES[$field]['name']);
			}
		}		
		elseif (ci()->method === 'upload')
		{
			return self::result(FALSE, lang('files:upload_error'));
		}

		return self::result(TRUE);
	}
}