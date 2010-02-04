<p>
	<strong><?php echo lang('comments.posted_label');?>:</strong> <?php echo date('M d, Y', $comment->created_on); ?><br/>		
	<strong><?php echo lang('comments.from_label');?>:</strong> <?php echo $comment->name;?>
</p>
<hr/>
<p><?php echo nl2br($comment->comment);?></p>