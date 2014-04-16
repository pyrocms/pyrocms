<?php namespace Pyro\Module\Streams\Entry;

use Illuminate\Support\Str;
use Pyro\Module\Streams\Stream\StreamModel;
use Pyro\Support\Generator;

class EntryModelGenerator extends Generator
{
    protected $templateFilename = 'EntryModel.txt';

    protected $relationFields;

    /**
     * Get path
     *
     * @param string $path
     *
     * @return string
     */
    public function getPath($path)
    {
        if (!is_dir($this->siteRefPath())) {
            mkdir($this->siteRefPath(), 0777);
        }

        $pyro = 'Pyro';

        if (!is_dir($this->siteRefPath($pyro))) {
            mkdir($this->siteRefPath($pyro), 0777);
        }

        $module = $pyro . DIRECTORY_SEPARATOR . 'Module';

        if (!is_dir($this->siteRefPath($module))) {
            mkdir($this->siteRefPath($module), 0777);
        }

        $streams = $module . DIRECTORY_SEPARATOR . 'Streams';

        if (!is_dir($this->siteRefPath($streams))) {
            mkdir($this->siteRefPath($streams), 0777);
        }

        $model = $streams . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR;

        if (!is_dir($this->siteRefPath($model))) {
            mkdir($this->siteRefPath($model), 0777);
        }

        return $this->siteRefPath($model . $path);
    }

    /**
     * Site ref path
     *
     * @return string
     */
    public function siteRefPath($path = null)
    {
        if ($path) {
            $path = DIRECTORY_SEPARATOR . $path;
        }

        return $this->modelPath(Str::studly(SITE_REF).'Site'.$path);
    }

    protected function getBasePath($path = null)
    {
        if ($path) {
            $path = DIRECTORY_SEPARATOR . $path;
        }

        if (class_exists('MY_Controller')) {
            $realpath = realpath('system/cms/modules/streams_core');
        } else {
            $realpath = realpath('../system/cms/modules/streams_core');
        }

        return $realpath . $path;
    }

    /**
     * Model path
     *
     * @return string
     */
    public function modelPath($path = null)
    {
        if ($path) {
            $path = DIRECTORY_SEPARATOR . $path;
        }

        return $this->getBasePath('models' . $path);
    }

    /**
     * Compile
     *
     * @param StreamModel $stream
     *
     * @return bool
     */
    public function compile(StreamModel $stream)
    {
        if ($stream and !empty($stream->stream_slug) and !empty($stream->stream_namespace)) {
            $className = Str::studly($stream->stream_namespace) . Str::studly($stream->stream_slug);

            $generator = new EntryModelGenerator;

            $stream->load('assignments.field');

            $generator->make(
                $className . 'EntryModel.php',
                array(
                    'namespace'      => StreamModel::getEntryModelNamespace(),
                    'table'          => "'" . $stream->stream_prefix . $stream->stream_slug . "'",
                    'stream'         => $this->compileStreamData($stream),
                    'relations'      => $this->compileRelations($stream),
                    'relationFields' => $this->compileRelationFieldsData($stream),
                ),
                true
            );

            return true;
        }

        return false;
    }

    /**
     * Compile Stream data
     *
     * @param StreamModel $stream
     *
     * @return string
     */
    protected function compileStreamData(StreamModel $stream)
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

    /**
     * Compile un
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $numberSpaces
     * @param bool   $useKeys
     *
     * @return string
     */
    protected function compileUnserializable($key, $value, $numberSpaces = 4, $useKeys = true)
    {
        $string = '';

        if (is_string($value)) {
            $value = unserialize($value);
        }

        $spaces = $this->s($numberSpaces);

        if (is_array($value) and !empty($value)) {

            $string .= "\n{$spaces}'{$key}' => array(";

            foreach ($value as $k => $v) {

                if (!is_array($v)) {

                    $v = $this->adjustValue($v, true);

                    $addFourSpaces = $spaces . $this->s(4);

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

    /**
     * Add a number of spaces
     *
     * @param int
     *
     * @return string
     */
    protected function s($n)
    {
        return str_repeat("\x20", $n);
    }

    /**
     * Adjust the value to be compiled as a string
     *
     * @param  mixed $value
     *
     * @return mixed
     */
    protected function adjustValue($value, $escape = false)
    {
        if (is_null($value)) {
            $value = 'null';
        } elseif (is_bool($value)) {

            if ($value) {
                $value = 'true';
            } else {
                $value = 'false';
            }

        } elseif (!is_numeric($value) and !is_bool($value)) {

            if ($escape) {
                $value = addslashes($value);
            }

            $value = "'" . $value . "'";
        }

        return $value;
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

            foreach($relationArray['arguments'] as &$argument) {
                $argument = $this->adjustValue($argument);
            }

            $relationString .= implode(', ', $relationArray['arguments']);

            $relationString .= ");";

            $relationString .= "\n{$this->s(4)}}";

            $relationString .= "\n";

            $string .= $relationString;
        }

        return $string;
    }

    /**
     * Get relation fields
     *
     * @param StreamModel $stream
     *
     * @return mixed
     */
    protected function getRelationFields(StreamModel $stream)
    {
        return $this->relationFields = $this->relationFields ? : $stream->assignments->getRelationFields();
    }

    /**
     * Compile relation fields data
     *
     * @param StreamModel $stream
     *
     * @return string
     */
    protected function compileRelationFieldsData(StreamModel $stream)
    {
        $string = "array(";

        foreach ($this->getRelationFields($stream) as $assignment) {

            $relationArray = $assignment->getType()->relation();

            $key = $this->adjustValue($assignment->fieldSlug);

            $value = $this->adjustValue($relationArray['method']);

            $string .= "\n{$this->s(8)}{$key} => {$value},";
        }

        $string .= "\n{$this->s(4)})";

        return $string;
    }

    /**
     * Fetch the compiled template for a model
     *
     * @param  string $template Path to template
     * @param  string $className
     *
     * @return string Compiled template
     */
    protected function getTemplate($className, $model = array())
    {
        $this->template = file_get_contents(
            realpath($this->getBasePath('src/Pyro/Module/Streams/templates/' . $this->templateFilename))
        );

        $model['className'] = $className;

        return '<?php ' . $this->parser->parse($this->template, $model, null);
    }
}
