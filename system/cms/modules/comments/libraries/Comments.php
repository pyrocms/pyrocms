<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Comments library
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Comments\Libraries
 */

class Comments
{
	/**
	 * The name of the module in use
	 * 
	 * @var	string
	 */
	protected $module;

	/**
	 * Singular language key
	 * 
	 * @var	string
	 */
	protected $singular;

	/**
	 * Plural language key
	 * 
	 * @var	string
	 */
	protected $plural;

	/**
	 * Entry for this, be it an auto increment id or string
	 * 
	 * @var	string|int
	 */
	protected $entry_id;

	/**
	 * Title of the entry
	 * 
	 * @var	string
	 */
	protected $entry_title;

	/**
	 * What is the URL of this entry?
	 * 
	 * @var	string
	 */
	protected $entry_uri;

	/**
	 * Should the form be displayed along with anything else?
	 * 
	 * @var	bool
	 */
	protected $form_display = true;

	/**
	 * Encrypted hash containing title, singular and plural keys
	 * 
	 * @var	bool
	 */
	protected $entry_hash;

	/**
	 * Function to display a comment
	 *
	 * Reference is a actually an object reference, a.k.a. categorization of the comments table rows.
	 * The reference id is a further categorization on this. (For example, for example for
	 *
	 * @param	string	$module		The name of the module in use
	 * @param	string	$singular	Singular language key
	 * @param	string	$plural		Plural language key
	 * @param	string|int	$entry_id	Entry for this, be it an auto increment id or string, or null
	 */
	public function __construct($params)
	{
		ci()->load->model('comments/comment_m');
		ci()->lang->load('comments/comments');

		// This shouldnt be required if static loading was possible, but its not in CI
		if (is_array($params))
		{
			// Required
			$this->module = $params['module'];
			$this->singular = $params['singular'];
			$this->plural = $params['plural'];

			// Overridable
			$this->entry_uri = isset($params['uri']) ? $params['uri'] : uri_string();

			// Optional
			isset($params['entry_id']) and $this->entry_id = $params['entry_id'];
			isset($params['entry_title']) and $this->entry_title = $params['entry_title'];
		}
	}
	
	/**
	 * Count comments
	 *
	 * @return	string	Returns the HTML for any existing comments, and optionally a form
	 */
	public function display()
	{
		// Fetch comments, then process them
		$comments = $this->process(ci()->comment_m->get_by_entry($this->module, $this->singular, $this->entry_id));
		
		// Return the awesome comments view
		return $this->load_view('comments', array(
			'comments'		=>	$comments,
			'module'		=>	$this->module,
			'entry_hash'	=>	$this->encode_entry(),
			'comment'		=>  ci()->session->flashdata('comment'),
			'form_display' 	=>	$this->form_display,
		));
	}

	/**
	 * Count comments
	 *
	 * @return	int	Return the number of comments for this entry item
	 */
	public function count()
	{
		return (int) $this->db->where(array(
			'module'	=> $this->module,
			'entry_key'	=> $this->singular,
			'entry_id'	=> $this->entry_id,
			'is_active'	=> true,
		))->count_all_results('comments');
	}

	/**
	 * Count comments as string
	 *
	 * @return	string 	Language string with the total in it
	 */
	public function count_string()
	{
		$total = $this->count();

		return sprintf(lang('comments.counter_'.$line.'_label'), $total);
	}

	/**
	 * Function to process the items in an X amount of comments
	 *
	 * @param array $comments The comments to process
	 * @return array
	 */
	public function process($comments)
	{
		// Remember which modules have been loaded
		static $modules = array();

		foreach ($comments as &$comment)
		{
			// Override specified website if they are a user
			if ($comment->user_id and Setting::get('enable_profiles'))
			{
				$comment->website = 'user/'.$comment->user_id;
			}

			// We only want to load a lang file once
			if ( ! isset($modules[$comment->module]))
			{
				if (ci()->module_m->exists($comment->module))
				{
					ci()->lang->load("{$comment->module}/{$comment->module}");

					$modules[$comment->module] = true;
				}
				// If module doesn't exist (for whatever reason) then sssh!
				else
				{
					$modules[$comment->module] = false;
				}
			}

			$comment->singular = lang($comment->entry_key) ? lang($comment->entry_key) : $comment->entry_key;
			$comment->plural = lang($comment->entry_plural) ? lang($comment->entry_plural) : $comment->entry_plural;

			// work out who did the commenting
			if ($comment->user_id > 0)
			{
				$comment->name = anchor('admin/users/edit/'.$comment->user_id, $comment->name);
			}

			// Security: Escape any Lex tags
			foreach ($comment as $field => $value)
			{
				$comment->{$field} = escape_tags($value);
			}
		}
		
		return $comments;
	}

	/**
	 * Load View
	 *
	 * @return	string	HTML of the comments and form
	 */
	protected function load_view($view, $data)
	{
		$ext = pathinfo($view, PATHINFO_EXTENSION) ? '' : '.php';
		
		if (file_exists(ci()->template->get_views_path().'modules/comments/'.$view.$ext))
		{
			// look in the theme for overloaded views
			$path = ci()->template->get_views_path().'modules/comments/';
		}
		else
		{
			// or look in the module
			list($path, $view) = Modules::find($view, 'comments', 'views/');
		}
		
		// add this view location to the array
		ci()->load->set_view_path($path);
		ci()->load->vars($data);

		return ci()->load->_ci_load(array('_ci_view' => $view, '_ci_return' => true));
	}

	/**
	 * Set Form Display
 	 * Modules can have all sorts of reasons for disabling the form, but still displaying comments. 
	 *
	 * @param bool $is_enabled
	 * @return	int	Return the number of comments for this entry item
	 */
	public function set_form_display($is_enabled = true)
	{
		$this->form_display = $is_enabled;
	}

	/**
	 * Encode Entry
	 *
	 * @return	string	Return a hash of entry details, so we can send it via a form safely.
	 */
	protected function encode_entry()
	{
		return ci()->encrypt->encode(serialize(array(
			'id'			=>	$this->entry_id,
			'title'			=> 	$this->entry_title,
			'uri'			=>	$this->entry_uri,
			'singular'		=>	$this->singular,
			'plural'		=>	$this->plural,
		)));
	}

}