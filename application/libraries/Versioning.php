<?php if (! defined('BASEPATH')) exit('No direct script access');
/**
 * I guess the description of this library is pretty obvious. For those who don't understand what this is all about, let me explain.
 * This library enables you to store data before updating it with a newer version. This means that if you ever want to go back to an older version you can, it's a bit like making a backup.
 *
 * @author 	Yorick Peterse - PyroCMS Dev Team
 * @link 	http://www.pyrocms.com/
 * @package PyroCMS
 * @subpackage Libraries
 * @category Libraries
 *
 */
class Versioning
{
	/**
	 * CodeIgniter instance variable
	 *
	 * @access private
	 * @var mixed
	 */
	private $ci;
	
	/**
	 * Variable containing the name of the table we're working with
	 * 
	 * @access private
	 * @var string
	 */
	private $table_name;
	
	/**
	 * Constructor method
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		// Get the CI instance
		$this->ci =& get_instance();
	}
	
	/**
	 * Set the name of the table
	 * 
	 * @access public
	 * @param string $name The name of the table
	 * @return void
	 */
	public function set_table($name)
	{
		if ( isset($name) )
		{
			$this->table_name = $name;
		}
		else
		{
			show_error('No name for the table has been specified');
		}
	}
	
	/**
	 * Get a single page along with it's latest revision
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the page to select
	 * @return object
	 */
	public function get($id)
	{
		// Create the query
		$query = $this->ci->db->select($this->table_name . '.*, revisions.id as revision_table_id, revisions.owner_id, revisions.table_name, revisions.body, revisions.revision_date, revisions.author_id') // Might not be needed, added for now...
			 ->from($this->table_name)
			 ->where($this->table_name . '.id', $id)
			 ->join('revisions', $this->table_name . '.revision_id = revisions.id')
			 ->get();
			
		// Return the results
		$result = $query->result();
		return $result[0];
	}
	
	/**
	 * Get all revisions for a specified page along with the name of user that created the revision
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the owner page
	 * @return array
	 */
	public function get_revisions($owner_id)
	{
		// Active Record baby!
		$query = $this->ci->db->select($this->table_name . '.title, revisions.*, users.username as author') 
			 ->from('revisions')
			 ->where('revisions.owner_id',$owner_id)
			 ->join($this->table_name, 'revisions.owner_id = ' . $this->table_name . '.id')
			 ->join('users', 'revisions.author_id = users.id')
			 ->get();
			
		// Return the results
		return $query->result();
	}
	
	/**
	 * Create a new revision
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $owner_id The ID of the page to which the revision belongs
	 * @param array $input The data used to create the revision
	 * @return bool
	 */
	public function create_revision($input)
	{
		// #TODO: Add some extra magic so the $input array becomes more dynamic
		// Set the revision date and figure out who created it
		$input['revision_date'] = now();
		$input['table_name']	= $this->table_name;
		
		// Create the revision
		if ( $this->ci->db->insert('revisions', $input) )
		{
			// Set the inserted ID
			$insert_id = $this->ci->db->insert_id();
			
			// Now that we've created a new revision we need to check whether the data has to be cleaned up
			$this->prune_revisions();
			
			// Return the inserted ID
			return $insert_id;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Change the revision of a page/news article/etc
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $row_id The ID of the row who's revision_id has to be changed
	 * @param int $revision_id The new revision ID
	 * @return void
	 */
	public function set_revision($row_id, $revision_id)
	{
		$this->ci->db->where('id', $row_id)
			 	 ->update($this->table_name, array('revision_id' => $revision_id));
	}
	
	/**
	 * Make sure only the latest 10 revisions are stored in the database, all others will be removed
	 * 
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function prune_revisions()
	{
		// Do we need to prune at all?
		$this->ci->db->where('table_name', $this->table_name);
		$this->ci->db->from('revisions');
		
		// We need to prune the data
		if ( $this->ci->db->count_all_results() > 10)
		{
			// Remove the oldest 5 revisions
			// query: SELECT * FROM revisions ORDER BY revision_date ASC LIMIT 5;
			$this->ci->db->order_by('revision_date', 'asc');
			$this->ci->db->limit(6);
			$this->ci->db->delete('revisions', array('table_name' => $this->table_name));
		}		
	}
}
?>