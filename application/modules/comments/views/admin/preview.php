<p>
	<strong><?=lang('comments_posted_label');?>:</strong> <?= date('M d, Y', $comment->created_on); ?><br/>		
	<strong><?=lang('comments_from_label');?>:</strong> <?=$comment->name;?>
</p>
<hr/>
<p><?=stripslashes($comment->body);?></p>