<?php namespace Pyro\Module\Streams_core;

use Illuminate\Support\Str;
use Pyro\Support\Generator;

class EntryModelGenerator extends Generator
{
    protected $templateFilename = 'EntryModel.txt';

    /**
     * Fetch the compiled template for a model
     *
     * @param  string $template Path to template
     * @param  string $className
     * @return string Compiled template
     */
    protected function getTemplate($className, $data = array())
    {
        $basePath = dirname(__FILE__);

        $this->template = file_get_contents($basePath.'/templates/'.$this->templateFilename);

        $data['className'] = $className;

        return '<?php '.$this->parser->parse($this->template, $data, null);
    }

    public function getPath($path)
    {
        $basePath = dirname(__FILE__);

        return $basePath.'/Data/'.$path;
    }

    public function compile(StreamModel $stream)
    {
        if ($stream and ! empty($stream->stream_slug) and ! empty($stream->stream_namespace)) {
            $className = Str::studly($stream->stream_namespace).Str::studly($stream->stream_slug);

            $generator = new EntryModelGenerator;

            $stream->load('assignments.field');

            $generator->make($className.'EntryModel.php', array(
                'table' => "'".$stream->stream_prefix.$stream->stream_slug."'",
                'stream' => $this->compileStreamData($stream),
            ), true);

            return true;
        }
        
        return false;
    }

    public function compileStreamData(StreamModel $stream)
    {
        // Stream attributes array
        $string = 'array(';

        foreach ($stream->getAttributes() as $key => $value) {
            $value = $this->adjustValue($value);
            $string .= "\n            '{$key}' => {$value},";
        }

        // Assignments array
        $string .= "\n            'assignments' => array(";

        foreach ($stream->assignments as $assignment) {

            // Assignment attributes array
            $string .= "\n                array(";

            foreach ($assignment->getAttributes() as $key => $value) {
                $value = $this->adjustValue($value);
                $string .= "\n                    '{$key}' => {$value},";
            }

            // Field attributes array
            $string .= "\n                    'field' => array(";

            foreach ($assignment->field->getAttributes() as $key => $value) {
                $value = $this->adjustValue($value);
                $string .= "\n                        '{$key}' => {$value},";
            }

            // End field attributes array
            $string .= "\n                    ),";
            
            // End assignment attributes array
            $string .= "\n                ),";
        }

        // End assignments array
        $string .= "\n            ),";
    
        // End stream attributes array
        $string .= "\n        )";

        return $string;
    }

    /**
     * Adjust the value to be compiled as a string
     * @param  mixed $value
     * @return mixed
     */
    public function adjustValue($value)
    {
        if (! is_numeric($value) and ! is_bool($value)) {
            $value = "'".$value."'";
        } elseif (is_null($value)) {
            $value = 'null';
        }

        return $value;
    }
}