<p>
	<strong><?php echo lang('comment_posted_label');?>:</strong> <?php echo date('M d, Y', $comment->created_on); ?><br/>		
	<strong><?php echo lang('comment_from_label');?>:</strong> <?php echo $comment->name;?>
</p>
<hr/>
<p><?php echo nl2br($comment->body);?></p>