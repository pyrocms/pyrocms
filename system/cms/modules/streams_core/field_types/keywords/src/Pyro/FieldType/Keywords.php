<?php namespace Pyro\FieldType;

use Illuminate\Support\Str;
use Pyro\Module\Keywords\Model\Applied;
use Pyro\Module\Keywords\Model\Keyword;
use Pyro\Module\Streams\FieldType\FieldTypeAbstract;

/**
 * PyroStreams Keywords Field Type
 *
 * @package		PyroCMS\Core\Modules\Streams Core\Field Types
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Keywords extends FieldTypeAbstract
{
    /**
     * Field type slug
     * @var string
     */
    public $field_type_slug    = 'keywords';

    /**
     * Use alternative processing
     *
     * @todo  Do we need this anymore?
     * @var boolean
     */
    public $alt_process = true;

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

    public function relation()
    {
        return $this->morphToMany('Pyro\Module\Keywords\Model\Keyword', 'entry', 'keywords_applied');
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
        $names = '';

        if ($keywords = $this->getRelationResult()) {
            $names = implode(',', $keywords->lists('name', 'id'));
        }

        $options['name'] 	= $this->getFormSlug();
        $options['value']   = $names;
        $options['id']		= 'id_'.rand(100, 10000);
        $options['class']	= 'keywords_input';

        return form_input($options);
    }

    /**
     * Event
     * @return void
     */
    public function event()
    {
        ci()->template->append_css('jquery/jquery.tagsinput.css');
        ci()->template->append_js('jquery/jquery.tagsinput.js');
        $this->js('keywords.js');
    }

    /**
     * Pre save
     * @return string
     */
    public function preSave()
    {
        return Keyword::sync($this->value, $this->entry, Str::camel($this->field->field_slug));
    }

    /**
     * String output
     * @return array|string
     */
    public function stringOutput()
    {
        return $this->getKeywordsValue();
    }

    /**
     * Plugin output
     * @return array|string
     */
    public function pluginOutput()
    {
        return $this->getKeywordsValue('array');
    }

    /**
     * Plugin format override
     *
     * @param string $format
     * @return array|string
     */
    public function pluginFormatOverride($format)
    {
        return $this->getKeywordsValue($format);
    }

    /**
     * Get keywords value
     *
     * @param string $format
     * @return array|string
     */
    public function getKeywordsValue($format = 'array')
    {
        if (! $this->value) return null;

        $relationMethod = Str::camel($this->field->field_slug);

        $total = 0;
        if ($result = $this->getRelationResult()) {
            $total = $result->count();
        }

        // if we want an array, format it correctly
        if ($format === 'array') {
            //$keyword_array = \Keywords::get_array($this->value);
            $keywords = array();

            if ($total > 0) {
                foreach ($result as $key => $keyword) {
                    $keywords[] = array(
                        'count' => $key,
                        'total' => $total,
                        'is_first' => $key == 0,
                        'is_last' => $key == ($total - 1),
                        'keyword' => $keyword->name
                    );
                }
            }

            return $keywords;
        }

        if ($result) {
            return implode(',', $this->entry->{$relationMethod}->lists('name', 'id'));
        }
        // otherwise return it as a string
        return null;
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
