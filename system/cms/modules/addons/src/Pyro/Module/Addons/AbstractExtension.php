<?php namespace Pyro\Module\Addons;

use Illuminate\Support\Str;
use Pyro\Support\Fluent;
use Pyro\Module\Addons\ExtensionManager;

/**
 * Abstract Extension
 * A great start to all your custom classes and extensions
 * @author Ryan Thompson - AI Web Systems, Inc. <support@aiwebsystems.com>
 * @package Pyro\Module\Addons
 */
abstract class AbstractExtension extends Fluent 
{
    /**
     * Extension version
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Get default attributes
     * 
     * @return array
     */
    public function getDefaultAttributes()
    {
        $defaultAttributes = array(
            'assets' => array(),
            'extension' => null,
        );
        
        return $defaultAttributes;
    }

	/**
	 * Append CSS file
	 */
	public function css($file, $extension = null)
	{
		$extension = $extension ? $extension : $this;

		$html = '<link href="'.base_url($extension->pathCss.$file).'" type="text/css" rel="stylesheet" />';

		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Append JS file
	 */
	public function js($file, $extension = false)
	{
		$extension = $extension ? $extension : $this;

		$html = '<script type="text/javascript" src="'.base_url($extension->pathJs.$file).'"></script>';

		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Append metadata
	 */
	public function appendMetadata($html)
	{
		ci()->template->append_metadata($html);

		ci()->assets[] = $html;
	}

	/**
	 * Load an extension view
	 *
	 * @param	string
	 * @param	string
	 * @param	bool
	 */
	public function view($viewName, $data = array(), $extension = null)
	{
		$extension = $extension ? $extension : $this->slug;

		if ($extension != $this->slug) {
			$extension = ExtensionManager::getExtension($extension);
		} else {
			$extension = $this;
		}

		$paths = ci()->load->get_view_paths();

		ci()->load->set_view_path($extension->pathViews);

		$view_data = ci()->load->_ci_load(array('_ci_view' => $viewName, '_ci_vars' => $data, '_ci_return' => true));

		ci()->load->set_view_path($paths);

		return $view_data;
	}

    /**
     * Called just before loadExtension()
     * is finished in the manager
     * @return void
     */
    public function loaded()
    {
        // We're loaded
    }
}
