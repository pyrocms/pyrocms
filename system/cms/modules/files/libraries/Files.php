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
	public 		static $path;
	public		static $max_size_possible;
	public		static $max_size_allowed;
	protected	static $_cache_path;
	protected 	static $_ext;
	protected	static $_type = '';
	protected	static $_filename = NULL;
	protected	static $_mimetype;

	// ------------------------------------------------------------------------

	public function __construct()
	{
		ci()->load->config('files/files');

		self::$path = config_item('files:path');
		self::$_cache_path = config_item('cache_dir').'cloud_cache/';
		self::$providers = explode(',', Settings::get('files_enabled_providers'));

		// work out the most restrictive ini setting
		$post_max = str_replace('M', '', ini_get('post_max_size'));
		$file_max = str_replace('M', '', ini_get('upload_max_filesize'));
		// set the largest size the server can handle and the largest the admin set
		self::$max_size_possible = ($file_max > $post_max ? $post_max : $file_max) * 1048576; // convert to bytes
		self::$max_size_allowed = Settings::get('files_upload_limit') * 1048576; // convert this to bytes also

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
		$insert['file_count'] = 0;
		$insert['location']	= 'local';

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

		$result = ci()->storage->create_container($container, 'public');

		// if they are also linking a local folder then we save that
		if ($id)
		{
			ci()->db->where('id', $id)->update('file_folders', array('remote_container' => $container));
		}

		if ($result)
		{
			return self::result(TRUE, lang('files:container_created'), $container);
		}

		return self::result(FALSE, lang('files:error_container'), $container);
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
	 * @param	int		$parent	The id of this folder
	 * @return	array
	 *
	**/

	/**
	 * Get all folders in a tree
	 *
	 * @return array
	 */
	public static function folder_tree()
	{
		$folders = array();
		$folder_array = array();

		$all_folders = ci()->file_folders_m
			->select('id, parent_id, slug, name')
			->order_by('sort')
			->get_all();

		// we must reindex the array first
		foreach ($all_folders as $row)
		{
			$folders[$row->id] = (array)$row;
		}

		unset($tree);

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
	public static function check_container($name, $location)
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

	/**
	 * Upload a file
	 *
	 * @param int $folder_id The folder to upload it to
	 * @param bool $name The filename
	 * @param string $field Like CI this defaults to "userfile"
	 * @param bool $width The width to resize the image to
	 * @param bool $height The height to resize the image to
	 * @param bool $ratio Keep the aspect ratio or not?
	 * @return array|bool
	 */
	public static function upload($folder_id, $name = FALSE, $field = 'userfile', $width = FALSE, $height = FALSE, $ratio = FALSE)
	{
		if ( ! $check_dir = self::_check_dir(self::$path))
		{
			return $check_dir;
		}

		if ( ! $check_cache_dir = self::_check_dir(self::$_cache_path))
		{
			return $check_cache_dir;
		}

		if ( ! $check_ext = self::_check_ext($field))
		{
			return $check_ext;
		}

		// this keeps a long running upload from stalling the site
		session_write_close();

		$folder = ci()->file_folders_m->get($folder_id);

		if ($folder)
		{
			ci()->load->library('upload', array(
				'upload_path'	=> self::$path,
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
					'name'			=> $name ? $name : $file['file_name'],
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

				// perhaps they want to resize it a bit as they upload
				if ($file['is_image'] AND $width OR $height)
				{
					ci()->load->library('image_lib');

					$config['image_library']    = 'gd2';
					$config['source_image']     = self::$path.$data['filename'];
					$config['new_image']        = self::$path.$data['filename'];
					$config['maintain_ratio']   = $ratio;
					$config['width']            = $width;
					$config['height']           = $height;
					ci()->image_lib->initialize($config);
					ci()->image_lib->resize();
					ci()->image_lib->clear();
				}

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
		else
		{
			return self::result(FALSE, lang('files:specify_valid_folder'));
		}
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

			if (file_exists(self::$path.$file->filename))
			{
				ci()->file_m->update($file_id, array('filename' => $filename, 'name' => $new_name));

				@rename(self::$path.$file->filename, self::$path.$filename);

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

				$path = ci()->storage->upload_file($container, self::$path.$file->filename, $object, NULL, 'public');

				if ($new_location === 'amazon-s3')
				{
					// if amazon didn't throw an error we'll create a path to store like rackspace does
					$url = ci()->parser->parse_string(Settings::get('files_s3_url'), array('bucket'=> $container), TRUE);
					$path = rtrim($url, '/').'/'.$object;
				}

				$data = array('filename' => $object, 'path' => $path);
				// save its location
				ci()->file_m->update($file->id, $data);

				// now we create a thumbnail of the image for the admin panel to display
				if ($file->type == 'i')
				{
					ci()->load->library('image_lib');

					$config['image_library']    = 'gd2';
					$config['source_image']     = self::$path.$file->filename;
					$config['new_image']        = self::$_cache_path.$data['filename'];
					$config['maintain_ratio']	= FALSE;
					$config['width']            = 75;
					$config['height']           = 50;
					ci()->image_lib->initialize($config);
					ci()->image_lib->resize();				
				}

				// get rid of the "temp" file
				@unlink(self::$path.$file->filename);

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
				write_file(self::$path.$new_name, $curl_result, 'wb');
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
			$temp_file = self::$path.md5(time()).'_temp_'.$new_name;

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
				$url = ci()->parser->parse_string(Settings::get('files_s3_url'), array('bucket'=> $container), TRUE);
				$path = rtrim($url, '/').'/'.$object;
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
		if ($location !== 'local' AND $container)
		{
			ci()->storage->load_driver($location);

			$cloud_list = ci()->storage->list_files($container);

			if ($cloud_list)
			{
				foreach ($cloud_list as $value) 
				{
					self::_get_file_info($value['name']);

					if ($location === 'amazon-s3')
					{
						// we'll create a path to store like rackspace does
						$url = ci()->parser->parse_string(Settings::get('files_s3_url'), array('bucket'=> $container), TRUE);
						$path = rtrim($url, '/').'/'.$value['name'];
					}
					elseif ($location === 'rackspace-cf')
					{
						// fetch the cdn uri from Rackspace
						$cf_container = ci()->storage->get_container($container);
						$path = $cf_container['cdn_uri'];

						// they are trying to index a non-cdn enabled container
						if ( ! $cf_container['cdn_enabled'])
						{
							// we'll try to enable it for them
							if ( ! $path = ci()->storage->create_container($container, 'public'))
							{
								// epic fails all around!!
								return self::result(FALSE, lang('files:enable_cdn'), $container);
							}
						}
						$path = rtrim($path, '/').'/'.$value['name'];
					}

					$files[$i]['filesize'] 		= ((int) $value['size']) / 1000;
					$files[$i]['filename'] 		= $value['name'];
					$files[$i]['extension']		= self::$_ext;
					$files[$i]['type']			= self::$_type;
					$files[$i]['mimetype']		= self::$_mimetype;
					$files[$i]['path']			= $path;
					$files[$i]['date_added']	= $value['time'];
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
					if (file_exists(self::$path.$value->filename))
					{
						$files[$i]['filesize'] 		= $value->filesize;
						$files[$i]['filename'] 		= $value->filename;
						$files[$i]['extension']		= $value->extension;
						$files[$i]['type']			= $value->type;
						$files[$i]['mimetype']		= $value->mimetype;
						$files[$i]['path']			= $value->path;
						$files[$i]['date_added']	= $value->date_added;
						$i++;
					}
				}
			}
		}

		$message = $files ? NULL : lang('files:no_records_found');

		return self::result( (bool) $files, $message, NULL, $files);
	}

	// ------------------------------------------------------------------------

	/**
	 * Index files from a remote container
	 *
	 * @param	string	$folder_id	The folder id to refresh. Files will be fetched from its assigned container
	 * @return	array
	 *
	**/
	public static function synchronize($folder_id)
	{
		$folder = ci()->file_folders_m->get_by('id', $folder_id);

		$files = Files::list_files($folder->location, $folder->remote_container);

		// did the fetch go ok?
		if ($files['status'])
		{
			$valid_records = array();
			$known = array();
			$known_files = ci()->file_m->where('folder_id', $folder_id)->get_all();

			// now we build an array with the database filenames as the keys so we can compare with the cloud list
			foreach ($known_files as $item)
			{
				$known[$item->filename] = $item;
			}

			foreach ($files['data'] as $file)
			{
				// it's a totally new file
				if ( ! array_key_exists($file['filename'], $known))
				{
					$insert = array(
						'folder_id' 	=> $folder_id,
						'user_id'		=> ci()->current_user->id,
						'type'			=> $file['type'],
						'name'			=> $file['filename'],
						'filename'		=> $file['filename'],
						'path'			=> $file['path'],
						'description'	=> '',
						'extension'		=> $file['extension'],
						'mimetype'		=> $file['mimetype'],
						'filesize'		=> $file['filesize'],
						'date_added'	=> $file['date_added']
					);

					// we add the id to the list of records that have existing files to match them
					$valid_records[] = ci()->file_m->insert($insert);
				}
				// it's totally not a new file
				else
				{
					// update with the details we got from the cloud
					ci()->file_m->update($known[$file['filename']]->id, $file);

					// we add the id to the list of records that have existing files to match them
					$valid_records[] = $known[$file['filename']]->id;
				}
			}

			// Ok then. Let's clean up the records with no files and get out of here
			ci()->db->where('folder_id', $folder_id)
				->where_not_in('id', $valid_records)
				->delete('files');

			return self::result(TRUE, lang('files:synchronization_complete'), $folder->name, $files['data']);
		}
		else
		{
			return self::result(NULL, lang('files:no_records_found'));
		}
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
				@unlink(self::$path.$file->filename);
			}
			else
			{
				ci()->storage->load_driver($file->location);
				ci()->storage->delete_file($file->remote_container, $file->filename);

				@unlink(self::$_cache_path.$file->filename);
			}

			return self::result(TRUE, lang('files:item_deleted'), $file->name);
		}

		return self::result(FALSE, lang('files:item_not_found'), $id);
	}

	// ------------------------------------------------------------------------

	/**
	 * Search all files and folders
	 *
	 * @param	int		$search		The keywords to search for
	 * @return	array
	 *
	**/
	public static function search($search, $limit = 5)
	{
		$results = array();
		$search = explode(' ', $search);

		// first we search folders
		ci()->file_folders_m->select('name, parent_id');
		
		foreach ($search as $match) 
		{
			$match = trim($match);

			ci()->file_folders_m->like('name', $match)
				->or_like('location', $match)
				->or_like('remote_container', $match);
		}

		$results['folder'] = ci()->file_folders_m->limit($limit)
			->get_all();


		// search the file records
		ci()->file_m->select('name, folder_id');

		foreach ($search as $match) 
		{
			$match = trim($match);

			ci()->file_m->like('name', $match)
			->or_like('filename', $match)
			->or_like('extension', $match);
		}

		$results['file'] = 	ci()->file_m->limit($limit)
			->get_all();

		if ($results['file'] OR $results['folder'])
		{
			return self::result(TRUE, NULL, NULL, $results);
		}

		return self::result(FALSE, lang('files:no_records_found'));
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
	 * Permissions
	 * 
	 * Return a simple array of allowed actions
	 *
	 * @return	array
	 *
	**/
	public static function allowed_actions()
	{
		$allowed_actions = array();

		foreach (ci()->module_m->roles('files') as $value)
		{
			// build a simplified permission list for use in this module
			if (isset(ci()->permissions['files']) AND
				array_key_exists($value, ci()->permissions['files']) OR ci()->current_user->group == 'admin')
			{
				$allowed_actions[] = $value;
			}
		}

		return $allowed_actions;
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
		log_message('debug', $e->getMessage());

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
		log_message('debug', $error);

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
		$name = convert_accented_characters($name);

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
	private static function _check_dir($path)
	{
		if (is_dir($path) AND is_really_writable($path))
		{
			return self::result(TRUE);
		}
		elseif ( ! is_dir($path))
		{
			if ( ! @mkdir($path, 0777, TRUE))
			{
				return self::result(FALSE, lang('files:mkdir_error'));
			}
			else
			{
				// create a catch all html file for safety
				$uph = fopen($path . 'index.html', 'w');
				fclose($uph);
			}
		}
		else
		{
			if ( ! chmod($path, 0777))
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

	// ------------------------------------------------------------------------

	/**
	 * Get the file type and extension from the name
	 * 
	 *
	 * @return	bool
	 *
	**/
	private static function _get_file_info($filename)
	{
		ci()->load->helper('file');

		$ext		= array_pop(explode('.', $filename));
		$allowed	= config_item('files:allowed_file_ext');

		foreach ($allowed as $type => $ext_arr)
		{				
			if (in_array(strtolower($ext), $ext_arr))
			{
				self::$_type		= $type;
				self::$_ext			= '.'.$ext;
				self::$_filename	= $filename;
				self::$_mimetype	= get_mime_by_extension($filename);

				break;
			}
		}
	}
}