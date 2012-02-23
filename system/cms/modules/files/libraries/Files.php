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
	protected 	static $_path;
	protected 	static $_ext;
	protected	static $_type = '';
	protected	static $_filename = NULL;

	// ------------------------------------------------------------------------

	public function __construct()
	{
		ci()->load->config('files/files');

		self::$_path = config_item('files:path');
		self::$providers = explode(',', Settings::get('files_enabled_providers'));

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

		return self::result(TRUE, lang('files:folder_created'), $insert['name'], $insert);
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
			->get_all();

		$files = ci()->file_m->where('folder_id', $parent)
			->get_all();

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

		return self::result(TRUE, lang('files:folder_updated'), $insert['name'], $insert);
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

			return self::result(TRUE, lang('files:folder_deleted'), $folder->name);
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

		if ( ! $check_ext = self::_check_ext()) return $check_ext;

		$folder = ci()->file_folders_m->get($folder_id);

		if ($folder AND $folder->location === 'local')
		{
			ci()->load->library('upload', array(
				'upload_path'	=> self::$_path,
				'allowed_types'	=> self::$_ext,
				'file_name'		=> self::$_filename
			));

			if (ci()->upload->do_upload())
			{
				$file = ci()->upload->data();
				$data = array(
					'folder_id'		=> (int) $folder_id,
					'user_id'		=> (int) ci()->current_user->id,
					'type'			=> self::$_type,
					'name'			=> $name,
					'description'	=> '',
					'filename'		=> $file['file_name'],
					'extension'		=> $file['file_ext'],
					'mimetype'		=> $file['file_type'],
					'filesize'		=> $file['file_size'],
					'width'			=> (int) $file['image_width'],
					'height'		=> (int) $file['image_height'],
					'date_added'	=> now()
				);

				ci()->file_m->insert($data);

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
	 * @param	string	$file			The old filename
	 * @param	string	$new_file		The desired filename
	 * @param	string	$location		local, aws, cloudfiles, etc
	 * @param	string	$new_location	The desired provider to move the file to
	 * @param	string	$container		The bucket, container, or folder to move the file to
	 * @return	array
	**/
	public static function move($file, $new_file, $location = 'local', $new_location = 'local', $container = '')
	{
		// if both locations are on the local filesystem then we just rename
		if ($location === 'local' AND $new_location === 'local')
		{
			if (file_exists(self::$_path.$file))
			{
				@rename(self::$_path.$file, self::$_path.$new_file);

				return self::result();
			}
			else
			{
				return self::result(FALSE, lang('files:file_not_found'), $file);
			}
		}
		// we'll be pushing the file from here to the cloud
		elseif ($location === 'local' AND $new_location)
		{
			ci()->storage->load_driver($new_location);

			$containers = ci()->storage->list_containers();

			// if we try uploading to a non-existant container it gets ugly
			if (in_array($container, $containers))
			{
				ci()->storage->upload_file($container, self::$_path.$file, $new_file, NULL, 'public');

				return self::result();
			}

			return self::result(FALSE, lang('files:invalid_container'), $container);
		}
		// pull it from the cloud to our filesystem
		elseif ($location AND $new_location === 'local')
		{
			ci()->load->helper('file');
			ci()->load->spark('curl/1.2.1');

			// download the file... dum de dum
			$curl_result = ci()->curl->simple_get($file);

			if ($curl_result)
			{
				// ...and save it
				write_file(self::$_path.$new_file, $curl_result, 'wb');
			}
			else
			{
				return self::result(FALSE, lang('files:unsuccessful_fetch'), $file);
			}
		}
		// pulling from the cloud and then pushing to another part of the cloud :P
		elseif ($location AND $new_location)
		{
			ci()->load->helper('file');
			ci()->storage->load_driver($new_location);

			// make a really random temp file name
			$temp_file = self::$_path.md5(time()).'_temp_'.$new_file;

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

			// shove it into the cloud and hope it stays
			$result = ci()->storage->upload_file($container, $temp_file, $new_file, NULL, 'public');

			@unlink($temp_file);

			return self::result( (bool)$result, $result);
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
	protected static function result($status = TRUE, $message = '', $args = FALSE, $data = '')
	{
		return array('status' 	=> $status, 
					 'message' 	=> $args ? sprintf($message, $args) : $message, 
					 'data' 	=> $data
					 );
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
	private static function _check_ext()
	{
		if ( ! empty($_FILES['userfile']['name']))
		{
			$ext		= pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$allowed	= config_item('files:allowed_file_ext');

			foreach ($allowed as $type => $ext_arr)
			{				
				if (in_array(strtolower($ext), $ext_arr))
				{
					self::$_type		= $type;
					self::$_ext			= implode('|', $ext_arr);
					self::$_filename	= trim(url_title($_FILES['userfile']['name'], 'dash', TRUE), '-');

					break;
				}
			}

			if ( ! self::$_ext)
			{
				return self::result(FALSE, lang('files:invalid_extension'), $_FILES['userfile']['name']);
			}
		}		
		elseif ($this->method === 'upload')
		{
			return self::result(FALSE, lang('files:upload_error'));
		}

		return self::result(TRUE);
	}
}