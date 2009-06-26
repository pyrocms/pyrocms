<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Upload extends CI_Upload
{	
	var $max_size		= 0;
	var $max_width		= 0;
	var $max_height		= 0;
	var $allowed_types	= "";
	var $file_temp		= "";
	var $file_name		= "";
	var $orig_name		= "";
	var $file_type		= "";
	var $file_size		= "";
	var $file_ext		= "";
	var $upload_path	= "";
	var $overwrite		= FALSE;
	var $new_name		= FALSE;
	var $encrypt_name	= FALSE;
	var $is_image		= FALSE;
	var $image_width	= '';
	var $image_height	= '';
	var $image_type		= '';
	var $image_size_str	= '';
	var $error_msg		= array();
	var $mimes			= array();
	var $remove_spaces	= TRUE;
	var $xss_clean		= FALSE;
	var $temp_prefix	= "temp_file_";
	
	function MY_Upload($props = array()) {
        parent::CI_Upload();

		if (count($props) > 0)
		{
			$this->initialize($props);
		}
		
    }
 
	// --------------------------------------------------------------------
	
	/**
	 * Initialize preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */	
	function initialize($config = array())
	{
		$defaults = array(
							'max_size'			=> 0,
							'max_width'			=> 0,
							'max_height'		=> 0,
							'allowed_types'		=> "",
							'file_temp'			=> "",
							'file_name'			=> "",
							'orig_name'			=> "",
							'file_type'			=> "",
							'file_size'			=> "",
							'file_ext'			=> "",
							'upload_path'		=> "",
							'overwrite'			=> FALSE,
							'new_name'			=> FALSE,
							'encrypt_name'		=> FALSE,
							'is_image'			=> FALSE,
							'image_width'		=> '',
							'image_height'		=> '',
							'image_type'		=> '',
							'image_size_str'	=> '',
							'error_msg'			=> array(),
							'mimes'				=> array(),
							'remove_spaces'		=> TRUE,
							'xss_clean'			=> FALSE,
							'temp_prefix'		=> "temp_file_"
						);	
	
		foreach ($defaults as $key => $val)
		{
			if (isset($config[$key]))
			{
				$method = 'set_'.$key;
				if (method_exists($this, $method))
				{
					$this->$method($config[$key]);
				}
				else
				{
					$this->$key = $config[$key];
				}			
			}
			else
			{
				$this->$key = $val;
			}
		}
	}

	/**
	 * Perform the file upload
	 *
	 * @access	public
	 * @return	bool
	 */	
	function do_upload($field = 'userfile')
	{
		// Is $_FILES[$field] set? If not, no reason to continue.
		if ( ! isset($_FILES[$field]))
		{
			$this->set_error('upload_no_file_selected');
			return FALSE;
		}
		
		// Is the upload path valid?
		if ( ! $this->validate_upload_path())
		{
			// errors will already be set by validate_upload_path() so just return FALSE
			return FALSE;
		}
								
		// Was the file able to be uploaded? If not, determine the reason why.
		if ( ! is_uploaded_file($_FILES[$field]['tmp_name']))
		{
			$error = ( ! isset($_FILES[$field]['error'])) ? 4 : $_FILES[$field]['error'];

			switch($error)
			{
				case 1:	// UPLOAD_ERR_INI_SIZE
					$this->set_error('upload_file_exceeds_limit');
					break;
				case 2: // UPLOAD_ERR_FORM_SIZE
					$this->set_error('upload_file_exceeds_form_limit');
					break;
				case 3: // UPLOAD_ERR_PARTIAL
				   $this->set_error('upload_file_partial');
					break;
				case 4: // UPLOAD_ERR_NO_FILE
				   $this->set_error('upload_no_file_selected');
					break;
				case 6: // UPLOAD_ERR_NO_TMP_DIR
					$this->set_error('upload_no_temp_directory');
					break;
				case 7: // UPLOAD_ERR_CANT_WRITE
					$this->set_error('upload_unable_to_write_file');
					break;
				case 8: // UPLOAD_ERR_EXTENSION
					$this->set_error('upload_stopped_by_extension');
					break;
				default :   $this->set_error('upload_no_file_selected');
					break;
			}

			return FALSE;
		}

		// Set the uploaded data as class variables
		$this->file_temp = $_FILES[$field]['tmp_name'];		
		$this->file_name = $this->_prep_filename($_FILES[$field]['name']);
		$this->file_size = $_FILES[$field]['size'];		
		$this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type']);
		$this->file_type = strtolower($this->file_type);
		$this->file_ext	 = $this->get_extension($_FILES[$field]['name']);
		
		// Convert the file size to kilobytes
		if ($this->file_size > 0)
		{
			$this->file_size = round($this->file_size/1024, 2);
		}

		// Is the file type allowed to be uploaded?
		if ( ! $this->is_allowed_filetype())
		{
			$this->set_error('upload_invalid_filetype');
			return FALSE;
		}

		// Is the file size within the allowed maximum?
		if ( ! $this->is_allowed_filesize())
		{
			$this->set_error('upload_invalid_filesize');
			return FALSE;
		}

		// Are the image dimensions within the allowed size?
		// Note: This can fail if the server has an open_basdir restriction.
		if ( ! $this->is_allowed_dimensions())
		{
			$this->set_error('upload_invalid_dimensions');
			return FALSE;
		}

		// Sanitize the file name for security
		$this->file_name = $this->clean_file_name($this->file_name);

		// Remove white spaces in the name
		if ($this->remove_spaces == TRUE)
		{
			$this->file_name = preg_replace("/\s+/", "_", $this->file_name);
		}

		/*
		 * Validate the file name
		 * This function appends an number onto the end of
		 * the file if one with the same name already exists.
		 * If it returns false there was a problem.
		 */
		$this->orig_name = $this->file_name;		
		$this->file_name = $this->set_filename($this->upload_path, $this->file_name);
		
		/*
		 * Check if we need to replace the uploaded file name
		 * Added by MrEnirO for StyleCMS
		 */
		if ($this->new_name != FALSE)
		{
			$this->file_name = $this->set_filename($this->upload_path, $this->new_name.$this->file_ext);
		}		
			
		if ($this->file_name === FALSE)
		{
			return FALSE;
		}
		
		
		if ($this->overwrite == TRUE)
		{
			if(file_exists($this->upload_path.$this->file_name))
			{
				@unlink($this->upload_path.$this->file_name);
			}
		}
		
		/*
		 * Move the file to the final destination
		 * To deal with different server configurations
		 * we'll attempt to use copy() first.  If that fails
		 * we'll use move_uploaded_file().  One of the two should
		 * reliably work in most environments
		 */		
		if (!@copy($this->file_temp, $this->upload_path.$this->file_name))
		{
			if (!@move_uploaded_file($this->file_temp, $this->upload_path.$this->file_name))
			{
				 $this->set_error('upload_destination_error');
				 return FALSE;
			}
		}
		
		/*
		 * Run the file through the XSS hacking filter
		 * This helps prevent malicious code from being
		 * embedded within a file.  Scripts can easily
		 * be disguised as images or other file types.
		 */
		if ($this->xss_clean == TRUE)
		{
			$this->do_xss_clean();
		}

		/*
		 * Set the finalized image dimensions
		 * This sets the image width/height (assuming the
		 * file was an image).  We use this information
		 * in the "data" function.
		 */
		$this->set_image_properties($this->upload_path.$this->file_name);

		return TRUE;
	}
	
	/**
	 * Set the file name
	 *
	 * This function takes a filename/path as input and looks for the
	 * existence of a file with the same name. If found, it will append a
	 * number to the end of the filename to avoid overwriting a pre-existing file.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	string
	 */	
	function set_filename($path, $filename)
	{
		if ($this->encrypt_name == TRUE)
		{		
			$filename_hash = md5($filename).$this->file_ext;	
		}
					
		if ($this->overwrite == FALSE)
		{		
			if(!file_exists($path.$filename_hash))
			{
				return $filename_hash;
			}
			
			$filename_hash = str_replace($this->file_ext, '', $filename_hash);
		
			$new_filename = '';
			for ($i = 1; $i < 100; $i++)
			{			
				if (!file_exists($path.$filename_hash.'_'.$i.$this->file_ext))
				{
					$new_filename = $filename_hash.'_'.$i.$this->file_ext;
					break;
				}
			}
	
			if ($new_filename == '')
			{
				$this->set_error('upload_bad_filename');
				return FALSE;
			}
			else
			{
				return $new_filename;
			}
		}
		return $filename_hash;
	}
	
	// --------------------------------------------------------------------
	
}
