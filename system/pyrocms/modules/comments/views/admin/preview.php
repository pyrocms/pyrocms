<div id="comment-preview">
<p class="width-two-thirds float-left spacer-bottom-half">
	<strong><?php echo lang('comments.posted_label');?>:</strong> <?php echo format_date($comment->created_on); ?><br/>
	<strong><?php echo lang('comments.from_label');?>:</strong> <?php echo $comment->name;?>
</p>

<div class="float-right spacer-right buttons buttons-small">
	<?php if ($comment->is_active): ?>
		<?php echo anchor('admin/comments/unapprove/' . $comment->id, lang('comments.deactivate_label'), 'class="button"');?>
	<?php else: ?>
		<?php echo anchor('admin/comments/approve/' . $comment->id, lang('comments.activate_label'), 'class="button"');?>
	<?php endif; ?>
	<?php echo anchor('admin/comments/delete/' . $comment->id, lang('comments.delete_label'), 'class="button"'); ?>
</div>

<hr class="clear-both" />

<p><?php echo nl2br($comment->comment);?></p>
</div>