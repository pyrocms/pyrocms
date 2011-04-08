<div id="comments_container">
	<h2><?php echo lang('comments.title');?></h2>

	<?php if ($comments = $this->comments_m->get_by_module_item($module, $module_id)): ?>
	
	<ul id="comment_list">

		<?php foreach( $comments as $comment): ?>
		<li class="comment">
			<?php echo gravatar($comment->email, 40); if($comment->user_id): ?>
				<p class="comment_heading"><strong><?php echo anchor('user/' . $comment->user_id, $this->ion_auth->get_user($comment->user_id)->display_name); ?></strong>
			<?php else: ?>
				<p class="comment_heading"><strong><?php echo anchor(escape_tags($comment->website), escape_tags($comment->name)); ?></strong>
			<?php endif; ?>
			<p class="comment_date"><?php echo format_date($comment->created_on); ?></p>
			<p class="comment_body"><?php echo nl2br(escape_tags(stripslashes($comment->comment)));?></p>
		</li>
		<?php endforeach; ?>

	</ul>

	<?php else: ?>
	<p><?php echo lang('comments.no_comments');?></p>
	<?php endif; ?>
</div>
<div id="comments_form_container">
	<h2><?php echo lang('comments.your_comment');?></h2>
	<?php echo $this->load->view('comments/form', array('module'=>$module, 'id' => $module_id)); ?>
</div>