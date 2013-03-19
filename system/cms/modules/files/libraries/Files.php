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
	protected	static $_filename = null;
	protected	static $_mimetype;

	// ------------------------------------------------------------------------

	public function __construct()
	{
		ci()->load->config('files/files');

		self::$path = config_item('files:path');
		self::$_cache_path = config_item('cache_dir').'cloud_cache/';

		if ($providers = Settings::get('files_enabled_providers'))
		{
			self::$providers = explode(',', $providers);

			// make 'local' mandatory. We search for the value because of backwards compatibility
			if ( ! in_array('local', self::$providers))
			{
				array_unshift(self::$providers, 'local');
			}
		}
		else
		{
			self::$providers = array('local');
		}

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
	public static function create_folder($parent = 0, $name = 'Untitled Folder', $location = 'local', $remote_container = '')
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
						'location' => $location,
						'remote_container' => $remote_container,
						'date_added' => now(), 
						'sort' => now()
						);

		$id = ci()->file_folders_m->insert($insert);

		$insert['id'] = $id;
		$insert['file_count'] = 0;

		return self::result(true, lang('files:item_created'), $insert['name'], $insert);
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
			return self::result(true, lang('files:container_created'), $container);
		}

		return self::result(false, lang('files:error_container'), $container);
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
		// they can also pass a url hash such as #foo/bar/some-other-folder-slug
		if ( ! is_numeric($parent))
		{
			$segment = explode('/', trim($parent, '/#'));
			$result = ci()->file_folders_m->get_by('slug', array_pop($segment));

			$parent = ($result ? $result->id : 0);
		}

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
			ci()->load->library('keywords/keywords');

			foreach ($files as &$file) 
			{
				$file->keywords_hash = $file->keywords;
				$file->keywords = ci()->keywords->get_string($file->keywords);
				$file->formatted_date = format_date($file->date_added);
			}
		}

		return self::result(true, null, null, array('folder' => $folders, 'file' => $files, 'parent_id' => $parent));
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

		ci()->db->select('id, parent_id, slug, name')->order_by('sort');
		$all_folders = ci()->file_folders_m->get_all();

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
				return self::result(true, lang('files:container_exists'), $name);
			}
		}
		return self::result(false, lang('files:container_not_exists'), $name);
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

		return self::result(true, lang('files:item_updated'), $insert['name'], $insert);
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

		if ( ! $files = ci()->file_m->get_by('folder_id', $id) and ! ci()->file_folders_m->get_by('parent_id', $id))
		{
			ci()->file_folders_m->delete($id);

			return self::result(true, lang('files:item_deleted'), $folder->name);
		}
		else
		{
			return self::result(false, lang('files:folder_not_empty'), $folder->name);
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
	 * @param string $alt "alt" attribute, here so that it may be set when photos are initially uploaded
	 * @param array $allowed types	 	 
	 * @return array|bool
	 */
	public static function upload($folder_id, $name = false, $field = 'userfile', $width = false, $height = false, $ratio = false, $allowed_types = false, $alt = NULL, $replace_file = false)
	{
		if ( ! $check_dir = self::check_dir(self::$path))
		{
			return $check_dir;
		}

		if ( ! $check_cache_dir = self::check_dir(self::$_cache_path))
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
			$upload_config = array(
				'upload_path'	=> self::$path,
				'file_name'		=> $replace_file ? $replace_file->filename : self::$_filename,
				// if we want to replace a file, the file name should already be encrypted, the option was true then
				'encrypt_name'	=> (config_item('files:encrypt_filename') && ! $replace_file) ? TRUE : FALSE
			);

			// If we don't have allowed types set, we'll set it to the
			// current file's type.
			$upload_config['allowed_types'] = ($allowed_types) ? $allowed_types : self::$_ext;

			ci()->load->library('upload', $upload_config);

			if (ci()->upload->do_upload($field))
			{
				$file = ci()->upload->data();

				$data = array(
					'folder_id'		=> (int) $folder_id,
					'user_id'		=> (int) ci()->current_user->id,
					'type'			=> self::$_type,
					'name'			=> $replace_file ? $replace_file->name : $name ? $name : $file['orig_name'],
					'path'			=> '{{ url:site }}files/large/'.$file['file_name'],
					'description'	=> $replace_file ? $replace_file->description : '',
					'alt_attribute'	=> trim($replace_file ? $replace_file->alt_attribute : $alt),
					'filename'		=> $file['file_name'],
					'extension'		=> $file['file_ext'],
					'mimetype'		=> $file['file_type'],
					'filesize'		=> $file['file_size'],
					'width'			=> (int) $file['image_width'],
					'height'		=> (int) $file['image_height'],
					'date_added'	=> now()
				);

				// perhaps they want to resize it a bit as they upload
				if ($file['is_image'] and ($width or $height))
				{
					ci()->load->library('image_lib');

					$config['image_library']    = 'gd2';
					$config['source_image']     = self::$path.$data['filename'];
					$config['new_image']        = self::$path.$data['filename'];
					$config['maintain_ratio']   = (bool) $ratio;
					$config['width']            = $width ? $width : 0;
					$config['height']           = $height ? $height : 0;
					ci()->image_lib->initialize($config);
					ci()->image_lib->resize();

					$data['width'] = ci()->image_lib->width;
					$data['height'] = ci()->image_lib->height;					
				}

				if($replace_file)
				{
					$file_id = $replace_file->id;
					ci()->file_m->update($replace_file->id, $data);
				}
				else
				{
					$data['id'] = substr(md5(microtime()+$data['filename']), 0, 15);
					$file_id = $data['id'];
					ci()->file_m->insert($data);
				}

				if ($data['type'] !== 'i')
				{
					// so it wasn't an image. Now that we know the id we need to set the path as a download
					ci()->file_m->update($file_id, array('path' => '{{ url:site }}files/download/'.$file_id));
				}

				if ($folder->location !== 'local')
				{
					header("Connection: close");

					return Files::move($file_id, $data['filename'], 'local', $folder->location, $folder->remote_container);
				}

				header("Connection: close");

				return self::result(true, lang('files:file_uploaded'), $data['name'], array('id' => $file_id) + $data);
			}
			else
			{
				$errors = ci()->upload->display_errors();

				header("Connection: close");

				return self::result(false, $errors);
			}
		}
		else
		{
			header("Connection: close");

			return self::result(false, lang('files:specify_valid_folder'));
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
	public static function move($file_id, $new_name = false, $location = false, $new_location = 'local', $container = '')
	{
		$file = ci()->file_m->select('files.*, file_folders.name foldername, file_folders.slug, file_folders.location')
			->join('file_folders', 'files.folder_id = file_folders.id')
			->get_by('files.id', $file_id);

		if ( ! $file)
		{
			return self::result(false, lang('files:item_not_found'), $new_name ? $new_name : $file_id);
		}

		// this keeps a long running transaction from stalling the site
		session_write_close();

		// this would be used when move() is used during a rackspace or amazon upload as the location in the 
		// database is not the actual file location, its location is local temporarily
		if ($location) $file->location = $location;

		// if both locations are on the local filesystem then we just rename
		if ($file->location === 'local' and $new_location === 'local')
		{
			// if they were helpful enough to provide an extension then remove it
			$file_slug = self::create_slug(str_replace($file->extension, '', $new_name));
			$filename = $file_slug.$file->extension;

			// does the source exist?
			if (file_exists(self::$path.$file->filename))
			{
				$i = 1;

				// create a unique filename if the target already exists
				while (file_exists(self::$path.$filename)) 
				{
					// Example: test-image2.jpg
					$filename = $file_slug.$i.$file->extension;
					$i++;
				}

				$data = array('id' => $file_id,
							  'name' => $new_name,
							  'filename' => $filename,
							  'location' => $new_location,
							  'container' => $container);

				ci()->file_m->update($file_id, array('filename' => $filename, 'name' => $new_name));

				@rename(self::$path.$file->filename, self::$path.$filename);

				return self::result(true, lang('files:item_updated'), $new_name, $data);
			}
			else
			{
				return self::result(false, lang('files:item_not_found'), $file->name);
			}
		}
		// we'll be pushing the file from here to the cloud
		elseif ($file->location === 'local' and $new_location)
		{
			ci()->storage->load_driver($new_location);

			$containers = ci()->storage->list_containers();

			// if we try uploading to a non-existant container it gets ugly
			if (in_array($container, $containers))
			{
				// make a unique object name
				$object = now().'.'.$new_name;

				$path = ci()->storage->upload_file($container, self::$path.$file->filename, $object, null, 'public');

				if ($new_location === 'amazon-s3')
				{
					// if amazon didn't throw an error we'll create a path to store like rackspace does
					$url = ci()->parser->parse_string(Settings::get('files_s3_url'), array('bucket'=> $container), true);
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
					$config['maintain_ratio']	= false;
					$config['width']            = 75;
					$config['height']           = 50;
					ci()->image_lib->initialize($config);
					ci()->image_lib->resize();				
				}

				// get rid of the "temp" file
				@unlink(self::$path.$file->filename);

				$extra_data = array('id' => $file_id,
					'name' => $new_name,
					'location' => $new_location,
					'container' => $container);

				return self::result(true, lang('files:file_uploaded'), $new_name, $extra_data + $data);
			}

			return self::result(false, lang('files:invalid_container'), $container);
		}
		// pull it from the cloud to our filesystem
		elseif ($file->location and $new_location === 'local')
		{
			ci()->load->helper('file');
			ci()->load->spark('curl/1.2.1');

			// download the file... dum de dum
			$curl_result = ci()->curl->simple_get($file->path);

			if ($curl_result)
			{
				// if they were helpful enough to provide an extension then remove it
				$file_slug = self::create_slug(str_replace($file->extension, '', $new_name));
				$filename = $file_slug.$file->extension;

				// create a unique filename if the target already exists
				while (file_exists(self::$path.$filename)) 
				{
					// Example: test-image2.jpg
					$filename = $file_slug.$i.$file->extension;
					$i++;
				}

				// ...now save it
				write_file(self::$path.$filename, $curl_result, 'wb');

				$data = array('id' => $file_id,
					'name' => $new_name,
					'location' => $new_location,
					'container' => $container);

				return self::result(true, lang('files:file_moved'), $file->name, $data);
			}
			else
			{
				return self::result(false, lang('files:unsuccessful_fetch'), $file);
			}
		}
		// pulling from the cloud and then pushing to another part of the cloud :P
		elseif ($file->location and $new_location)
		{
			ci()->load->helper('file');
			ci()->storage->load_driver($new_location);

			// make a really random temp file name
			$temp_file = self::$path.md5(microtime()).'_temp_'.$new_name;

			// and we download...
			$curl_result = ci()->curl->simple_get($file);

			if ($curl_result)
			{
				write_file($temp_file, $curl_result, 'wb');
			}
			else
			{
				return self::result(false, lang('files:unsuccessful_fetch'), $file);
			}

			// make a unique object name
			$object = now().'.'.$new_name;

			$path = ci()->storage->upload_file($container, $temp_file, $object, null, 'public');

			if ($new_location === 'amazon-s3')
			{
				// if amazon didn't throw an error we'll create a path to store like rackspace does
				$url = ci()->parser->parse_string(Settings::get('files_s3_url'), array('bucket'=> $container), true);
				$path = rtrim($url, '/').'/'.$object;
			}

			$data = array('filename' => $object, 'path' => $path);

			// save its new location
			ci()->file_m->update($file->id, $data);

			// get rid of the "temp" file
			@unlink($temp_file);

			$extra_data = array('id' => $file_id,
				'name' => $new_name,
				'location' => $new_location,
				'container' => $container);

			return self::result(true, lang('files:file_moved'), $file->name, $extra_data + $data);
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
		$column = (strlen($identifier) === 15 or strpos($identifier, '.') === false) ? 
					'files.id' : 
					'filename';

		$results = ci()->file_m->select('files.*, file_folders.name folder_name, file_folders.slug folder_slug')
			->join('file_folders', 'file_folders.id = files.folder_id')
			->get_by($column, $identifier);

		$message = $results ? null : lang('files:no_records_found');

		return self::result( (bool) $results, $message, null, $results);
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

		$message = $results ? null : lang('files:no_records_found');

		return self::result( (bool) $results, $message, null, $results);
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
		if ($location !== 'local' and $container)
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
						$url = ci()->parser->parse_string(Settings::get('files_s3_url'), array('bucket'=> $container), true);
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
								return self::result(false, lang('files:enable_cdn'), $container);
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

		$message = $files ? null : lang('files:no_records_found');

		return self::result( (bool) $files, $message, null, $files);
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
						'id' 			=> substr(md5(microtime()+$data['filename']), 0, 15),
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

			return self::result(true, lang('files:synchronization_complete'), $folder->name, $files['data']);
		}
		else
		{
			return self::result(null, lang('files:no_records_found'));
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Rename a file
	 *
	 * @param	int		$id		The id of the file
	 * @param	string	$name	The new name
	 * @return	array
	 *
	**/
	public static function rename_file($id = 0, $name)
	{
		// physical filenames cannot be changed because of the risk of breaking embedded urls so we just change the db
		ci()->file_m->update($id, array('name' => $name));

		return self::result(true, lang('files:item_updated'), $name, array('id' => $id, 'name' => $name));
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete a file
	 *
	 * @param	int		$id		The id of the file
	 * @return	array
	 *
	**/
	public static function replace_file($to_replace, $folder_id, $name = false, $field = 'userfile', $width = false, $height = false, $ratio = false, $allowed_types = false, $alt_attribute = NULL)
	{
		if ($file_to_replace = ci()->file_m->select('files.*, file_folders.name foldername, file_folders.slug, file_folders.location, file_folders.remote_container')
			->join('file_folders', 'files.folder_id = file_folders.id')
			->get_by('files.id', $to_replace))
		{
			//remove the old file...
			self::_unlink_file($file_to_replace);

			//...then upload the new file
			$result = self::upload($folder_id, $name, $field, $width, $height, $ratio, $allowed_types, $alt_attribute, $file_to_replace);

			// remove files from cache
			if( $result['status'] == 1 )
			{
				//md5 the name like they do it back in the thumb function
				$cached_file_name = md5($file_to_replace->filename) . $file_to_replace->extension;
				$path = Settings::get('cache_dir') . 'image_files/';
				
				$cached_files = glob( $path . '*_' . $cached_file_name );

				foreach($cached_files as $full_path)
				{
					@unlink($full_path);
				}
			}

			return $result;
		}

		return self::result(false, lang('files:item_not_found'), $id);
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
			ci()->load->model('keywords/keyword_m');

			ci()->keyword_m->delete_applied($file->keywords);

			ci()->file_m->delete($id);

			self::_unlink_file($file);

			return self::result(true, lang('files:item_deleted'), $file->name);
		}

		return self::result(false, lang('files:item_not_found'), $id);
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

		if ($results['file'] or $results['folder'])
		{
			return self::result(true, null, null, $results);
		}

		return self::result(false, lang('files:no_records_found'));
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
	public static function result($status = true, $message = '', $args = false, $data = '')
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
			if (isset(ci()->permissions['files']) and array_key_exists($value, ci()->permissions['files']) or ci()->current_user->group == 'admin')
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
			array('status' 	=> false, 
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
		if (strpos($error, 'S3') !== false)
		{
			echo json_encode( 
				array('status' 	=> false, // clean up the error message to make it more readable
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
	public static function check_dir($path)
	{
		if (is_dir($path) and is_really_writable($path))
		{
			return self::result(true);
		}
		elseif ( ! is_dir($path))
		{
			if ( ! @mkdir($path, 0777, true))
			{
				return self::result(false, lang('files:mkdir_error'), $path);
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
				return self::result(false, lang('files:chmod_error'));
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
					self::$_filename	= trim(url_title($_FILES[$field]['name'], 'dash', true), '-');

					break;
				}
			}

			if ( ! self::$_ext)
			{
				return self::result(false, lang('files:invalid_extension'), $_FILES[$field]['name']);
			}
		}		
		elseif (ci()->method === 'upload')
		{
			return self::result(false, lang('files:upload_error'));
		}

		return self::result(true);
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

	/**
	 * Physically delete a file
	 * 
	 *
	 * @return	bool
	 *
	**/
	private static function _unlink_file($file)
	{
		if( ! isset($file->filename) )
		{
			return FALSE;
		}

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

		return TRUE;
	}
}
