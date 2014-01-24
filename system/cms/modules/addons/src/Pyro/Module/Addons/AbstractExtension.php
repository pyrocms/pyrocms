<?php namespace Pyro\Module\Addons;

use Illuminate\Support\Str;
use Pyro\Module\Addons\ExtensionManager;

use Pyro\Support\Fluent;

/**
 * Abstract Extension
 * A great start to all your custom classes and extensions
 * @author Ryan Thompson - AI Web Systems, Inc. <support@aiwebsystems.com>
 * @package Pyro\Module\Addons
 */
abstract class AbstractExtension extends Fluent 
{
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
            'version' => '1.0.0',
        );
        
        return $defaultAttributes;
    }

	/**
	 * Append CSS file
	 */
	public function css($file, $extension = null)
	{
		$extension = $extension ? $extension : $this;

		$html = '<link href="'.base_url($extension->path_css.$file).'" type="text/css" rel="stylesheet" />';

		ci()->template->append_metadata($html);

		$this->assets[] = $html;
	}

	/**
	 * Append JS file
	 */
	public function js($file, $extension = false)
	{
		$extension = $extension ? $extension : $this;

		$html = '<script type="text/javascript" src="'.base_url($extension->path_js.$file).'"></script>';

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
	public function view($view_name, $data = array(), $extension = null)
	{
		$extension = $extension ? $extension : $this->slug;

		if ($extension != $this->slug) {
			$extension = ExtensionManager::getExtension($extension);
		} else {
			$extension = $this;
		}

		$paths = ci()->load->get_view_paths();

		ci()->load->set_view_path($extension->path_views);

		$view_data = ci()->load->_ci_load(array('_ci_view' => $view_name, '_ci_vars' => $this->objectToArray($data), '_ci_return' => true));

		ci()->load->set_view_path($paths);

		return $view_data;
	}
}
