<div id="comment-preview">

	<p class="width-two-thirds float-left spacer-bottom-half">
		<strong><?php echo lang('comments:posted_label') ?>:</strong> <?php echo format_date($comment->created_on)?><br/>
		<strong><?php echo lang('comments:from_label') ?>:</strong> <?php echo $comment->user_name ?>
	</p>

	<div class="float-right spacer-right buttons buttons-small">
		<?php if ($comment->is_active): ?>
			<?php echo anchor('admin/comments/unapprove/'.$comment->id, lang('global:unapprove'), 'class="button"') ?>
		<?php else:?>
			<?php echo anchor('admin/comments/approve/'.$comment->id, lang('global:approve'), 'class="button"') ?>
		<?php endif?>
		<?php echo anchor('admin/comments/delete/'.$comment->id, lang('global:delete'), 'class="button"')?>
	</div>

	<hr class="clear-both" />

	<p><?php echo (Settings::get('comment_markdown') and $comment->parsed != '') ? $comment->parsed : nl2br($comment->comment) ?></p>

</div>