<div id="comments_container">
	<h2><?php echo lang('comments.title'); ?></h2>
<?php if ($comments): ?>
	<ul id="comment_list">
	<?php foreach ($comments as $comment): ?>
		<li class="comment">
			<?php echo gravatar($comment->email, 40); ?>
		<?php if ($comment->user_id): ?>
			<p class="comment_heading"><strong><?php echo anchor('user/' . $comment->user_id, $this->ion_auth->get_user($comment->user_id)->display_name); ?></strong>
		<?php else: ?>
			<p class="comment_heading"><strong><?php echo anchor($comment->website, $comment->name); ?></strong>
		<?php endif; ?>
			<p class="comment_date"><?php echo format_date($comment->created_on); ?></p>
			<p class="comment_body"><?php echo nl2br($comment->comment); ?></p>
		</li>
	<?php endforeach; ?>
	</ul>
<?php else: ?>
	<p><?php echo lang('comments.no_comments'); ?></p>
<?php endif; ?>
</div>

<div id="comments_form_container">
	<h2><?php echo lang('comments.your_comment'); ?></h2>
	<?php echo $form; ?>
</div>