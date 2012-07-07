<div id="comments">
	
	<div id="existing-comments">
		
	<h4><?php echo lang('comments.title'); ?></h4>
	
<?php if ($comments): ?>
	
	<?php foreach ($comments as $item): ?>
		
		<div class="comment">
			<div class="image">
				<?php echo gravatar($item->email, 60); ?>
			</div>
			<div class="details">
				<div class="name">
					<p>
						<?php echo $item->website ? anchor($item->website, $item->name, 'rel="external nofollow"') : $item->name; ?>
					</p>
				</div>
				<div class="date">
					<p><?php echo format_date($item->created_on); ?></p>
				</div>
				<div class="content">
					<?php if (Settings::get('comment_markdown') AND $item->parsed > ''): ?>
						<?php echo $item->parsed; ?>
					<?php else: ?>
						<p><?php echo nl2br($item->comment); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div><!-- close .comment -->
	<?php endforeach; ?>
	
<?php else: ?>
	<p><?php echo lang('comments.no_comments'); ?></p>
<?php endif; ?>

	</div>

	<?php echo form_open('comments/create/' . $module . '/' . $id, 'id="create-comment"'); ?>

		<h4><?php echo lang('comments.your_comment'); ?></h4>

		

			<?php echo form_hidden('redirect_to', uri_string()); ?>
			<noscript><?php echo form_input('d0ntf1llth1s1n', '', 'style="display:none"'); ?></noscript>

			<?php if ( ! $current_user): ?>

			<div class="form_name">
				<label for="name"><?php echo lang('comments.name_label'); ?>:</label>
				<input type="text" name="name" id="name" maxlength="40" value="<?php echo $comment['name'] ?>" />
			</div>

			<div class="form_email">
				<label for="email"><?php echo lang('comments.email_label'); ?>:</label>
				<input type="text" name="email" maxlength="40" value="<?php echo $comment['email'] ?>" />
			</div>

			<div class="form_url">
				<label for="website"><?php echo lang('comments.website_label'); ?>:</label>
				<input type="text" name="website" maxlength="40" value="<?php echo $comment['website'] ?>" />
			</div>

			<?php endif; ?>

			<div class="form_textarea">
				<label for="message"><?php echo lang('comments.message_label'); ?>:</label><br />
				<textarea name="comment" id="message" rows="5" cols="30" class="width-full"><?php echo $comment['comment'] ?></textarea>
			</div>

			<div class="form_submit">
				<?php echo form_submit('submit', lang('comments.send_label')); ?>
			</div>

	<?php echo form_close(); ?>

</div>
