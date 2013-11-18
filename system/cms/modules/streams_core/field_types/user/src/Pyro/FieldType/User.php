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

	public $db_col_type = 'integer';

	public $custom_parameters = array('restrict_group');

	public $version = '1.0.0';

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
		return $this->belongsTo($this->getParameter('relation_class', 'Pyro\Module\Users\Model\User'));
	}

	/**
	 * Format the Admin output
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
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function formInput()
	{
		// Start the HTML
		$html = form_dropdown(
			$this->form_slug,
			array(),
			null,
			'id="'.$this->form_slug.'" class="skip" placeholder="'.lang_label($this->getParameter('placeholder', 'lang:streams:user.placeholder')).'"'
			);

		// Append our JS to the HTML since it's special
		$html .= $this->view(
			'fragments/user.js.php',
			array(
				'form_slug' => $this->form_slug,
				'field_slug' => $this->field->field_slug,
				'stream_namespace' => $this->stream->stream_namespace,
				'value' => $this->getValueEntry(),
				),
			false
			);

		return $html;
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
				'stream_namespace' => $this->stream->stream_namespace,
				'value' => $this->getValueEntry(ci()->input->get($this->getFilterSlug('contains'))),
				),
			false
			);

		return $html;
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

	///////////////////////////////////////////////////////////////////////////////
	// -------------------------	UTILITIES 	  ------------------------------ //
	///////////////////////////////////////////////////////////////////////////////

	/**
	 * Get value for dropdown
	 * @param  mixed $value string or bool
	 * @return object
	 */
	protected function getValueEntry($value = false)
	{
		// Determine a value
		$value = ($value) ? $value : $this->value;

		// Boom
		return UserModel::find($value);
	}
}
