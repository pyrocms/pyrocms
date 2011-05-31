<?php defined('BASEPATH') OR exit('No direct script access');

/**
 * I guess the description of this library is pretty obvious. For those who don't understand what this is all about, let me explain.
 * This library enables you to store data before updating it with a newer version. This means that if you ever want to go back to an older version you can, it's a bit like making a backup.
 *
 * @author 		Yorick Peterse - PyroCMS Dev Team
 * @link 		http://www.pyrocms.com/
 * @package 	PyroCMS
 * @subpackage 	Libraries
 * @category 	Libraries
 *
 */
class Versioning {
	/**
	 * CodeIgniter instance variable
	 *
	 * @access private
	 * @var mixed
	 */
	private $_ci;

	/**
	 * Variable containing the name of the table we're working with
	 *
	 * @access private
	 * @var string
	 */
	private $_table_name		= NULL;
	private $_show_word_diff	= FALSE;

	/**
	 * Constructor method
	 *
	 * @access public
	 * @return void
	 */
	public function __construct($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (property_exists($this, '_' . $key))
			{
				$this->{'_' . $key} = $val;
			}
		}

		$this->_ci =& get_instance();
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
		if ( ! isset($name) )
		{
			show_error('No name for the table has been specified');
		}

		$this->_table_name = $name;
	}

	/**
	 * Compare two strings and return the difference
	 *
	 * @author Yorick Peterse and Dan Horrigan
	 * @access public
	 * @param string $old The first block of data
	 * @param string $new The second block of data
	 * @param string $mode The mode to use. Possible values are normal, html and mixed
	 * @return string
	 */
	public function compare_revisions($old, $new, $mode = 'normal')
	{
		// Mixed
		if ( $mode === 'mixed')
		{
			// Insert characters
			$ins_begin 	= '<ins>+ ';
			$ins_end 	= '</ins>' . PHP_EOL;

			// Delete characters
			$del_begin 		= '<del>- ';
			$del_end		= '</del>' . PHP_EOL;
		}
		// HTML mode
		elseif ( $mode === 'html' )
		{
			// Insert characters
			$ins_begin 	= '<ins>';
			$ins_end 	= '</ins>' . PHP_EOL;

			// Delete characters
			$del_begin 	= '<del>';
			$del_end	= '</del>' . PHP_EOL;
		}
		// Normal mode
		else
		{
			// Insert characters
			$ins_begin 	= '+ ';
			$ins_end 	= PHP_EOL;

			// Delete characters
			$del_begin 	= '- ';
			$del_end	= PHP_EOL;
		}

		// Turn the strings into an array so it's a bit easier to parse them
		$diff	= $this->diff(explode(PHP_EOL, $old), explode(PHP_EOL, $new));
		$result	= '';

		foreach($diff as $line)
		{
			if (is_array($line))
			{
				if ($this->_show_word_diff)
				{
					// Highlight
					$highlight_begin	= '[pyro:highlight]';
					$highlight_end		= '[/pyro:highlight]';

					$words_diff	= $this->diff(str_split(implode(PHP_EOL, $line['del'])), str_split(implode(PHP_EOL, $line['ins'])));

					$line['ins'] = '';
					$line['del'] = '';

					foreach ($words_diff as $word)
					{
						if (is_array($word))
						{
							foreach (array('del', 'ins') as $key)
							{
								if ( ! empty($word[$key]))
								{
									$word[$key] = explode(PHP_EOL, implode('', $word[$key]));

									$line[$key] .= $highlight_begin . implode($highlight_end . PHP_EOL . $highlight_begin, $word[$key]) . $highlight_end;
								}
							}
						}
						// no word diff
						else
						{
							$line['ins'] .= $word;
							$line['del'] .= $word;
						}
					}

					foreach (array('del', 'ins') as $key)
					{
						if ( ! empty($line[$key]))
						{
							$line[$key] = explode(PHP_EOL, $line[$key]);

							foreach ($line[$key] as $_line)
							{
								$result .= ${$key . '_begin'} . htmlentities($_line, ENT_NOQUOTES) . ${$key . '_end'};
							}
						}
					}
				}
				// no show word diff
				else
				{
					foreach (array('del', 'ins') as $key)
					{
						if ( ! empty($line[$key]))
						{
							foreach ($line[$key] as $_line)
							{
								$result .= ${$key . '_begin'} . htmlentities($_line, ENT_NOQUOTES) . ${$key . '_end'};
							}
						}
					}
				}
			}
			// no diff
			else
			{
				$result .= htmlentities($line, ENT_NOQUOTES) . PHP_EOL;
			}
		}

		if ($this->_show_word_diff)
		{
			switch ($mode)
			{
				case 'mixed':
				case 'html':
					$highlight_replacement = array('<span class="highlight">', '</span>');
					break;
				default:
					$highlight_replacement = array('', '');
					break;
			}

			$result = str_replace(array($highlight_begin, $highlight_end), $highlight_replacement, $result);
		}

		return $result;
	}

	/**
	 * Diff function
	 *
	 * @author Paul Butler
	 * @modified Dan Horrigan
	 * @access private
	 * @param array $old The old block of data
	 * @param array $new The new block of data
	 */
	private function diff($old, $new)
	{
		$maxlen = 0;

		// Go through each old line.
		foreach ($old as $old_line => $old_value)
		{
			// Get the new lines that match the old line
			$new_lines = array_keys($new, $old_value);

			// Go through each new line number
			foreach ($new_lines as $new_line)
			{
				$matrix[$old_line][$new_line] = isset($matrix[$old_line - 1][$new_line - 1])
					? $matrix[$old_line - 1][$new_line - 1] + 1
					: 1;

				if ($matrix[$old_line][$new_line] > $maxlen)
				{
					$maxlen = $matrix[$old_line][$new_line];

					$old_max = $old_line + 1 - $maxlen;
					$new_max = $new_line + 1 - $maxlen;
				}
			}
		}

		if ($maxlen == 0)
		{
			return array(array('del' => $old, 'ins' => $new));
		}

		return array_merge(
			$this->diff(array_slice($old, 0, $old_max), array_slice($new, 0, $new_max)),
			array_slice($new, $new_max, $maxlen),
			$this->diff(array_slice($old, $old_max + $maxlen), array_slice($new, $new_max + $maxlen))
		);
	}

	/**
	 * Get a single item in a table along with it's latest revision
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $id The ID of the page to select
	 * @return object
	 */
	public function get($id)
	{
		return $this->_ci->db
			->select($this->_table_name . '.*, revisions.id as revision_table_id, revisions.owner_id, revisions.table_name, revisions.body, revisions.revision_date, revisions.author_id') // Might not be needed, added for now...
			->where($this->_table_name . '.id', $id)
			->join('revisions', $this->_table_name . '.revision_id = revisions.id')
			->get($this->_table_name)
			->row();
	}

	/**
	 * Get a page and revision based on the revision's ID
	 *
	 * @author Yorick Peterse
	 * @access public
	 * @param int $id The ID of the revision
	 * @return object
	 */
	public function get_by_revision($id)
	{
		return $this->_ci->db
			->select($this->_table_name . '.*, revisions.id as revision_table_id, revisions.owner_id, revisions.table_name, revisions.body, revisions.revision_date, revisions.author_id') // Might not be needed, added for now...
			->where('revisions.id', $id)
			->join($this->_table_name, 'revisions.owner_id = ' . $this->_table_name . '.id')
			->get('revisions')
			->row();
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
		return $this->_ci->db
			->select($this->_table_name . '.title, revisions.*, users.username as author')
			->where('revisions.owner_id',$owner_id)
			->join($this->_table_name, 'revisions.owner_id = ' . $this->_table_name . '.id')
			->join('users', 'revisions.author_id = users.id')
			->order_by('revisions.revision_date', 'desc')
			->get('revisions')
			->result();
	}

	/**
	 * Create a new revision
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param array $input The data used to create the revision
	 * @return bool
	 */
	public function create_revision($input, $prune = TRUE)
	{
		// Set the revision date and figure out who created it
		$input['revision_date'] = now();
		$input['table_name']	= $this->_table_name;

		// Create the revision
		if ($this->_ci->db->insert('revisions', $input))
		{
			// Set the inserted ID
			$insert_id = $this->_ci->db->insert_id();

			if ($prune)
			{
				// Now that we've created a new revision we need to check whether the data has to be cleaned up
				$this->prune_revisions($input['owner_id']);
			}

			return $insert_id;
		}

		return FALSE;
	}

	/**
	 * Change the revision of a page/blog article/etc
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @param int $row_id The ID of the row who's revision_id has to be changed
	 * @param int $revision_id The new revision ID
	 * @return void
	 */
	public function set_revision($row_id, $revision_id)
	{
		$this->_ci->db
			->where('id', $row_id)
			->update($this->_table_name, array('revision_id' => $revision_id));
	}

	/**
	 * Make sure only the latest 10 revisions are stored in the database, all others will be removed
	 *
	 * @author Yorick Peterse - PyroCMS Dev Team
	 * @access public
	 * @return void
	 */
	public function prune_revisions($owner_id)
	{
		// Do we need to prune at all?
		$this->_ci->db->where(array(
			'table_name'	=> $this->_table_name,
			'owner_id'		=> $owner_id
		));

		// We need to prune the data
		if ($this->_ci->db->count_all_results('revisions') > 10)
		{
			// Remove the oldest 5 revisions
			// query: SELECT * FROM revisions ORDER BY revision_date ASC LIMIT 5;
			$this->_ci->db
				->order_by('revision_date', 'asc')
				->where('owner_id', $owner_id)
				->limit(6)
				->delete('revisions', array('table_name' => $this->_table_name));
		}
	}

}

/* End of file Versioning.php */