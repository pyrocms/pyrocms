<?php defined('BASEPATH') or exit('No direct script access allowed');
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
		'br' => 'Arquivos',
            'fa' => 'فایل ها',
	);
	public $description = array(
		'en' => 'List files in specified folders and output images with cropping.',
		'br' => 'Lista arquivos em pastas específicas e exibe imagens com recortes',
             'fa' => 'لیست فایل های موجود در پوشه ی مشخص شده و خروجی تصاویر',
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
			'listing' => array(// the name of the method you are documenting
				'description' => array(// a single sentence to explain the purpose of this method
					'en' => 'Iterate through files contained in the specified folder or which have the specified tags.',
					'br' => 'Itera através dos arquivos contidos em uma pasta específica ou que possuem tags específicas.'
				),
				'single' => false,// will it work as a single tag?
				'double' => true,// how about as a double tag?
				'variables' => 'id|folder_id|folder_name|folder_slug|user_id|type|name|filename|description|extension|mimetype|width|height|filesize|date_added',
				'attributes' => array(
					'folder' => array(// this is the order-dir="asc" attribute
						'type' => 'number|slug',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => '',// attribute defaults to this if no value is given
						'required' => false,// is this attribute required?
					),
					'tagged' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'limit' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => false,
					),
					'offset' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '0',
						'required' => false,
					),
					'type' => array(
						'type' => 'flag',
						'flags' => 'a|v|d|i|o',
						'default' => '',
						'required' => false,
					),
					'order-by' => array(
						'type' => 'flag',
						'flags' => 'folder_id|user_id|type|name|extension|width|height|filesize|download_count|date_added|sort',
						'default' => 'sort',
						'required' => false,
					),
					'order-dir' => array(
						'type' => 'flag',
						'flags' => 'asc|desc|random',
						'default' => 'asc',
						'required' => false,
					),
				),
			),// end listing method
			'folders' => array(
				'description' => array(
					'en' => 'List folders and files (optional) from a specified folder.',
					'br' => 'Lista pastas e arquivos (opcional) de uam pasta específica.'
				),
				'single' => false,
				'double' => true,
				'variables' => 'folders|files|parent_id',
				'attributes' => array(
					'folder' => array(// this is the order-dir="asc" attribute
						'type' => 'number|slug',// Can be: slug, number, flag, text, array, any.
						'flags' => '',// flags are predefined values like this.
						'default' => '0',// attribute defaults to this if no value is given
						'required' => false, // is this attribute required?
					),
				),
			),// end folders method
			'folder_exists' => array(
				'description' => array(
					'en' => 'Check if a folder exists in the database.',
					'br' => 'Checa se uma pasta existe no banco de dados.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'slug' => array(
						'type' => 'slug',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end folder_exists method
			'exists' => array(
				'description' => array(
					'en' => 'Check if a file exists in the database.',
					'br' => 'Checa se um arquivo existe no banco de dados.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end exists method
			'image' => array(
				'description' => array(
					'en' => 'Output an image tag while resizing the image.',
					'br' => 'Exibe uma tag <img /> ao mesmo tempo que recorta a imagem.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'width' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '100',
						'required' => false,
					),
					'height' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '100',
						'required' => false,
					),
					'size' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '100/100',
						'required' => false,
					),
					'mode' => array(
						'type' => 'flag',
						'flags' => 'fit|fill',
						'default' => '',
						'required' => false,
					),
				),
			),// end image method
			'image' => array(
				'description' => array(
					'en' => 'Output an image tag while resizing the image.',
					'br' => 'Exibe uma tag <img /> ao mesmo tempo que recorta a imagem.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
					'width' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '100',
						'required' => false,
					),
					'height' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '100',
						'required' => false,
					),
					'size' => array(
						'type' => 'text',
						'flags' => '',
						'default' => '100/100',
						'required' => false,
					),
					'mode' => array(
						'type' => 'flag',
						'flags' => 'fit|fill',
						'default' => '',
						'required' => false,
					),
				),
			),// end image method
			'image_url' => array(
				'description' => array(
					'en' => 'Output a url to the specified image.',
					'br' => 'Exibe uma URL para a imagem especificada.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end image url method
			'image_path' => array(
				'description' => array(
					'en' => 'Output a filesystem path to the specified image.',
					'br' => 'Exibe um caminho do sistema de arquivos para a imagem especificada.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end image path method
			'url' => array(
				'description' => array(
					'en' => 'Output a url to the specified file.',
					'br' => 'Exibe uma URL para a imagem especificada.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end file url method
			'path' => array(
				'description' => array(
					'en' => 'Output a filesystem path to the specified file.',
					'br' => 'Exibe um caminho do sistema de arquivos para o arquivo especificado.'
				),
				'single' => true,
				'double' => false,
				'variables' => '',
				'attributes' => array(
					'id' => array(
						'type' => 'number',
						'flags' => '',
						'default' => '',
						'required' => true,
					),
				),
			),// end file path method
		);
	
		return $info;
	}


	private $_files = array();

	public function __construct()
	{
		$this->load->model(array(
			'file_m',
			'file_folders_m'
		));
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
		if ( ! $this->content())
		{
			return '';
		}

		$folder_id = $this->attribute('folder', ''); // Id or Path
		$tags      = $this->attribute('tagged', false);
		$limit     = $this->attribute('limit', null);
		$offset    = $this->attribute('offset', '');
		$type      = $this->attribute('type', '');
		$fetch     = $this->attribute('fetch');
		$order_by  = $this->attribute('order-by', 'sort');
		$order_dir = $this->attribute('order-dir', 'asc');

		if ( ! empty($folder_id) && (empty($type) || in_array($type, array('a','v','d','i','o'))))
		{
			if (is_numeric($folder_id))
			{
				$folder = $this->file_folders_m->get($folder_id);
			}
			elseif (is_string($folder_id))
			{
				$folder = $this->file_folders_m->get_by_path($folder_id);
			}
		}

		if (isset($folder) and $folder)
		{
			// we're getting the files for an entire tree
			if (in_array($fetch, array('root', 'subfolder')))
			{
				$fetch_id = ($fetch === 'root' ? $folder->root_id : $folder->id);

				$subfolders = $this->file_folders_m->folder_tree($fetch_id);

				if ($subfolders)
				{
					$ids = array_merge(array((int) $folder->id), array_keys($subfolders));
					$this->db->select('files.*, files.id as file_id, file_folders.location, file_folders.name folder_name, file_folders.slug folder_slug')
						->join('file_folders', 'file_folders.id = files.folder_id')
						->where_in('folder_id', $ids);
				}
			}
			// just the files for one folder
			else
			{
				$this->db->select('files.*, files.id as file_id, file_folders.location, file_folders.name folder_name, file_folders.slug folder_slug')
					->join('file_folders', 'file_folders.id = files.folder_id')
					->where('folder_id', $folder->id);
			}
		}
		// no restrictions by folder so we'll just be getting files by their tags. Set up the join
		elseif ( ! isset($folder))
		{
			$this->db->select('files.*, files.id as file_id, file_folders.location, file_folders.name folder_name, file_folders.slug folder_slug')
				->join('file_folders', 'file_folders.id = files.folder_id');
		}
		else
		{
			return array();
		}

		$type      and $this->db->where('type', $type);
		$limit     and $this->db->limit($limit);
		$offset    and $this->db->offset($offset);
		$order_by  and $this->db->order_by($order_by, $order_dir);

    if ($tags)
    {
			$files = $this->file_m->get_tagged($tags);
    }
    else
    {
			$files = $this->file_m->get_all();
		}

		$files and array_merge($this->_files, (array) $files);

		return $files;
	}

	/**
	 * Folder contents
	 *
	 * Creates a list of folders
	 *
	 * Usage:
	 * 
	 * {{ files:folders folder="home-slider" include_files="no|yes" }}
	 * 	{{ folders }}
	 * 		// Your html logic
	 * 	{{ /folders }}
	 *
	 * 	{{ files }}
	 * 		// your html logic
	 * 	{{ /files }}
	 * {{ /files:folders }}
	 *
	 * The tags that are available to use from this method are listed below
	 *
	 * {{ folders }}
	 * {{ files }}
	 * {{ parent_id }}
	 *
	 * @return	array
	 */
	public function folders()
	{
		$parent = $this->attribute('folder', 0); // Id or Path
		$include_files = $this->attribute('include_files', 'no');
		
		$data = array();

		if ( ! is_numeric($parent))
		{
			$segment = explode('/', trim($parent, '/#'));
			$result = $this->file_folders_m->get_by('slug', array_pop($segment));

			$parent = ($result ? $result->id : 0);
		}

		$folders = ci()->file_folders_m->where('parent_id', $parent)
			->where('hidden', 0)
			->order_by('sort')
			->get_all();

		$files = ($include_files == 'yes')
			? ci()->file_m->where('folder_id', $parent)->order_by('sort')->get_all()
			: false;

		// let's be nice and add a date in that's formatted like the rest of the CMS
		if ($folders)
		{
			foreach ($folders as &$folder) 
			{
				$folder->formatted_date = format_date($folder->date_added);

				$folder->file_count = ci()->file_m->count_by('folder_id', $folder->id);
			}
			$data['folders'] = $folders;
		}

		if ($files)
		{
			ci()->load->library('keywords/keywords');

			foreach ($files as &$file) 
			{
				$file->keywords_hash = $file->keywords;
				$file->keywords = ci()->keywords->get_string($file->keywords);
				$file->formatted_date = format_date($file->date_added);
			}
			$data['files'] = $files;
		}
		
		$data['parent_id'] = $parent;

		return array($data);
	}

	public function file($return = '', $type = '')
	{
		// nothing to do
		if ($return && ! in_array($return, array('url', 'path')))
		{
			return '';
		}

		// prepare file params
		$id   = $this->attribute('id');
		$type = $type and in_array($type, array('a','v','d','i','o')) ? $type : '';

		// get file
		if (isset($this->_files[$id]))
		{
			$file = $this->_files[$id];
		}
		else
		{
			$type and $this->file_m->select('files.*, file_folders.location')
						->join('file_folders', 'file_folders.id = files.folder_id')
						->where('type', $type);

			$file = $this->file_m->get_by('files.id', $id);
		}

		// file not found
		if ( ! $file or ($type && $file->type !== $type))
		{
			return '';
		}
		// return file fields array
		elseif ( ! $return && $this->content())
		{
			return (array) $file;
		}

		// make uri
		if ($type === 'i')
		{
			if ($size = $this->attribute('size', ''))
			{
				(strpos($size, 'x') === false) and ($size .= 'x');

				list($width, $height) = explode('/', strtr($size, 'x', '/'));
			}
			else
			{
				$width  = $this->attribute('width', '');
				$height	= $this->attribute('height', '');
			}

			is_numeric($width) or $width = 'auto';
			is_numeric($height) or $height = 'auto';

			if ($width === 'auto' && $height === 'auto')
			{
				$dimension = '';
			}
			else
			{
				$mode = $this->attribute('mode', '');
				$mode = in_array($mode, array('fill', 'fit')) ? $mode : '';

				$dimension = trim($width . '/' . $height . '/' . $mode, '/');
			}

			if ($file->location === 'local' and $dimension)
			{
				$uri = sprintf('files/thumb/%s/%s', $file->filename, $dimension);
			}
			// we can't just return the path on this because they may not want an absolute url
			elseif ($file->location === 'local')
			{
				$uri = 'files/large/' . $file->filename;
			}
			else
			{
				$uri = $file->path;
			}
		}
		else
		{
			$uri = ($file->location === 'local') ? 'files/download/' . $file->id : $file->path;
		}

		// return string
		if ($return)
		{
			// if it isn't local then they are getting a url regardless what they ask for
			if ($file->location !== 'local')
			{
				return $file->path;
			}

			return ($return === 'url') ? site_url($uri) : BASE_URI . $uri;
		}

		$attributes	= $this->attributes();

		foreach (array('base', 'size', 'id', 'title', 'type', 'mode', 'width', 'height') as $key)
		{
			if (isset($attributes[$key]) && ($type !== 'i' or ! in_array($key, array('width', 'height'))))
			{
				unset($attributes[$key]);
			}

			if (isset($attributes['tag-' . $key]))
			{
				$attributes[$key] = $attributes['tag-' . $key];

				unset($attributes['tag-' . $key]);
			}
		}

		$base = $this->attribute('base', 'url');
		
		// alt tag is named differently in db to prevent confusion with "alternative", so need to do check for it manually
		$attributes['alt'] = isset($attributes['alt']) ? $attributes['alt'] : $file->alt_attribute;
		
		// return an image tag html
		if ($type === 'i')
		{
			$this->load->helper('html');

			if (strpos($size, 'x') !== false && ! isset($attributes['width'], $attributes['height']))
			{
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

		$exists = (bool) (isset($this->_files[$id]) ? true : $this->file_m->exists($id));

		return $exists && $this->content() ? $this->content() : $exists;
	}
	
	public function folder_exists()
	{
		$exists = (bool) $this->file_folders_m->exists($this->attribute('slug'));

		return $exists && $this->content() ? $this->content() : $exists;
	}

	private function _build_tag_location_url($type = '', $uri = '', $extras = array())
	{
		extract($extras);

		if ($type === 'i')
		{
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
		if ($type === 'i')
		{
			$attributes['src'] = $uri;

			$tag = img($attributes, $index_page);
		}
		else
		{
			$tag = anchor($uri, $title, $attributes);
		}

		// set config base_url
		$base_url = $this->config->set_item('base_url', $base_url);

		return $tag;
	}
}

/* End of file plugin.php */
