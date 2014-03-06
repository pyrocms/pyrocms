<?php namespace Pyro\FieldType;

use Pyro\Module\Streams_core\AbstractFieldType;
use Pyro\Module\Users\Model\User as UserModel;
use Pyro\Module\Users\Model\Group as GroupModel;

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

	protected $users;

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
		return $this->belongsTo($this->getRelationClass('Pyro\Module\Users\Model\User'));
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
		return $this->users = $this->users ? $this->users : UserModel::getUserOptions();
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
		else
		{
			return $this->value;
		}
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
		if ($entry = $this->getRelationResult())
		{
			return $entry->toArray();
		}

		return null;
	}

	public function fieldAssignmentConstruct($schema)
	{
		$tableName = $this->getStream()->stream_prefix.$this->getStream()->stream_slug;

		$schema->table($tableName, function($table) {
			$table->integer($this->field->field_slug.'_id')->nullable();
		});
	}

	public function pluginTestOverride()
	{
		die('hello');

		return 'hello';
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

	///////////////////////////////////////////////////////////////////////////
	// -------------------------	AJAX 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////

	public function ajaxSearch()
	{
		/**
		 * Grab the stream namespace
		 */
		$stream_namespace = ci()->uri->segment(6);


		/**
		 * Determine our field / type
		 */
		$field = FieldModel::findBySlugAndNamespace(ci()->uri->segment(7), $stream_namespace);
		$field_type = $field->getType(null);


		/**
		 * Get users
		 */
		$users = UserModel::getUserOptions($this->getParameter('restrict_group'), ci()->input->get('query'));

		// Prep return
		$results = array();

		foreach ($users as $k => $username) {
			$results[] = array(
				'id' => $k,
				'username' => $username,
				);
		}


		header('Content-type: application/json');
		echo json_encode(array('users' => $results));
	}
}
