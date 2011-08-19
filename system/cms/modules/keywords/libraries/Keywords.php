<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * PyroCMS
 *
 * An open source CMS based on CodeIgniter
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @license		http://pyrocms.com/legal/license
 * @link		http://pyrocms.com/
 * @since		Version 1.4
 */

/**
 * Keywords Library
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS
 * @subpackage	Libraries
 * @category	Keywords
 */
class Keywords {

	protected $ci;

	/**
	 * The Keywords Construct
	 */
	public function __construct()
	{
		ci()->load->model('keywords/keyword_m');
		
		/*
		$this->ci =& get_instance();
		$this->ci->lang->load('keywords/keywords');

		$this->get_all();
		*/
	}

	/**
	 * Get keywords
	 *
	 * Gets all the keywords
	 *
	 * @param	string	$hash	The unique hash stored for a entry
	 * @return	array
	 */
	public function get_string($hash)
	{
		$keywords = array();
		
		foreach (ci()->keyword_m->get_applied($hash) as $keyword)
		{
			$keywords[] = $keyword->name;
		}
		
		return implode(', ', $keywords);
	}

	/**
	 * Add Keyword
	 *
	 * Adds a new keyword to the database
	 *
	 * @param	array	$keyword
	 * @return	int
	 */
	public function add($keyword)
	{
		return ci()->keyword_m->insert(array('name' => self::prep(singular($keyword))));
	}

	/**
	 * Prepare Keyword
	 *
	 * Gets a keyword ready to be saved
	 *
	 * @param	string	$keyword
	 * @return	bool
	 */
	public function prep($keyword)
	{
		return strtolower(trim($keyword));
	}

	/**
	 * Process Keywords
	 *
	 * Process a posted list of keywords into the db
	 *
	 * @param	string	$group	Arbitrary string to "namespace" unique requests
	 * @param	string	$keywords	String containing unprocessed list of keywords
	 * @param	string	$old_hash	If running an update, provide the old hash so we can remove it
	 * @return	string
	 */
	public function process($keywords, $old_hash = null)
	{	
		// No keywords? Let's not bother then
		if ( ! ($keywords = trim($keywords)))
		{
			return '';
		}
		
		// Remove the old keyword assignments if we're updating
		if (is_string($old_hash))
		{
			ci()->db->where('hash', $old_hash)->get('keywords_applied');
		}
		
		$assignment_hash = md5(microtime().mt_rand());
		
		// Split em up and prep away
		$keywords = explode(',', $keywords);
		foreach ($keywords as &$keyword)
		{
			$keyword = self::prep($keyword);
		/*
		// Find out which keywords are already being used	
		$matched = array_map(function($row) {
			if ($row) return ($row->name;
		}, ci()->db->where_in('name', $keywords)->get('keywords')->result());
		
		*/
			// Keyword already exists
			if (($row = ci()->db->where('name', $keyword)->get('keywords')->row()))
			{
				$keyword_id = $row->id;
			}
			
			// Create it, and keep the record
			else
			{
				$keyword_id = self::add($keyword);
			}
			
			// Create assignment record
			ci()->db->insert('keywords_applied', array(
				'hash' => $assignment_hash,
				'keyword_id' => $keyword_id,
			));
		}
		
		return $assignment_hash;
	}

}

/* End of file Keywords.php */
