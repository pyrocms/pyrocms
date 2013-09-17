<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Streams_core\Core\Field\AbstractField;
use Pyro\Module\Users\Model;

/**
 * PyroStreams User Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_user extends AbstractField
{
	public $field_type_slug			= 'user';

	public $db_col_type				= 'integer';

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
	public function form_output()
	{
		ci()->db->select('username, id');

		if ($restrict_group = $this->getParameter('restrict_group'))
		{
			ci()->db->where('group_id', $restrict_group);
		}

		$users = Model\User::lists('username', 'id');

		// If this is not required, then
		// let's allow a null option
		if ($this->field->is_required == 'no') {
			$users[null] = ci()->config->item('dropdown_choose_null');
		}

		return form_dropdown($this->form_slug, $users, $this->value, 'id="'.$this->form_slug.'"');
	}

	// --------------------------------------------------------------------------

	/**
	 * User Field Type Query Build Hook
	 *
	 * This joins our user fields.
	 *
	 * @param 	array 	&$sql 	The sql array to add to.
	 * @param 	obj 	$field 	The field obj
	 * @param 	obj 	$stream The stream object
	 * @return 	void
	 */
/*	public function query_build_hook(&$sql, $field, $stream)
	{
		// Create a special alias for the users table.
		$alias = 'users_'.$field->field_slug;

		$sql['select'][] = '`'.$alias.'`.`id` as `'.$field->field_slug.'||user_id`';
		$sql['select'][] = '`'.$alias.'`.`email` as `'.$field->field_slug.'||email`';
		$sql['select'][] = '`'.$alias.'`.`username` as `'.$field->field_slug.'||username`';

		$sql['join'][] = 'LEFT JOIN '.ci()->db->protect_identifiers('users', true).' as `'.$alias.'` ON `'.$alias.'`.`id`='.ci()->db->protect_identifiers($stream->stream_prefix.$stream->stream_slug.'.'.$field->field_slug, true);
	}*/

	public function relation()
	{
		$this->model->belongsTo('Pyro\Module\Users\Model\User', $this->field->field_slug);
	}

	/**
	 * Restrict to Group
	 */
	public function param_restrict_group($value = null)
	{
		ci()->db->order_by('name', 'asc');

		$db_obj = ci()->db->get('groups');

		$groups = array('no' => lang('streams:user.dont_restrict_groups'));

		$groups_raw = $db_obj->result();

		foreach ($groups_raw as $group) {
			$groups[$group->id] = $group->name;
		}

		return form_dropdown('restrict_group', $groups, $value);
	}

}
