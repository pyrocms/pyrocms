<p>
	<strong><?=lang('comment_posted_label');?>:</strong> <?= date('M d, Y', $comment->created_on); ?><br/>		
	<strong><?=lang('comment_from_label');?>:</strong> <?=$comment->name;?>
</p>
<hr/>
<p><?=stripslashes($comment->body);?></p>