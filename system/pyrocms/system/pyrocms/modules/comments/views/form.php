<?php $this->lang->load('comments/comments'); $comment = $this->session->flashdata('comment'); ?>

<?php echo form_open('comments/create/'.$module.'/'.$id); ?>
	<?php echo form_hidden('redirect_to', $this->uri->uri_string()); ?>
	
	<noscript>
		<?php echo form_input('d0ntf1llth1s1n', '', 'style="display:none"'); ?>
	</noscript>

	<?php if ( !$this->user ): ?>
	<p>
		<label for="name"><?php echo lang('comments.name_label');?>:</label><br />
		<input type="text" name="name" id="name" maxlength="40" value="<?php echo $comment['name'] ?>" />
	</p>

	<p>
		<label for="email"><?php echo lang('comments.email_label');?>:</label><br />
		<input type="text" name="email" maxlength="40" value="<?php echo $comment['email'] ?>" />
	</p>

	<p>
		<label for="website"><?php echo lang('comments.website_label');?>:</label><br />
		<input type="text" name="website" maxlength="40" value="<?php echo $comment['website'] ?>" />
	</p>
	<?php endif; ?>

	<p>
		<label for="message"><?php echo lang('comments.message_label');?>:</label><br />
		<textarea name="comment" id="message" rows="5" cols="30" class="width-full"><?php echo $comment['comment'] ?></textarea>
	</p>
	<p>
		<?php echo form_submit('btnSend', lang('comments.send_label'));?>
	</p>

<?php echo form_close(); ?>