<?php namespace Pyro\FieldType;

use Pyro\Module\Streams_core\AbstractFieldType;
use Pyro\Module\Users\Models\User as UserModel;
use Pyro\Module\Users\Models\Group as GroupModel;

/**
 * PyroStreams User Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class User extends AbstractFieldType
{
	public $field_type_slug = 'user';

	public $db_col_type = false;

	public $custom_parameters = array('restrict_group');

	public $version = '1.0.0';

	protected $userOptions;

	public $author = array(
		'name'=>'Ryan Thompson - PyroCMS',
		'url'=>'http://pyrocms.com/'
		);

	/**
	 * The field type relation
	 * @return [type] [description]
	 */
	public function relation()
	{
		return $this->belongsTo($this->getRelationClass('Pyro\Module\Users\Models\User'));
	}

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function formInput()
	{
		$id = null;

		if ($user = $this->getRelationResult()) {
			$id = $user->id;
		}
		elseif ($this->getParameter('default_to_current_user') == 'yes') {
			$id = ci()->current_user->id;
		} elseif ($this->getDefault()) {
			$id = $this->getDefault();
		}

		return form_dropdown($this->form_slug, $this->getUserOptions(), $id);
	}

	public function getUserOptions()
	{
		return $this->userOptions = $this->userOptions ?: UserModel::getUserOptions();
	}

	/**
	 * Output filter input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function filterInput()
	{
		// Start the HTML
		$html = form_dropdown(
			$this->getFilterSlug('contains'),
			array(),
			null,
			'id="'.$this->getFilterSlug('contains').'" class="skip" placeholder="'.$this->field->field_name.'"'
			);

		// Append our JS to the HTML since it's special
		$html .= $this->view(
			'fragments/user.js.php',
			array(
				'form_slug' => $this->form_slug,
				'field_slug' => $this->field->field_slug,
				'stream_namespace' => $this->entry->getStreamNamespace(),
				),
			false
			);

		return $html;
	}

	/**
	 * Format the Admin output
	 *
	 * @return [type] [description]
	 */
	public function stringOutput()
	{
		if ($user = $this->getRelationResult())
		{
			return anchor('admin/users/edit/'.$user->id, $user->username);
		}

		return null;
	}

	/**
	 * Pre Ouput Plugin
	 *
	 * This takes the data from the join array
	 * and formats it using the row parser.
	 *
	 * @return array
	 */
	public function pluginOutput()
	{
		if ($user = $this->getRelationResult())
		{
			return $user->getPresenter();
		}

		return null;
	}

    /**
     * Get column name
     * @return string
     */
    public function getColumnName()
    {
        return parent::getColumnName().'_id';
    }

	///////////////////////////////////////////////////////////////////////////////
	// -------------------------	PARAMETERS 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Restrict to Group
	 */
	public function paramRestrictGroup($value = null)
	{
		$groups = array('no' => lang('streams:user.dont_restrict_groups'));

		if (ci()->current_user->isSuperUser())
		{
			$groups = array_merge($groups, GroupModel::getGroupOptions());
		}
		else
		{
			$groups = array_merge($groups, GroupModel::getGeneralGroupOptions());
		}

		return form_dropdown('restrict_group', $groups, $value);
	}
}
