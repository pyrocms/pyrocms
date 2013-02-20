<?php defined('BASEPATH') or exit('No direct script access allowed');

use Pyro\Module\Files\Model\Folder;
use Pyro\Module\Files\Model\File;

/**
 * Files Plugin
 *
 * Create a list of files
 *
 * @author		Marcos Coelho
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Files\Plugins
 */
class Plugin_Files extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'Files',
	);
	public $description = array(
		'en' => 'List files in specified folders and output images with cropping.',
	);

	/**
	 * Returns a PluginDoc array that PyroCMS uses 
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer 
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array(
			'your_method' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Displays some data from some module.'
				),
				'single' => true,// will it work as a single tag?
				'double' => false,// how about as a double tag?
				'variables' => '',// list all variables available inside the double tag. Separate them|like|this
				'attributes' => array(
					'order-dir' => array(// this is the order-dir="asc" attribute
						'type' => 'flag',// Can be: slug, number, flag, text, array, any.
						'flags' => 'asc|desc|random',// flags are predefined values like this.
						'default' => 'asc',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '20',
						'required' => false,
					),
				),
			),// end first method
		);
	
		//return $info;
		return array();
	}


	private $_files = array();

	public function __construct()
	{
		$this->load->library('files/files');
	}

	/**
	 * Files listing
	 *
	 * Creates a list of files
	 *
	 * Usage:
	 *
	 * {{ files:listing folder="home-slider" type="i" fetch="subfolder|root" }}
	 * 	// your html logic
	 * {{ /files:listing }}
	 *
	 * 
	 * Alternate Usage:
	 * 
	 * {{ files:listing folder="home-slider" tagged="sunset|hiking|mountain" }}
	 * 	// your html logic
	 * {{ /files:listing }}
	 *
	 * The tags that are available to use from this method are listed below
	 *
	 * {{ id }}
	 * {{ folder_id }}
	 * {{ user_id }}
	 * {{ type }}
	 * {{ name }}
	 * {{ filename }}
	 * {{ description }}
	 * {{ extension }}
	 * {{ mimetype }}
	 * {{ width }}
	 * {{ height }}
	 * {{ filesize }}
	 * {{ date_added }}
	 *
	 * @return	array
	 */
	public function listing()
	{
		if ( ! $this->content()) {
			return '';
		}

		$folder_id = $this->attribute('folder', ''); // Id or Path
		$tags      = $this->attribute('tagged', false);
		$limit     = $this->attribute('limit', '10');
		$offset    = $this->attribute('offset', '');
		$type      = $this->attribute('type', '');
		$fetch     = $this->attribute('fetch');
		$order_by  = $this->attribute('order-by');
		$order_ord  = $this->attribute('order-ord');

		Files::getListing($folder_id, $tags, $limit, $offset, $type, $fetch, $order_by, $order_ord);

		$files and array_merge($this->_files, (array) $files);

		return $files;
	}

	public function file($return = '', $type = '')
	{
		// nothing to do
		if ($return && ! in_array($return, array('url', 'path'))) {
			return '';
		}

		// prepare file params
		$id   = $this->attribute('id');
		$type = $type and in_array($type, array('a','v','d','i','o')) ? $type : '';

		// get file
		if (isset($this->_files[$id])){
			$file = $this->_files[$id];
		} else {
			$type and File::where('type', $type);

			$file = File::find($id);
		}

		// file not found
		if ( ! $file or ($type && $file->type !== $type)) {
			return '';
		} elseif ( ! $return && $this->content()) { // return file fields array
			return (array) $file;
		}

		// make uri
		if ($type === 'i') {
			if ($size = $this->attribute('size', '')) {
				(strpos($size, 'x') === false) and ($size .= 'x');

				list($width, $height) = explode('/', strtr($size, 'x', '/'));
			} else {
				$width  = $this->attribute('width', '');
				$height	= $this->attribute('height', '');
			}

			is_numeric($width) or $width = 'auto';
			is_numeric($height) or $height = 'auto';

			if ($width === 'auto' && $height === 'auto') {
				$dimension = '';
			} else {
				$mode = $this->attribute('mode', '');
				$mode = in_array($mode, array('fill', 'fit')) ? $mode : '';

				$dimension = trim($width . '/' . $height . '/' . $mode, '/');
			}

			if ($file->folder->location === 'local' and $dimension) {
				$uri = sprintf('files/thumb/%s/%s', $file->filename, $dimension);
			} elseif ($file->folder->location === 'local') {
				// we can't just return the path on this because they may not want an absolute url
				$uri = 'files/large/' . $file->filename;
			} else {
				$uri = $file->path;
			}
		} else {
			$uri = ($file->folder->location === 'local') ? 'files/download/' . $file->id : $file->path;
		}

		// return string
		if ($return) {
			// if it isn't local then they are getting a url regardless what they ask for
			if ($file->folder->location !== 'local') {
				return $file->path;
			}

			return ($return === 'url') ? site_url($uri) : BASE_URI . $uri;
		}

		$attributes	= $this->attributes();

		foreach (array('base', 'size', 'id', 'title', 'type', 'mode', 'width', 'height') as $key) {
			if (isset($attributes[$key]) && ($type !== 'i' or ! in_array($key, array('width', 'height')))) {
				unset($attributes[$key]);
			}

			if (isset($attributes['tag-' . $key])) {
				$attributes[$key] = $attributes['tag-' . $key];

				unset($attributes['tag-' . $key]);
			}
		}

		$base = $this->attribute('base', 'url');
		
		// alt tag is named differently in db to prevent confusion with "alternative", so need to do check for it manually
		$attributes['alt'] = isset($attributes['alt']) ? $attributes['alt'] : $file->alt_attribute;
		
		// return an image tag html
		if ($type === 'i') {
			$this->load->helper('html');

			if (strpos($size, 'x') !== false && ! isset($attributes['width'], $attributes['height'])) {
				list($attributes['width'], $attributes['height']) = explode('x', $size);
			}

			return $this->{'_build_tag_location_' . $base}($type, $uri, array(
				'attributes' => $attributes,
				'index_page' => true
			));
		}

		// return an file anchor tag html
		$title = $this->attribute('title');

		return $this->{'_build_tag_location_' . $base}($type, $uri, compact('title', 'attributes'));
	}

	public function image()
	{
		return $this->file('', 'i');
	}

	public function image_url()
	{
		return $this->file_url('i');
	}

	public function image_path()
	{
		return $this->file_path('i');
	}

	public function file_url($type = '')
	{
		return $this->file('url', $type);
	}

	public function file_path($type = '')
	{
		return $this->file('path', $type);
	}

	public function exists()
	{
		$id = $this->attribute('id');

		$exists = (bool) (isset($this->_files[$id]) ? true : !(File::find($id)->isEmpty()));

		return $exists && $this->content() ? $this->content() : $exists;
	}
	
	public function folder_exists()
	{
		$exists = (bool) !(Folder::findBySlug($this->attribute('slug'))->isEmpty());

		return $exists && $this->content() ? $this->content() : $exists;
	}

	private function _build_tag_location_url($type = '', $uri = '', $extras = array())
	{
		extract($extras);

		if ($type === 'i') {
			$attributes['src'] = $uri;

			return img($attributes, $index_page);
		}

		return anchor($uri, $title, $attributes);
	}

	private function _build_tag_location_path($type = '', $uri = '', $extras = array())
	{
		extract($extras);

		// unset config base_url
		$base_url = $this->config->item('base_url');
		$this->config->set_item('base_url', '');

		// generate tag
		if ($type === 'i') {
			$attributes['src'] = $uri;

			$tag = img($attributes, $index_page);
		} else {
			$tag = anchor($uri, $title, $attributes);
		}

		// set config base_url
		$base_url = $this->config->set_item('base_url', $base_url);

		return $tag;
	}
}

/* End of file plugin.php */
