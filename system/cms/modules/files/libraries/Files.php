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

	// ------------------------------------------------------------------------

	public function __construct()
	{
		self::$_path = UPLOAD_PATH.'files/';
		self::$providers = explode(',', Settings::get('files_enabled_providers'));

		ci()->load->model('files/file_m');
		ci()->load->spark('cloudmanic-storage/1.0.4');
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
				return self::result(lang('files:file_not_found'), $file);
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

			return self::result(lang('files:invalid_container'), $container);
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
				return self::result(lang('files:unsuccessful_fetch'), $file);
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
				return self::result(lang('files:unsuccessful_fetch'), $file);
			}

			// shove it into the cloud and hope it stays
			$result = ci()->storage->upload_file($container, $temp_file, $new_file, NULL, 'public');

			@unlink($temp_file);

			return self::result($result);
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

		return self::result($message, NULL, $results);
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

		return self::result(NULL, NULL, $results);
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

		return self::result($message, NULL, $files);
	}

	// ------------------------------------------------------------------------

	/**
	 * Result
	 * 
	 * We return a status of true unless a failure message is specified
	 *
	 * @param	string	$message	The failure message to return
	 * @param	mixed	$args		Arguments to pass to sprint_f
	 * @param	mixed	$data		Any data to be returned
	 * @return	array
	 *
	**/
	protected static function result($message = '', $args = FALSE, $data = '')
	{
		if ( ! $message)
		{
			return array('status' => TRUE, 'message' => '', 'data' => $data);
		}
		else
		{
			// the method provided a failure message
			return array('status' => FALSE, 
						 'message' => $args ? sprintf($message, $args) : $message, 
						 'data' => $data
						 );
		}
	}
}