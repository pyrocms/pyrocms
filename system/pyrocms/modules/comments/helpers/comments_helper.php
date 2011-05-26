<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Comments helper
 *
 * @package		PyroCMS
 * @subpackage	Comments Module
 * @category	Helper
 * @author		Phil Sturgeon - PyroCMS Dev Team
 */

/**
 * Function to display a comment
 *
 * @param int $ref_id The ID of the comment (I guess?)
 * @param bool $reference Whether to use a reference or not (?)
 * @return void
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

	$comments	= $ci->comments_m->get_by_module_item($reference, $ref_id);
	$comment	= $ci->session->flashdata('comment');
	$form		= $ci->load->view('comments/form', array(
		'module'	=> $reference,
		'id'		=> $ref_id,
		'comment'	=> $comment
	), TRUE);

	foreach ($comments as &$comment)
	{
		foreach ($comment as &$data)
		{
			$data = escape_tags($data);
		}
	}

	$ci->load->view('comments/comments', compact('comments', 'form'));
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

	foreach($comments as &$comment)
	{
		// work out who did the commenting
		if($comment->user_id > 0)
		{
			$comment->name = anchor('admin/users/edit/' . $comment->user_id, $comment->name);
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
				$ci->load->model('galleries/gallery_images_m');
				if ($item = $ci->gallery_images_m->get($comment->module_id))
				{
					$comment->item = anchor('admin/' . $comment->module . '/image_preview/' . $item->id, $item->title, 'class="modal-large"');
					continue 2;
				}
				break;
		}

		if (module_exists($comment->module))
		{
			if ( ! isset($ci->{$comment->module . '_m'}))
			{
				$ci->load->model($comment->module . '/' . $comment->module . '_m');
			}

			if ($item = $ci->{$comment->module . '_m'}->get($comment->module_id))
			{
				$comment->item = anchor('admin/' . $comment->module . '/preview/' . $item->id, $item->title, 'class="modal-large"');
			}
		}
		else
		{
			$comment->item = $comment->module .' #'. $comment->module_id;
		}
		
		// Link to the comment
		if (strlen($comment->comment) > 30)
		{
			$comment->comment = character_limiter($comment->comment, 30);
		}
	}
	
	return $comments;
}