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

	/**
	 * The field type relation
	 * @return [type] [description]
	 */
	public function relation()
	{
		return $this->belongsTo($this->getParameter('relation_class', 'Pyro\Module\Users\Model\User'));
	}

	/**
	 * Format the Admin output
	 * @return [type] [description]
	 */
	public function pre_output()
	{
		if ($user = $this->getRelation())
		{
			return anchor('admin/users/edit/'.$user->id, $user->username);	
		}
		else
		{
			return $this->value;
		}
	}

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function form_output()
	{
		$users = array();//Model\User::getUserOptions($this->getParameter('restrict_group'));

		// If this is not required, then
		// let's allow a null option
		if ($this->field->is_required == 'no') {
			$users[null] = ci()->config->item('dropdown_choose_null');
		}

		return form_dropdown($this->form_slug, $users, $this->value, 'id="'.$this->form_slug.'"');
	}

	/**
	 * Restrict to Group
	 */
	public function param_restrict_group($value = null)
	{
		$groups = array('no' => lang('streams:user.dont_restrict_groups'));

		if (ci()->current_user->isSuperUser())
		{
			$groups = array_merge($groups, Model\Group::getGroupOptions());
		}
		else
		{
			$groups = array_merge($groups, Model\Group::getGeneralGroupOptions());
		}

		return form_dropdown('restrict_group', $groups, $value);
	}

}
