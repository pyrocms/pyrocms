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
	if(!$ref_id)
	{
		return '';
	}

	$ci =& get_instance();

	// Set ref to module if none provided
	$reference || $reference = $ci->router->fetch_module();

	$ci->lang->load('comments/comments');
	$ci->load->model('comments/comments_m');

	$ci->load->view('comments/comments', array('module' => $reference, 'module_id' => $ref_id));
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
		switch($comment->module)
		{
			case 'pages':

				if($page = $ci->pages_m->get($comment->module_id))
				{
					$comment->item = anchor('admin/pages/preview/' . $page->id, $page->title, 'class="modal-large"');
					break;
				}
				
			case 'news':

				if(!module_exists('news')) break;

				$ci->load->model('news/news_m');

				if($article = $ci->news_m->get($comment->module_id))
				{
					$comment->item = anchor('admin/news/preview/' . $article->id, $article->title, 'class="modal-large"');
					break;
				}

			case 'photos':
				
				if(!module_exists('photos')) break;

				$ci->load->model('photos/photos_m');
				$ci->load->model('photos/photo_albums_m');
				$photo = $ci->photos_m->get($comment->module_id);
				
				if($photo && $album = $ci->photo_albums_m->get($photo->album_id))
				{
					$comment->item = anchor(image_path('photos/'.$album->id .'/' . $photo->filename), $photo->caption, 'class="modal"');
					break;
				}

			case 'photos-album':

				if(!module_exists('photos')) break;
				
				$ci->load->model('photos/photo_albums_m');

				if($album = $ci->photo_albums_m->get($comment->module_id))
				{
					$comment->item = anchor('photos/' . $album->slug, $album->title, 'class="modal-large iframe"');
					break;
				}
		
			default:
				$comment->item = $comment->module .' #'. $comment->module_id;
			break;
		}
		
		// Link to the comment
		if( strlen($comment->comment) > 30 )
		{
			$comment->comment = character_limiter($comment->comment, 30);
		}
	}
	
	return $comments;
}