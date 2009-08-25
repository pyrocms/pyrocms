<?php $this->lang->module_load('comments', 'comments'); ?>
<?php if(!empty($comments)): ?>
	<?php foreach($comments as $comment): ?>
	
		<div>
			<p>
				<strong><?=lang('comment_posted_label');?>:</strong> <?php echo date('M d, Y', $comment->created_on); ?><br/>		
				<strong><?=lang('comment_from_label');?>:</strong> <?php echo $comment->name;?>
			</p>
			<p><?php echo nl2br(stripslashes($comment->body));?></p>
			<hr/>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<p><?php echo lang('comments_no_comments');?></p>
<?php endif; ?>
