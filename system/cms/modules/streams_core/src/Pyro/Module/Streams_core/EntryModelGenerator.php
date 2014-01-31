<?php namespace Pyro\Module\Streams_core;

use Illuminate\Support\Str;
use Pyro\Support\Generator;

class EntryModelGenerator extends Generator
{
    protected $templateFilename = 'EntryModel.txt';

    protected $relationFields;

    /**
     * Fetch the compiled template for a model
     *
     * @param  string $template Path to template
     * @param  string $className
     * @return string Compiled template
     */
    protected function getTemplate($className, $data = array())
    {
        $this->template = file_get_contents($this->getBasePath(
            'src'.DIRECTORY_SEPARATOR.
            'Pyro'.DIRECTORY_SEPARATOR.
            'Module'.DIRECTORY_SEPARATOR.
            'Streams_core'.DIRECTORY_SEPARATOR.
            'templates'.DIRECTORY_SEPARATOR.$this->templateFilename
        ));

        $data['className'] = $className;

        return '<?php '.$this->parser->parse($this->template, $data, null);
    }

    protected function getBasePath($path = null)
    {
        if ($path) {
            $path = DIRECTORY_SEPARATOR.$path;
        }

        return  APPPATH.'modules'.DIRECTORY_SEPARATOR.'streams_core'.$path;
    }

    /**
     * Data path
     * @return string
     */
    public function dataPath($path = null)
    {
        if ($path) {
            $path = DIRECTORY_SEPARATOR.$path;
        }

        return $this->getBasePath('models'.$path);
    }

    /**
     * Site ref path
     * @return string
     */
    public function siteRefPath($path = null)
    {
        $basePath = $this->getBasePath();

        if ($path) {
            $path = DIRECTORY_SEPARATOR.$path;
        }

        return $this->dataPath(Str::studly(SITE_REF).'Site'.$path);
    }

    public function getPath($path)
    {


        if (! is_dir($this->siteRefPath())) {
            mkdir($this->siteRefPath(), 0777);
        }

        $pyro = 'Pyro';

        if (! is_dir($this->siteRefPath($pyro))) {
            mkdir($this->siteRefPath($pyro), 0777);
        }

        $streams = $pyro.DIRECTORY_SEPARATOR.'Streams';

        if (! is_dir($this->siteRefPath($streams))) {
            mkdir($this->siteRefPath($streams), 0777);
        }

        $data = $streams.DIRECTORY_SEPARATOR.'Models'.DIRECTORY_SEPARATOR;

        if (! is_dir($this->siteRefPath($data))) {
            mkdir($this->siteRefPath($data), 0777);
        }

        return $this->siteRefPath($data.$path);
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
                'relationFields' => $this->compileRelationFieldsData($stream),
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
            
            if ($key == 'view_options') {
            
                $string .= $this->compileUnserializable($key, $value, 8, false);
            
            } else {
             
                $value = $this->adjustValue($value, in_array($key, array('stream_name', 'about')));
             
                $string .= "\n{$this->s(8)}'{$key}' => {$value},";                
            }
        }

        // Assignments array
        $string .= "\n{$this->s(8)}'assignments' => array(";

        foreach ($stream->assignments as $assignment) {

            // Assignment attributes array
            $string .= "\n{$this->s(12)}array(";

            foreach ($assignment->getAttributes() as $key => $value) {
                
                $value = $this->adjustValue($value, in_array($key, array('instructions')));
                
                $string .= "\n{$this->s(16)}'{$key}' => {$value},";
            }

            // Field attributes array
            $string .= "\n{$this->s(16)}'field' => array(";

            foreach ($assignment->field->getAttributes() as $key => $value) {

                if ($key == 'field_data') {

                    $string .= $this->compileUnserializable($key, $value, 20);

                } else {

                    $value = $this->adjustValue($value, in_array($key, array('field_name')));

                    $string .= "\n{$this->s(20)}'{$key}' => {$value},";

                }
            }

            // End field attributes array
            $string .= "\n{$this->s(16)}),";
            
            // End assignment attributes array
            $string .= "\n{$this->s(12)}),";
        }

        // End assignments array
        $string .= "\n{$this->s(8)}),";
    
        // End stream attributes array
        $string .= "\n{$this->s(4)})";

        return $string;
    }

    public function getRelationFields(StreamModel $stream)
    {
        return $this->relationFields = $this->relationFields ?: $stream->assignments->getRelationFields();
    }

    public function compileRelations(StreamModel $stream)
    {
        $string = '';

        foreach ($this->getRelationFields($stream) as $assignment) {

            $type = $assignment->getType();

            $type->setStream($stream);

            $relationString = '';
                
            $relationArray = $type->relation();

            $method = Str::camel($assignment->field->field_slug);

            $relationMethod = $relationArray['method'];

            $relationString .= "\n{$this->s(4)}public function {$method}()";

            $relationString .= "\n{$this->s(4)}{";

            $relationString .= "\n{$this->s(8)}return \$this->{$relationMethod}(";

            if ($relationMethod == 'hasOne' 
                or $relationMethod == 'belongsTo'
                or $relationMethod == 'hasMany') {
                
                if (empty($relationArray['related'])) return null;
                
                // @todo - throw exception if related class is Pyro\Module\Streams_core\EntryModel 
                // or not compile the relation at all?
                
                $relationString .= $this->adjustValue($relationArray['related']);

                if (! empty($relationArray['foreingKey'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['foreingKey']);
                }                   
            
            } elseif ($relationMethod == 'morphOne') {
                
                if (empty($relationArray['related'])) return null;

                $relationString .= $this->adjustValue($relationArray['related']);

                if (! empty($relationArray['name'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['name']);
                }

                if (! empty($relationArray['type'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['type']);
                }

                if (! empty($relationArray['id'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['id']);
                }
            
            } elseif ($relationMethod == 'morphTo'
                or $relationMethod == 'morphMany') {
            
                if (! empty($relationArray['name'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['name']);
                }

                if (! empty($relationArray['type'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['type']);
                }

                if (! empty($relationArray['id'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['id']);
                }
            
            } elseif ($relationMethod == 'belongsToMany') {

                if (empty($relationArray['related'])) return null;

                $relationString .= $this->adjustValue($relationArray['related']);

                if (! empty($relationArray['table'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['table']);
                }

                if (! empty($relationArray['foreignKey'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['foreignKey']);
                }

                if (! empty($relationArray['otherKey'])) {
                    $relationString .= ', '.$this->adjustValue($relationArray['otherKey']);
                }
            
            }

            $relationString .= ");";

            $relationString .= "\n{$this->s(4)}}";

            $relationString .= "\n";

            $string .= $relationString;
        }

        return $string;
    }

    public function compileUnserializable($key, $value, $numberSpaces = 4, $useKeys = true)
    {
        $string = '';
        
        if (is_string($value)) {
            $value = unserialize($value);    
        }
        
        $spaces = $this->s($numberSpaces);

        if (is_array($value) and ! empty($value)) {

            $string .= "\n{$spaces}'{$key}' => array(";

            foreach ($value as $k => $v) {
                
                if (! is_array($v)) {

                    $v = $this->adjustValue($v, true);
                    
                    $addFourSpaces = $spaces.$this->s(4);

                    if ($useKeys) {
                        
                        $string .= "\n{$addFourSpaces}'{$k}' => {$v},";    
                    
                    } else {

                        $string .= "\n{$addFourSpaces}{$v},";

                    }                    
                }

            }

            $string .= "\n{$spaces}),";

        } else {

            $string .= "\n{$spaces}'{$key}' => null,";
        
        }

        return $string;
    }

    public function compileRelationFieldsData(StreamModel $stream)
    {
        $string = "array(";

        foreach ($this->getRelationFields($stream) as $assignment) {
            
            $key = $this->adjustValue($assignment->fieldSlug);

            $string .= "\n{$this->s(8)}{$key} => array(";

            $type = $assignment->getType();

            $type->setStream($stream);

            foreach ($type->relation() as $key => $value) {
                
                $value = $this->adjustValue($value);

                $string .= "\n{$this->s(12)}'{$key}' => {$value},";
            }

            $string .= "\n{$this->s(8)}),";                
        }

        $string .= "\n{$this->s(4)})";

        return $string;
    }

    /**
     * Adjust the value to be compiled as a string
     * @param  mixed $value
     * @return mixed
     */
    public function adjustValue($value, $escape = false)
    {   
        if (is_null($value)) {
            $value = 'null';
        }
        elseif (! is_numeric($value) and ! is_bool($value)) {
            
            if ($escape) {
                $value = addslashes($value);
            }

            $value = "'".$value."'";
        }

        return $value;
    }

    /**
     * Add a number of spaces
     * @param int
     * @return string
     */ 
    protected function s($n)
    {
        return str_repeat("\x20", $n);
    }
}