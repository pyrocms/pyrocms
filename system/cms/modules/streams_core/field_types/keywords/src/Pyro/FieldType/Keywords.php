<?php namespace Pyro\FieldType;

use Pyro\Module\Streams_core\Core\Field\AbstractField;

/**
 * PyroStreams Keywords Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Keywords extends AbstractField
{
	/**
	 * Field type slug
	 * @var string
	 */
	public $field_type_slug    = 'keywords';

	/**
	 * DB column type
	 * @var string
	 */
	public $db_col_type        = 'string';

	/**
	 * Version
	 * @var string
	 */
	public $version            = '1.1.0';

	/**
	 * Author
	 */
	public $author             = array('name'=>'Osvaldo Brignoni', 'url'=>'http://obrignoni.com');

	/**
	 * Custom parameters
	 * @var array
	 */
	public $custom_parameters  = array('return_type');

	/**
	 * Construct
	 */
	public function __construct()
	{
		ci()->load->library('keywords/keywords');
	}

	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @param	array
	 * @param	array
	 * @return	string
	 */
	public function formInput()
	{
		$options['name'] 	= $this->form_slug;
		$options['id']		= 'id_'.rand(100, 10000);
		$options['class']	= 'tags';
		$options['value']	= Keywords::get_string($this->value);

		return form_input($options);
	}

	/**
	 * Event
	 * @return void
	 */
	public function event()
	{
		//ci()->template->append_css('jquery/jquery.tagsinput.css');
		//ci()->template->append_js('jquery/jquery.tagsinput.js');
		//$this->js('keywords.js');
	}

	/**
	 * Pre save
	 * @return string
	 */
	public function preSave()
	{
		return Keywords::process($this->value);
	}

	/**
	 * Pre output
	 * @return array|string
	 */
	public function stringOutput()
	{
		// if we want an array, format it correctly
		if ($this->getParameter('return_type') === 'array')
		{
			$keyword_array = Keywords::get_array($this->value);
			$keywords = array();
			$total = count($keyword_array);

			foreach ($keyword_array as $key => $value) {
				$keywords[] = array(
					'count' => $key,
					'total' => $total,
					'is_first' => $key == 0,
					'is_last' => $key == ($total - 1),
					'keyword' => $value
				);
			}

			return $keywords;
		}

		// otherwise return it as a string
		//return Keywords::get_string($this->value);
	}

	/**
	 * Return type parameter
	 * @param  string $value
	 * @return array
	 */
	public function paramReturnType($value = 'array')
	{
		return array(
			'instructions' => lang('streams:keywords.return_type.instructions'),
			'input' =>
				'<label>' . form_radio('return_type', 'array', $value == 'array') . ' Array </label><br/>'
				// String gets set as default for backwards compat
				.'<label>' . form_radio('return_type', 'string', $value !== 'array') . ' String </label> '
		);
	}
}
