<?php namespace Pyro\FieldType;

use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Choice Field Type
 *
 * @package        PyroCMS\Core\Modules\Streams Core\Field Types
 * @author         Parse19
 * @copyright      Copyright (c) 2011 - 2012, Parse19
 * @license        http://parse19.com/pyrostreams/docs/license
 * @link           http://parse19.com/pyrostreams
 */
class Choice extends FieldTypeAbstract
{
    public $field_type_slug = 'choice';

    public $db_col_type = 'string';

    public $version = '1.1.0';

    public $author = array(
        'name' => 'Ryan Thompson - PyroCMS',
        'url'  => 'http://pyrocms.com/',
    );

    public $custom_parameters = array(
        'choice_data',
        'choice_type',
        'min_choices',
        'max_choices',
        'placeholder',
    );

    public $plugin_return = 'merge';

    /**
     * Input Types
     *
     * Valid input types for the choices field
     * type. The default is "dropdown".
     *
     * @var    array
     */
    public $input_types = array('dropdown', 'multiselect', 'radio', 'checkboxes');

    ///////////////////////////////////////////////////////////////////////////////
    // -------------------------	METHODS 	  ------------------------------ //
    ///////////////////////////////////////////////////////////////////////////////

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
        $choices = $this->choicesToArray(
            $this->getParameter('choice_type'),
            $this->getParameter('choice_data'),
            ($this->field->required ? 'yes' : 'no')
        );

        $choice_type = $this->validateInputType($this->getParameter('choice_type'));

        // If this is a new input, we need to use the default value or go null
        $value = $this->value;

        if ($choice_type == 'dropdown') {
            // -------------------------------
            // Dropdown
            // -------------------------------
            // Drop downs are easy - the value is
            // always a string, and the choices
            // are just in an array from the field.
            // -------------------------------
            return form_dropdown(
                $this->form_slug,
                $choices,
                $value,
                'id="' . $this->form_slug . '" placeholder="' . $this->getPlaceholder() . '"'
            );
        } else {
            // -------------------------------
            // Checkboxes and Radio buttons
            // -------------------------------

            // Parse the value coming in.
            // If these are checkboxes, we need to put
            // the incoming data through some special processes
            if ($choice_type == 'checkboxes' or $choice_type == 'multiselect') {
                // We may have an array from $_POST or a string
                // from the saved form data in the case
                // or checkboxes
                if (is_string($value)) {
                    $values = explode("\n", trim($value));
                } elseif (is_array($value)) {
                    $values = $value;
                } else {
                    $values = array();
                }

                // If we have an array of values, trim each one
                if (is_array($values)) {
                    foreach ($values as $k => $v) {
                        $values[$k] = trim($v);
                    }
                }
                //If It's a multiselect, then we can go out now.
                if ($choice_type == 'multiselect') {
                    return form_multiselect(
                        $this->form_slug . '[]',
                        $choices,
                        $values,
                        'id="' . $this->form_slug . '"'
                    );
                }
            }

            // Go through each choice and create
            // a input element.
            $return = null;

            foreach ($choices as $choice_key => $choice) {
                if ($this->getParameter('choice_type') == 'radio') {
                    $selected = ($value == $choice_key) ? true : false;

                    $return .= '<label class="radio">' . form_radio(
                            $this->form_slug,
                            $this->formatChoice($choice_key),
                            $selected,
                            $this->activeState($choice)
                        ) . '&nbsp;' . $this->formatChoice($choice) . '</label>';
                } else {
                    $selected = (in_array($choice_key, $values)) ? true : false;

                    $return .= '<label class="checkbox">' . form_checkbox(
                            $this->form_slug . '[]',
                            $this->formatChoice($choice_key),
                            $selected,
                            'id="' . $this->formatChoice($choice_key) . '" ' . $this->activeState($choice)
                        ) . '&nbsp;' . $this->formatChoice($choice) . '</label>';
                }
            }
        }

        return $return;
    }

    // --------------------------------------------------------------------------

    /**
     * Take a string of choices and make them into an array
     *
     * @access    public
     *
     * @param    string - raw choices data
     * @param    string - type od choice form input
     * @param    string - fied is required - yes or no
     *
     * @return    array
     */
    public function choicesToArray($type = 'dropdown', $choicesRaw = null, $required = 'no', $optgroups = true)
    {
        if ($choicesRaw) {
            $lines = explode("\n", $choicesRaw);
        } else {
            $lines = explode("\n", $this->getParameter('choice_data'));
        }

        $placeholder = $this->getParameter('placeholder');

        if ($type == 'dropdown' and $required == 'no') {
            $choices[null] = empty($placeholder) ? ci()->config->item('dropdown_choose_null') : '';
        }

        foreach ($lines as $line) {
            if ($line) {
                $bits = explode(' : ', $line, 2);

                $key_bit = trim($bits[0]);

                if (count($bits) == 1) {
                    $choices[$key_bit] = lang_label($key_bit);
                } else {
                    $choices[$key_bit] = lang_label(trim($bits[1]));
                }
            }
        }


        // -------------------------------
        // Scan for <optgroup> triggers
        // -------------------------------
        // Optgroups are trigger by
        // wrapping a line in *
        // like: *group name*
        // TODO: Perhaps use this for
        // grouping checkboxes in the future?
        // -------------------------------
        if ($optgroups) {

            if ($type == 'dropdown') {

                // Initialize
                $optgroups    = array();
                $currentgroup = '';

                // Loop and look
                foreach ($choices as $key => $value) {

                    // Is this an <optgroup> trigger?
                    if (substr($key, 0, 1) == '*') {

                        // Sure is, set the current group
                        $currentgroup = substr($key, 1, -1);

                        // This is a trigger, so we're done.
                        // Continue to the next iteration.
                        continue;
                    } else {

                        // Nope, so is there a group yet?
                        if ($currentgroup == '') {

                            // Dang, this won't be in an <optgroup>
                            $optgroups[(string)$key] = $value;
                        } else {

                            // Yes! This will be in the current <optgroup>
                            $optgroups[$currentgroup][$key] = $value;
                        }
                    }
                }

                $choices = $optgroups;
            }
        }

        return $choices;
    }

    // --------------------------------------------------------------------------

    /**
     * Do we have a correct choice type? If not, we will
     * default to dropdown to save ourselves errors.
     *
     * @return    string The input type
     */
    private function validateInputType($var)
    {
        if (!in_array($var, $this->input_types)) {
            $var = 'dropdown';
        }

        return $var;
    }

    // --------------------------------------------------------------------------

    /**
     * Format a choice line
     *
     * Putting a ^ in front of a line makes it checked and disabled.
     * This removes the character if it is there.
     *
     * @access    private
     *
     * @param    string
     *
     * @return    string
     */
    private function formatChoice($line)
    {
        if ($line and $line{0} == '^') {
            return substr($line, 1);
        } else {
            return $line;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Active state
     *
     * Putting a ^ in front of a line makes it checked and disabled.
     * This set those parameters.
     *
     * @access    private
     *
     * @param    string
     *
     * @return    string
     */
    private function activeState($line)
    {
        $line = trim($line);

        if (!$line) {
            return $line;
        }

        if ($line{0} == '^') {
            return ' disabled="disabled" checked="checked"';
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Output filter input
     *
     * @return    string
     */
    public function filterInput()
    {
        $choices = $this->choicesToArray(
            $this->getParameter('choice_type'),
            $this->getParameter('choice_data'),
            'yes'
        );

        $choice_type = $this->validateInputType($this->getParameter('choice_type'));

        if ($placeholder = $this->getPlaceholder('filter')) {
            $placeholder = array('-----' => lang_label($placeholder));
        } else {
            $placeholder = array('-----' => lang('global:select-any'));
        }

        return form_dropdown(
            $this->getFilterSlug('is'),
            $placeholder + $choices,
            $this->getFilterValue('is'),
            'id="' . $this->form_slug . '"'
        );
    }

    /**
     * Process before outputting
     *
     * @access    public
     *
     * @param    array
     *
     * @return    string
     */
    public function stringOutput()
    {
        $choices = $this->choicesToArray(
            $this->getParameter('choice_type'),
            $this->getParameter('choice_data'),
            'no',
            false
        );

        $choice_type = $this->validateInputType($this->getParameter('choice_type'));

        // Checkboxes?
        if ($choice_type == 'checkboxes' or $choice_type == 'multiselect') {
            if (is_string($this->value)) {
                $values = explode("\n", $this->value);
            } else {
                $values = $this->value;
            }

            ci()->load->helper('html');

            $selected = array();

            if (!empty($values)) {
                foreach ($values as $v) {
                    if (isset($choices[$v])) {
                        $selected[] = $choices[$v];
                    }
                }
            }

            return ul($selected);
        }

        if (isset($choices[$this->value]) and $this->value != '' and $this->value !== null) {
            return $choices[$this->value];
        } else {
            return null;
        }
    }

    /**
     * Pre-save
     */
    public function preSave()
    {
        $choice_type = $this->validateInputType($this->getParameter('choice_type'));

        // We only need to do this for checkboxes
        if (($choice_type == 'checkboxes' or $choice_type == 'multiselect') and is_array($this->value)) {
            // If we have any disabled checkboxes that have been diabled by
            // a ^ before it, then we need to go and find those and make sure
            // they are added in, because they will not be present in the post data
            $choices = explode("\n", $this->getParameter('choice_data'));

            foreach ($choices as $choice_line) {
                $choice_line = trim($choice_line);

                if ($choice_line{0} == '^') {
                    $this->value[] = substr($choice_line, 1);
                }
            }

            // One per line
            return implode("\n", array_unique($this->value));
        } elseif (($choice_type == 'checkboxes' or $choice_type == 'multiselect') and !$this->value_or_null) {
            return '';
        } else {
            // If this is not a checkbox field, we are
            // just returning the value.
            return $this->value;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Validate input
     *
     * @param    string
     * @param    string - mode: edit or new
     * @param    object
     *
     * @return    mixed - true or error string
     */
    public function validate($value, $mode, $field)
    {
        if (($this->getParameter('choice_type') == 'checkboxes' or $this->getParameter(
                    'choice_type'
                ) == 'multiselect') and is_array($value)
        ) {
            // Go through and count the number that are disabled
            $choices = explode("\n", $this->getParameter('choice_data'));

            foreach ($choices as $choice_line) {
                $choice_line = trim($choice_line);

                if ($choice_line{0} == '^') {
                    $value[] = substr($choice_line, 1);
                }
            }

            $value = array_unique($value);

            // Get the actual number of checked items
            $total_selected = count($value);

            // -------------------------------
            // Min/Max Choices
            // -------------------------------
            // Checks the total selected
            // -------------------------------

            $min = is_numeric($this->getParameter('min_choices')) ? $this->getParameter('min_choices') : false;
            $max = is_numeric($this->getParameter('max_choices')) ? $this->getParameter('max_choices') : false;

            // Special case: are min/max the same? If so, let's just
            // match the number.
            if ($max and $min and ($max == $min)) {
                if ($total_selected != $max) {
                    return str_replace('{val}', $max, lang('streams:choice.must_select_num'));
                }
            } else {
                // Min Choice
                if (is_numeric($min)) {
                    if ($min > $total_selected) {
                        return str_replace('{val}', $min, lang('streams:choice.must_at_least'));
                    }
                }

                // Max Choice
                if (is_numeric($max)) {
                    if ($max < $total_selected) {
                        return str_replace('{val}', $max, lang('streams:choice.must_max_num'));
                    }
                }

            }

        }

        return true;
    }

    // --------------------------------------------------------------------------

    /**
     * Pre field add
     *
     * Before we add the field to a stream
     *
     * @access    public
     *
     * @param    obj
     * @param    obj
     *
     * @return    void
     */
    public function fieldAssignmentConstruct()
    {
        // We need more room for checkboxes
        if ($this->getParameter('choice_type') == 'checkboxes' || $this->getParameter('choice_type') == 'multiselect') {
            $this->db_col_type = 'text';
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Get the value output
     *
     * @return string
     */
    public function valueOutput()
    {
        $plugin_value = self::pluginOutput();

        return isset($plugin_value['value']) ? $plugin_value['value'] : null;
    }

    // --------------------------------------------------------------------------

    /**
     * Breaks up the items into key/val for template use
     *
     * @access    public
     * @access    public
     *
     * @param    string
     * @param    string
     * @param    array
     *
     * @return    array
     */
    public function pluginOutput()
    {
        $options = $this->choicesToArray(
            $this->getParameter('choice_type'),
            $this->getParameter('choice_data'),
            'no',
            false
        );

        // Checkboxes
        if ($this->getParameter('choice_type') == 'checkboxes' || $this->getParameter('choice_type') == 'multiselect') {
            $this->plugin_return = 'array';

            if (is_string($this->value)) {
                $values = explode("\n", $this->value);
            } else {
                $values = $this->value;
            }

            $return = array();

            if (!empty($values)) {
                foreach ($values as $k => $v) {
                    if (isset($options[$v])) {
                        $return[$k]['value']     = $options[$v];
                        $return[$k]['value.key'] = $v; // legacy
                        $return[$k]['key']       = $v;
                    } else {
                        // We don't want undefined values
                        unset($values[$k]);
                    }
                }
            }

            return $return;
        }

        $this->plugin_return = 'merge';

        if (isset($options[$this->value]) and $this->value != '') {
            $choices['key']   = $this->value;
            $choices['val']   = $options[$this->value]; // legacy
            $choices['value'] = $options[$this->value];

            return $choices;
        } else {
            return null;
        }

    }

    // --------------------------------------------------------------------------

    /**
     * Data for choice. In x : X format or just X format
     *
     * @access    public
     *
     * @param     [string - value]
     *
     * @return    string
     */
    public function paramChoiceData($value = null)
    {
        return array(
            'input'        => form_textarea('choice_data', $value),
            'instructions' => lang('streams:choice.instructions')
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Display as Dropdown
     *
     * @access    public
     *
     * @param     [string - value]
     *
     * @return    string
     */
    public function paramChoiceType($value = null)
    {
        $choices = array(
            'dropdown'    => lang('streams:choice.dropdown'),
            'multiselect' => lang('streams:choice.multiselect'),
            'radio'       => lang('streams:choice.radio_buttons'),
            'checkboxes'  => lang('streams:choice.checkboxes')
        );

        return form_dropdown('choice_type', $choices, $value);
    }

    // --------------------------------------------------------------------------

    /**
     * Minimum Number of Choices
     *
     * @access    public
     *
     * @param     [string - value]
     *
     * @return    string
     */
    public function paramMinChoices($value = null)
    {
        return array(
            'input'        => form_input('min_choices', $value),
            'instructions' => lang('streams:choice.checkboxes_only')
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Minimum Number of Choices
     *
     * @access    public
     *
     * @param     [string - value]
     *
     * @return    string
     */
    public function paramMaxChoices($value = null)
    {
        return array(
            'input'        => form_input('max_choices', $value),
            'instructions' => lang('streams:choice.checkboxes_only')
        );
    }

}
