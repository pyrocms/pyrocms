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

    /**
     * Data path
     * @return string
     */
    public function dataPath($path = null)
    {
        $basePath = dirname(__FILE__);

        if ($path) {
            $path = DIRECTORY_SEPARATOR.$path;
        }

        return $basePath.DIRECTORY_SEPARATOR.'Data'.$path;
    }

    /**
     * Site ref path
     * @return string
     */
    public function siteRefPath($path = null)
    {
        $basePath = dirname(__FILE__);

        if ($path) {
            $path = DIRECTORY_SEPARATOR.$path;
        }

        return $this->dataPath(ucfirst(SITE_REF).$path);
    }

    public function getPath($path)
    {
        if (! is_dir($this->siteRefPath())) {
            mkdir($this->siteRefPath(), 0755);
        }

        return $this->siteRefPath($path);
    }

    public function compile(StreamModel $stream)
    {
        if ($stream and ! empty($stream->stream_slug) and ! empty($stream->stream_namespace)) {
            $className = Str::studly($stream->stream_namespace).Str::studly($stream->stream_slug);

            $generator = new EntryModelGenerator;

            $stream->load('assignments.field');

            $generator->make($className.'EntryModel.php', array(
                'namespace' => StreamModel::getEntryModelNamespace(),
                'table'     => "'".$stream->stream_prefix.$stream->stream_slug."'",
                'stream'    => $this->compileStreamData($stream),
                'relations' => $this->compileRelations($stream),
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
            $string .= "\n        '{$key}' => {$value},";
        }

        // Assignments array
        $string .= "\n        'assignments' => array(";

        foreach ($stream->assignments as $assignment) {

            // Assignment attributes array
            $string .= "\n            array(";

            foreach ($assignment->getAttributes() as $key => $value) {
                $value = $this->adjustValue($value);
                $string .= "\n                '{$key}' => {$value},";
            }

            // Field attributes array
            $string .= "\n                'field' => array(";

            foreach ($assignment->field->getAttributes() as $key => $value) {
                $value = $this->adjustValue($value);
                $string .= "\n                    '{$key}' => {$value},";
            }

            // End field attributes array
            $string .= "\n                ),";
            
            // End assignment attributes array
            $string .= "\n            ),";
        }

        // End assignments array
        $string .= "\n        ),";
    
        // End stream attributes array
        $string .= "\n    )";

        return $string;
    }

    public function compileRelations(StreamModel $stream)
    {
        $string = '';

        foreach ($stream->assignments as $assignment) {

            $type = $assignment->getType();

            if ($type->hasRelation()) {
                
                $relationArray = $type->relation();

                $method = Str::camel($assignment->field->field_slug);

                $relationMethod = $relationArray['method'];

                unset($relationArray['method']);

                foreach ($relationArray as $key => $value) {
                    $relationArray[$key] = $this->adjustValue($value);
                }

                $string .= "\n    public function {$method}()";

                $string .= "\n    {";

                $string .= "\n        return \$this->{$relationMethod}(";

                if ($relationMethod == 'hasOne' 
                    or $relationMethod == 'belongsTo'
                    or $relationMethod == 'hasMany') {
                    
                    $string .= $this->parser->parse(
                        '{{ related }}, {{ foreignKey }}',
                        $relationArray
                    );                    
                
                } elseif ($relationMethod == 'morphOne') {
                
                    $string .= $this->parser->parse(
                        '{{ related }}, {{ name }}, {{ type }}, {{ id }}',
                        $relationArray
                    );
                
                } elseif ($relationMethod == 'morphTo'
                    or $relationMethod == 'morphMany') {
                
                    $string .= $this->parser->parse(
                        '{{ name }}, {{ type }}, {{ id }}',
                        $relationArray
                    );
                
                } elseif ($relationMethod == 'belongsToMany') {
                
                    $string .= $this->parser->parse(
                        '{{ related }}, {{ table }}, {{ foreignKey }}, {{ otherKey }}',
                        $relationArray
                    );
                
                }

                $string .= ");";

                $string .= "\n    }";

                $string .= "\n\n";
            }
        }

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