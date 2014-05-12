<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * Streams Year Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Year extends FieldTypeAbstract
{
    public $field_type_slug = 'year';

    public $db_col_type = 'integer';

    public $col_constraint = 4;

    public $custom_parameters = array('start_year', 'end_year');

    public $extra_validation = 'integer';

    public $version = '1.0.0';

    public $author = array('name' => 'Parse19', 'url' => 'http://parse19.com');

    // --------------------------------------------------------------------------

    /**
     * Output form input
     *
     * @param    array
     * @param    array
     *
     * @return    string
     */
    public function formInput()
    {
        $end_year   = $this->_process_year_input($this->getParameter('end_year'));
        $start_year = $this->_process_year_input($this->getParameter('start_year', $end_year - 80));

        $years = array();

        // If this is not required, then
        // let's allow a null option
        if ($this->getParameter('required') == 'no') {
            $years[null] = ci()->config->item('dropdown_choose_null');
        }

        while ($end_year >= $start_year) {
            $years[$end_year] = $end_year;

            --$end_year;
        }

        // Value
        // We only use the default value if this is a new
        // entry.
        if ($this->is_new) {
            $value = $this->getParameter('default_value');
        } else {
            $value = $this->value;
        }

        return form_dropdown($this->getFormSlug(), $years, $value);
    }

    // --------------------------------------------------------------------------

    /**
     * Process Year Input
     *
     * Make sense of user input field. It accepts:
     *
     * - An actual year
     * - 'current' for the current year
     * - +num or -num for an offset of the current year
     *
     * @param    string
     *
     * @return    string
     */
    private function _process_year_input($years_data)
    {
        if (!$years_data) {
            return date('Y');
        }

        // Do they want the current year?
        if ($years_data == 'current') {
            return date('Y');
        }

        // Is this numeric? If so then cool.
        if ($years_data[0] != '-' and $years_data[0] != '+' and is_numeric($years_data)) {
            return $years_data;
        }

        // Else, we have + or - from the current time
        if ($years_data[0] == '+') {
            $num = str_replace('+', '', $years_data);

            if (is_numeric($num)) {
                return date('Y') + $num;
            }
        } elseif ($years_data[0] == '-') {
            $num = str_replace('-', '', $years_data);

            if (is_numeric($num)) {
                return date('Y') - $num;
            }
        }

        // Default just return the current year
        return date('Y');
    }

    // --------------------------------------------------------------------------

    /**
     * Start Year
     *
     * @param    [string - value]
     *
     * @return    string
     */
    public function paramStartYear($value = null)
    {
        $options['name']  = 'start_year';
        $options['id']    = 'start_year';
        $options['value'] = $value;

        return form_input($options);
    }

    // --------------------------------------------------------------------------

    /**
     * End Year
     *
     * @param    [string - value]
     *
     * @return    string
     */
    public function paramEndYear($value = null)
    {
        $options['name']  = 'end_year';
        $options['id']    = 'end_year';
        $options['value'] = $value;

        return form_input($options);
    }

}
