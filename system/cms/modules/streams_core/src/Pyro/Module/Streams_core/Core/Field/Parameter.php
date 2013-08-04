<?php namespace Pyro\Module\Streams_core\Field;

class Parameter
{
    public function __construct()
    {
		$this->CI = get_instance();

		$this->CI->load->helper('form');
	}

	// --------------------------------------------------------------------------

	/**
	 * Maxlength field
	 *
	 * @param	string
	 * @return 	string
	 */
	public function max_length($value = '')
	{
		$data = array(
        	'name'        => 'max_length',
            'id'          => 'max_length',
        	'value'       => $value,
        	'maxlength'   => '100'
 		);

		return form_input($data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Upload location field
	 *
	 * @param	string
	 * @return 	string
	 */
	public function upload_location($value = '')
	{
		$data = array(
        	'name'        => 'upload_location',
            'id'          => 'upload_location',
        	'value'       => $value,
        	'maxlength'   => '255'
 		);

		return form_input($data);
	}

	// --------------------------------------------------------------------------

	/**
	 * Default default field
	 *
	 * @param	string
	 * @return 	string
	 */
	public function default_value($value = '')
	{
		$data = array(
        	'name'        => 'default_value',
            'id'          => 'default_value',
        	'value'       => $value,
        	'maxlength'   => '255'
 		);

		return form_input($data);
	}		
}