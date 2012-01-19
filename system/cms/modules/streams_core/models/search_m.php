<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Streams Search Model
 *
 * @package		Streams
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Search_m extends CI_Model {

	private $CI;

	// --------------------------------------------------------------------------   

	function __construct()
	{
		$this->CI =& get_instance();
	}

	// --------------------------------------------------------------------------   

	/**
	 * Perform a search
	 *
	 * @access	public
	 * @param	string - the search term
	 * @param	string - the search type
	 * @param	string - the stream slug
	 * @param	string - fields to search (sep by |)
	 * @return 	int - cache id
	 */
	function perform_search($search_term, $search_type, $stream_slug, $fields)
	{
		// -------------------------------------
		// Separate our fields
		// -------------------------------------
		
		$fields = explode('|', $fields);
		
		// -------------------------------------
		// Get Stream Data
		// -------------------------------------
		
		$stream			= $this->CI->streams_m->get_stream($stream_slug, TRUE);
		
		if(!$stream) show_error($stream_slug.' '.lang('streams.not_valid_stream'));
	
		// -------------------------------------
		// Hose off the Keywords
		// -------------------------------------
		
		$keywords 		= $this->CI->security->xss_clean($search_term);
		
		$keywords		= explode(" ", $keywords);
		
		// Break into keywords
		foreach($keywords as $key => $keyword):
		
			if(trim($keyword) == ''):
			
				unset($keywords[$key]);
			
			endif;
		
		endforeach;
		
		// -------------------------------------
		// Query Build
		// -------------------------------------
				
		$likes = array();
		
		if($search_type == 'keywords'):
		
			$keyword_build = '';
		
			// Go through each keyword/field individually
			foreach($keywords as $keyword):
			
				$keyword_build .= $keyword.' ';
			
				foreach($fields as $field):
				
					$likes[] = "$field LIKE '%$keyword%'";
					//$this->CI->db->or_like($field, $keyword);
					
					// We also search cumulative keywords
					$likes[] = "$field LIKE '%$keyword_build%'";
					//$this->CI->db->or_like($field, $keyword_build);
				
				endforeach;
				
			endforeach;
		
		endif;
		
		if($search_type == 'full_phrase'):
		
			$search_for = implode(' ', $keywords);
		
			foreach($fields as $field):
				
				// We also search cumulative keywords
				//$this->CI->db->or_like($field, $search_for);
				$likes[] = "$field LIKE '%$search_for%'";
			
			endforeach;
		
		endif;

		// Build query sans limit/offset
		$query_string = 'SELECT * FROM '.$this->CI->db->dbprefix(STR_PRE.$stream_slug).' WHERE ('.implode(' OR ', $likes).')';

		// Get total of all the results
		$total = $this->CI->db->query($query_string);

		// -------------------------------------
		// Save Query to DB Cache
		// -------------------------------------
	
		$insert_data = array(
			'search_id' 		=> md5(rand()),
			'search_term'		=> $search_term,
			'ip_address'		=> $this->CI->input->ip_address(),
			'total_results'		=> $total->num_rows(),
			'query_string'		=> base64_encode($query_string),
			'stream_slug'		=> $stream_slug
		);
		
		$this->CI->db->insert(SEARCH_TABLE, $insert_data);
		
		// Return our hash for the URL
		return $insert_data['search_id'];
	}

	// --------------------------------------------------------------------------   
	
	function get_cache($cache_id)
	{
		$this->CI->db->limit(1)->where('search_id', $cache_id);
		$query = $this->CI->db->get(SEARCH_TABLE);
		
		if($query->num_rows() == 0):
		
			return FALSE;
		
		else:
		
			$cache = $query->row();
		
			// Decode
			$cache->query_string = base64_decode($cache->query_string);
			
			return $cache;
		
		endif;
	}

}

/* End of file search_m.php */