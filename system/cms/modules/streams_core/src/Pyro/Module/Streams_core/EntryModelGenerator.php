<?php namespace Pyro\Module\Streams_core;

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

}