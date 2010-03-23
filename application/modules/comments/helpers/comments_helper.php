<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
			case 'news':
				$ci->load->model('news/news_m');
				$article = $ci->news_m->get($comment->module_id);
				$comment->item = anchor('admin/news/preview/' . $article->id, $article->title, 'class="modal-large"');
			break;
			
			case 'photos':
				$ci->load->model('photos/photo_albums_m');
				$album = $ci->photo_albums_m->get($comment->module_id);
				$comment->item = anchor('photos/' . $album->slug, $album->title, 'class="modal-large iframe"');
			break;
		
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

?>