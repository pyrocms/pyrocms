<p class="width-two-thirds float-left">
	<strong><?php echo lang('comments.posted_label');?>:</strong> <?php echo date('M d, Y', $comment->created_on); ?><br/>		
	<strong><?php echo lang('comments.from_label');?>:</strong> <?php echo $comment->name;?>
</p>

<div class="float-right spacer-right">
	<div class="button">
		<?php echo anchor('admin/comments/approve/' . $comment->id, 'Approve'); ?>
	</div>
	
	<div class="button">
		<?php echo anchor('admin/comments/approve/' . $comment->id, 'Delete'); ?>
	</div>
</div>

<hr class="clear-both" />

<p><?php echo nl2br($comment->comment);?></p>