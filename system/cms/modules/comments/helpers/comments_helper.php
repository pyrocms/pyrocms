<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Comments helper
 *
 * @author		Phil Sturgeon
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Core\Modules\Comments\Helpers
 */

/**
 * Function to display a comment
 *
 * Reference is a actually an object reference, a.k.a. categorization of the comments table rows.
 * The reference id is a further categorization on this. (For example, for example for
 *
 * @param	int		$ref_id		The id of the collection of the reference object of the comment (I guess?)
 * @param	bool	$reference	A module or other reference to pick comments for
 * @return	void
 */
function display_comments($ref_id = '', $reference = NULL)
{
	if ( ! (Settings::get('enable_comments') && $ref_id))
	{
		return;
	}

	$ci =& get_instance();
	
	// Set ref to module if none provided
	$reference OR $reference = $ci->router->fetch_module();

	$ci->lang->load('comments/comments');
	$ci->load->model('comments/comments_m');

	$comments = $ci->comments_m->get_by_module_item($reference, $ref_id);
	
	// loop through the comments and escape {{ foo }} and html tags
	foreach ($comments as &$comment)
	{
		// Override specified website if they are a user
		if ($comment->website and $comment->user_id and Setting::get('enable_profiles'))
		{
			$comment->website = 'user/'.$comment->user_id;
		}

		foreach ($comment as &$body)
		{
			$body = escape_tags($body);
		}
	}

	// set the data to send to the view
	$data['comments']	=	$comments;
	$data['module']		=	$reference;
	$data['id']			=	$ref_id;
	$data['comment']	=	$ci->session->flashdata('comment');

	/**
	 * The following allows us to load views
	 * without breaking theme overloading
	 **/
	$view = 'comments';
	
	if (file_exists($ci->template->get_views_path().'modules/comments/'.$view.(pathinfo($view, PATHINFO_EXTENSION) ? '' : EXT)))
	{
		// look in the theme for overloaded views
		$path = $ci->template->get_views_path().'modules/comments/';
	}
	else
	{
		// or look in the module
		list($path, $view) = Modules::find($view, 'comments', 'views/');
	}
	
	// save the existing view array so we can restore it
	$save_path = $ci->load->get_view_paths();

	// add this view location to the array
	$ci->load->set_view_path($path);

	// output the comments html
	$comment_view = $ci->load->_ci_load(array('_ci_view' => $view, '_ci_vars' => ( $data )));

	// Put the old array back
	$ci->load->set_view_path($save_path);
}

/**
 * Function to count comments
 *
 * @param	int		$module_item_id		The ID of the module item to count comments for
 * @param	bool	$module_slug		Specify the module slug or the current module's slug will be used
 * @param	bool	$return_as_number	True to return a number or False to return a language string
 * @return	void
 */
function count_comments($module_item_id = '', $module_slug = NULL, $return_as_number = FALSE)
{
	$ci =& get_instance();

	// Set ref to module if none provided
	$module_slug OR $module_slug = $ci->router->fetch_module();

	$ci->lang->load('comments/comments');

	$where = array(
		'module'	=> $module_slug,
		'module_id'	=> ($module_item_id ? $module_item_id : NULL),
		'is_active'	=> true
	);

	$total = (int) $ci->db->where($where)->count_all_results('comments');

	if ($return_as_number)
	{
		return $total;
	}

	switch ($total)
	{
		case 0	: $line = 'none'; break;
		case 1	: $line = 'singular'; break;
		default	: $line = 'plural';
	}

	return sprintf(lang('comments.counter_'.$line.'_label'), $total);
}

/**
 * Function to process the items in an X amount of comments
 *
 * @param array $comments The comments to process
 * @return array
 */
function process_comment_items($comments)
{
	$ci =& get_instance();

	foreach ($comments as &$comment)
	{
		// work out who did the commenting
		if ($comment->user_id > 0)
		{
			$comment->name = anchor('admin/users/edit/'.$comment->user_id, $comment->name);
		}

		// What did they comment on
		switch ($comment->module)
		{
			case 'news': # Deprecated v1.1.0
				$comment->module = 'blog';
				break;
			case 'gallery':
				$comment->module = plural($comment->module);
				break;
			case 'gallery-image':
				$comment->module = 'galleries';
				$ci->load->model('galleries/gallery_image_m');
				if ($item = $ci->gallery_image_m->get($comment->module_id))
				{
					$comment->item = anchor('admin/'.$comment->module.'/image_preview/'.$item->id, $item->title, 'class="modal-large"');
					continue 2;
				}
				break;
		}

		if (module_exists($comment->module))
		{
			$model_name = singular($comment->module).'_m';
			
			if ( ! isset($ci->{$model_name.'_m'}))
			{
				$ci->load->model($comment->module.'/'.$model_name);
			}

			if ($item = (object) $ci->{$model_name}->get($comment->module_id) AND isset($item->id))
			{
				$comment->item = anchor('admin/'.$comment->module.'/preview/'.$item->id, $item->title, 'class="modal-large"');
			}
		}
		else
		{
			$comment->item = $comment->module .' #'. $comment->module_id;
		}
	}
	
	return $comments;
}