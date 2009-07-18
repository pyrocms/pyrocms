<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller
{
	function __construct()
	{
		parent::Admin_Controller();
		$this->load->model('themes_m');
		$this->lang->load('themes');
	}
	
	// Admin: List all Themes
	function index()
	{
		$this->layout->extra_head(css('themes.css', 'themes'));
		$this->data->themes = $this->themes_m->getThemes();		
		$this->layout->create('admin/index', $this->data);
	}
	
	function set_default($theme_name = "")
	{	
		if($this->themes_m->setDefault($theme_name))
		{
			$this->session->set_flashdata('success', sprintf($this->lang->line('theme_set_default_success'), $theme_name));
		} 
		else
		{
			$this->session->set_flashdata('error', sprintf($this->lang->line('theme_set_default_error'), $theme_name));
		}		
		redirect('admin/themes');
	}
	
	function upload()
	{	
		if($this->input->post('btnAction') == 'upload')
		{	
			$config['upload_path'] = APPPATH.'uploads/';
			$config['allowed_types'] = 'zip';
			$config['max_size']	= '2048';
			$config['overwrite'] = TRUE;	
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload())
			{
				$upload_data = $this->upload->data();
				
				// Check if we already have a dir with same name
				if(file_exists(APPPATH."themes/".$upload_data['raw_name']))
				{
					$this->session->set_flashdata('error', $this->lang->line('theme_already_exists_error'));
				}
				else
				{
					// Now try to unzip
					$this->_extractZip($upload_data['file_path'], $upload_data['file_name'], APPPATH."assets/themes/", $upload_data['raw_name'] );
					
					// Check if we unziped the file
					if(!file_exists(APPPATH."themes/".$upload_data['raw_name']))
					{
						$this->session->set_flashdata('error', $this->lang->line('theme_extract_error'));
					}
					else
					{
						$this->session->set_flashdata('success', $this->lang->line('theme_upload_success'));
					}
				}
				// Delete uploaded file
				@unlink($upload_data['full_path']);
			}
			else
			{
				$this->session->set_flashdata('error', $this->upload->display_errors());
			}	
			redirect('admin/themes/upload');
		}
		
		$this->layout->create('admin/upload', $this->data);
	}
	
	function delete($theme_name = "")
	{
		$this->load->helper('file');	
		$name_array = $theme_name != "" ? array($theme_name) : $this->input->post('action_to');
	
		// Delete multiple
		if(!empty($name_array))
		{
			$deleted = 0;
			$to_delete = 0;
			foreach ($name_array as $theme_name) 
			{
				$theme_name = urldecode($theme_name);			
				$to_delete++;
			
				if($this->settings->item('default_theme') == $theme_name)
				{
					$this->session->set_flashdata('error', sprintf($this->lang->line('theme_default_delete_error'), $theme_name));
				}		
				else
				{
					$theme_dir = APPPATH.'themes/'.$theme_name;
					delete_files($theme_dir, TRUE);
					
					if(@rmdir($theme_dir))
					{
						$deleted++;
					}
					else
					{
						$this->session->set_flashdata('error', sprintf($this->lang->line('theme_delete_error')), $theme_name);
					}
				}
			}
		
			if( $deleted == $to_delete)
			{
				$this->session->set_flashdata('success', sprintf($this->lang->line('theme_mass_delete_success'), $delete, $to_delete));
			}	
			else
			{
				$this->session->set_flashdata('error', sprintf($this->lang->line('theme_mass_delete_error')), $delete, $to_delete);
			}	
		}	
		else
		{
			$this->session->set_flashdata('error', $this->lang->line('theme_delete_select_error'));
		}	
		redirect('admin/themes');
	}
	
	
	function _extractZip( $zipDir = '' , $zipFile = '', $extractTo = '', $dirFromZip = '' )
	{	
		$zip = zip_open($zipDir.$zipFile);
		
		if ($zip)
		{
			while ($zip_entry = zip_read($zip))
			{
				$completePath = $extractTo . dirname(zip_entry_name($zip_entry));
				$completeName = $extractTo . zip_entry_name($zip_entry);
			
				// Walk through path to create non existing directories
				// This won't apply to empty directories ! They are created further below
				if(!file_exists($completePath) && preg_match( '#^' . $dirFromZip .'.*#', dirname(zip_entry_name($zip_entry)) ) )
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
					if( preg_match( '#^' . $dirFromZip .'.*#', dirname(zip_entry_name($zip_entry)) ) )
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