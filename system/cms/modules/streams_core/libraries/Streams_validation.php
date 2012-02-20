<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Streams Validation Library
 *
 * Contains custom functions that cannot be used in a
 * callback method.
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Libraries
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Streams_validation extends CI_Form_validation
{
	function __construct()
	{
		$this->CI = get_instance();
	}

	// --------------------------------------------------------------------------

	/**
	 * Check captcha callback
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */
	function check_captcha($val)
	{
		if ($this->CI->recaptcha->check_answer(
						$this->CI->input->ip_address(),
						$this->CI->input->post('recaptcha_challenge_field'),
						$val))
		{
	    	return true;
		}
		else
		{
			$this->CI->streams_validation->set_message(
						'check_captcha',
						$this->CI->lang->line('recaptcha_incorrect_response'));
			
			return false;
	    }
	}

	// --------------------------------------------------------------------------

	/**
	 * Is unique
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @param	obj
	 * @return	bool
	 */
	public function unique($string, $data)
	{
		// Split the data
		$items = explode(":", $data);
		
		$column 	= trim($items[0]);
		$mode 		= $items[1];
		$stream_id	= $items[2];
		
		// Get the stream
		$stream = $this->CI->streams_m->get_stream($stream_id);
			
		$this->CI->db->where(trim($column), trim($string));
		
		$obj = $this->CI->db->get($stream->stream_prefix.$stream->stream_slug);
		
		if ($mode == 'new')
		{
			if ($obj->num_rows() == 0)
			{
				return true;
			}
		}
		elseif ($mode == 'edit')
		{
			// We need to see if the new value is different.
			$existing = $this->CI->db
				->select($column)
				->limit(1)
				->where( 'id', $this->CI->input->post('row_edit_id'))
				->get($stream->stream_prefix.$stream->stream_slug)
				->row();
			
			if ($existing->$column == $string)
			{
				// No change
				if ($obj->num_rows() >= 1) return true;
			}
			else
			{
				// There was a change. We treat it as new now.
				if($obj->num_rows() == 0) return true;
			}
		}

		$this->CI->streams_validation->set_message('unique', lang('streams.field_unique'));
	
		return FALSE;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * File is Required
	 *
	 * Tricky function that checks various inputs needed for files
	 * to see if one is indeed added.
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function file_required($string, $field)
	{
		// Do we already have something? If we are editing the row,
		// the file may already be there. We know that if the ID has a
		// numerical value, since it is hooked up with the PyroCMS
		// file system.
		if (is_numeric($this->CI->input->post($field)))
		{
			return true;
		}
		
		// OK. Now we really need to make sure there is a file here.
		// The method of choice here is checking for a file name		
		if (isset($_FILES[$field.'_file']['name']) and $_FILES[$field.'_file']['name'] != '')
		{
			// Don't do shit.
		}			
		else
		{
			$this->CI->streams_validation->set_message('file_required', lang('streams.field_is_required'));
			return false;
		}

		return null;
	}

	// --------------------------------------------------------------------------

	/**
	 * Unique field slug
	 *
	 * Checks to see if the slug is unique based on the 
	 * circumstances
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function unique_field_slug($field_slug, $mode)
	{
		$db_obj = $this->CI->db
						->select('id')
						->where('field_slug', trim($field_slug))
						->get(FIELDS_TABLE);
		
		if ($mode == 'new')
		{
			if( $db_obj->num_rows() > 0)
			{
				$this->set_message('unique_field_slug', lang('streams.field_slug_not_unique'));
				return false;
			}	
		}
		else
		{
			// Mode should be the existing slug
			if ($field_slug != $mode)
			{
				// We're changing the slug?
				// Better make sure it doesn't exist.
				if ($db_obj->num_rows() != 0)
				{
					$this->set_message('unique_field_slug', lang('streams.field_slug_not_unique'));
					return false;
				}			
			}
		}

		return true;		
	}

	// --------------------------------------------------------------------------

	/**
	 * Unique Stream Slug
	 *
	 * Checks to see if the stream is unique based on the 
	 * stream_slug
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	public function stream_unique($stream_slug, $mode)
	{
		$this->CI->db->select('id')->where('stream_slug', trim($stream_slug));
		$db_obj = $this->CI->db->get(STREAMS_TABLE);
		
		if ($mode == 'new')
		{
			if ($db_obj->num_rows() > 0)
			{
				$this->set_message('stream_unique', lang('streams.stream_slug_not_unique'));
				return false;	
			}
		}	
		else
		{
			// Mode should be the existing slug
			// We check the two to see if the slug is changing.
			// If it is changing we of course need to make sure
			// it is unique.
			if ($stream_slug != $mode)
			{
				if ($db_obj->num_rows() != 0)
				{
					$this->set_message('stream_unique', lang('streams.stream_slug_not_unique'));
					return false;
				}
			}
		}

		return true;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * Slug Safe
	 *
	 * Sees if a word is safe for the DB. Used for
	 * stream_fields, etc.
	 */
	public function slug_safe($string)
	{	
		// See if word is MySQL Reserved Word
		if (in_array(strtoupper($string), $this->CI->config->item('streams:reserved')))
		{
			$this->set_message('slug_safe', lang('streams.not_mysql_safe_word'));
			return false;
		}
				
		// See if there are no-no characters
		if ( ! preg_match("/^([-a-z0-9_-])+$/i", $string))
		{
			$this->set_message('slug_safe', lang('streams.not_mysql_safe_characters'));
			return false;
		}
		
		return true;
	}

	// --------------------------------------------------------------------------

	/**
	 * Make sure a type is valid
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	public function type_valid($string)
	{
		if ($string == '-')
		{
			$this->set_message('type_valid', lang('streams.type_not_valid'));
			return false;
		}	
		
		return true;
	}

}