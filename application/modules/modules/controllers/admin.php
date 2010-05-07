<?php
/**
 * Modules controller, lists all installed modules
 * 
 * @author 		Yorick Peterse - PyroCMS Development Team
 * @package 	PyroCMS
 * @subpackage 	Core modules
 * @category 	Modules
 * @since 		v0.9.7
 */
class Admin extends Admin_Controller
{
	/**
	 * Constructor method
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::Admin_Controller();
		$this->lang->load('modules');
	}
	
	/**
	 * Index method
	 * @access public
	 * @return void
	 */
	public function index()
	{
 		$this->data->modules = $this->modules_m->get_modules(NULL, TRUE);
			  
		$this->template->build('admin/index', $this->data);
	}

	/**
	 * Install
	 *
	 * Installs a third_party module
	 *
	 * @access	public
	 * @return	void
	 */
	public function install()
	{
		// TODO: Write the install
		return;
	}

	/**
	 * Uninstall
	 *
	 * Uninstalls a third_party module
	 *
	 * @param	string	$module_slug	The slug of the module to uninstall
	 * @access	public
	 * @return	void
	 */
	public function uninstall($module_slug = '')
	{
		// TODO: Figure out how to uninstall
		return;

		// Don't allow user to delete the entire module folder
		if($module_slug == '/' || $module_slug == '*' || empty($module_slug))
		{
			show_error(lang('modules.module_not_specified'));
		}

		$path = 'third_party/modules/' . $module_slug;

		if($this->_delete_recursive($path))
		{
			$this->session->set_flashdata('success', lang('modules.uninstall_success'));
			redirect('admin/modules');
		}
		$this->session->set_flashdata('error', lang('modules.uninstall_error'));
		redirect('admin/modules');
	}

	/**
	 * Enable
	 *
	 * Enables a third_party module
	 *
	 * @param	string	$module_slug	The slug of the module to enable
	 * @access	public
	 * @return	void
	 */
	public function enable($module_slug)
	{
		if($this->modules_m->enable($module_slug))
		{
			// Clear the module cache
			$this->cache->delete_all('modules_m');
			$this->session->set_flashdata('success', sprintf(lang('modules.enable_success'), $module_slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('modules.enable_error'), $module_slug));
		}

		redirect('admin/modules');
	}

	/**
	 * Disable
	 *
	 * Disables a third_party module
	 *
	 * @param	string	$module_slug	The slug of the module to disable
	 * @access	public
	 * @return	void
	 */
	public function disable($module_slug)
	{
		if($this->modules_m->disable($module_slug))
		{
			// Clear the module cache
			$this->cache->delete_all('modules_m');
			$this->session->set_flashdata('success', sprintf(lang('modules.disable_success'), $module_slug));
		}
		else
		{
			$this->session->set_flashdata('error', sprintf(lang('modules.disable_error'), $module_slug));
		}

		redirect('admin/modules');
	}

	/**
	 * Delete Recursive
	 *
	 * Recursively delete a folder
	 *
	 * @param	string	$str	The path to delete
	 * @return	bool
	 */
	private function _delete_recursive($str)
	{
        if(is_file($str))
		{
            return @unlink($str);
        }
		elseif(is_dir($str))
		{
            $scan = glob(rtrim($str,'/').'/*');

			foreach($scan as $index => $path)
			{
                $this->_delete_recursive($path);
            }

            return @rmdir($str);
        }
    }

	/**
	 * Extract Zip
	 *
	 * Extracts a zip file.
	 *
	 * @param	string	$zip_dir		The directory of the zip file
	 * @param	string	$zip_file		The zip file
	 * @param	string	$extract_to		The directory used to store the extracted files
	 * @param	string	$dir_from_zip	No idea...
	 * @return	bool
	 */
	private function _extract_zip( $zip_dir = '' , $zip_file = '', $extract_to = '', $dir_from_zip = '' )
	{
		$zip = zip_open($zip_dir.$zip_file);

		if ($zip)
		{
			while ($zip_entry = zip_read($zip))
			{
				$completePath = $extract_to . dirname(zip_entry_name($zip_entry));
				$completeName = $extract_to . zip_entry_name($zip_entry);

				// Walk through path to create non existing directories
				// This won't apply to empty directories ! They are created further below
				if(!file_exists($completePath) && preg_match( '#^' . $dir_from_zip .'.*#', dirname(zip_entry_name($zip_entry)) ) )
				{
					$tmp = '';
					foreach(explode('/',$completePath) AS $k)
					{
						$tmp .= $k.'/';
						if(!file_exists($tmp) )
						{
							@mkdir($tmp, 0777);
						}
					}
				}

				if (zip_entry_open($zip, $zip_entry, "r"))
				{
					if( preg_match( '#^' . $dir_from_zip .'.*#', dirname(zip_entry_name($zip_entry)) ) )
					{
						if ($fd = @fopen($completeName, 'w+'))
						{
							@fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
							fclose($fd);
						}
						else
						{
							// We think this was an empty directory
							@mkdir($completeName, 0777);
						}
						zip_entry_close($zip_entry);
					}
				}
			}
			zip_close($zip);
		}
		return true;
	}
}
?>