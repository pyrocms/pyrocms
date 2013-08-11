<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams User Field Type
 *
 * @package		PyroStreams
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2011 - 2013, PyroCMS
 */
class Field_user
{
	public $field_type_slug			= 'user';
	
	public $db_col_type				= 'int';

	public $custom_parameters		= array('restrict_group');

	public $version					= '1.0.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	// --------------------------------------------------------------------------

	// Run-time cache of users.
	private $cache 					= array();
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output($params, $entry_id, $field)
	{
		$this->CI->db->select('username, id');
	
		if (isset($params['custom']['restrict_group']) and is_numeric($params['custom']['restrict_group']))
		{
			$this->CI->db->where('group_id', $params['custom']['restrict_group']);
		}
		
		$users_raw = $this->CI->db->order_by('username', 'asc')->get('users')->result();
		
		$users = array();

		// If this is not required, then
		// let's allow a null option
		if ($field->is_required == 'no')
		{
			$users[null] = $this->CI->config->item('dropdown_choose_null');
		}
		
		// Get user choices
		foreach ($users_raw as $user)
		{
			$users[$user->id] = $user->username;
		}
	
		return form_dropdown($params['form_slug'], $users, $params['value'], 'id="'.$params['form_slug'].'"');
	}

	// --------------------------------------------------------------------------

	/**
	 * User Field Type Query Build Hook
	 *
	 * This joins our user fields.
	 *
	 * @access 	public
	 * @param 	array 	&$sql 	The sql array to add to.
	 * @param 	obj 	$field 	The field obj
	 * @param 	obj 	$stream The stream object
	 * @return 	void
	 */
	public function query_build_hook(&$sql, $field, $stream)
	{
		// Create a special alias for the users table.
		$alias = 'users_'.$field->field_slug;

		$sql['select'][] = '`'.$alias.'`.`id` as `'.$field->field_slug.'||user_id`';
		$sql['select'][] = '`'.$alias.'`.`email` as `'.$field->field_slug.'||email`';
		$sql['select'][] = '`'.$alias.'`.`username` as `'.$field->field_slug.'||username`';

		$sql['join'][] = 'LEFT JOIN '.$this->CI->db->protect_identifiers('users', true).' as `'.$alias.'` ON `'.$alias.'`.`id`='.$this->CI->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug.'.'.$field->field_slug, true);
	}

	// --------------------------------------------------------------------------

	/**
	 * Restrict to Group
	 */
	public function param_restrict_group($value = null)
	{
		$this->CI->db->order_by('name', 'asc');
		
		$db_obj = $this->CI->db->get('groups');
		
		$groups = array('no' => lang('streams:user.dont_restrict_groups'));
		
		$groups_raw = $db_obj->result();
		
		foreach ($groups_raw as $group)
		{
			$groups[$group->id] = $group->name;
		}
	
		return form_dropdown('restrict_group', $groups, $value);
	}

}