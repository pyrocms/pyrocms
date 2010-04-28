<h2><?php echo $this->config->item('forums_title'); ?></h2>
<?php echo form_open(uri_string()); ?>

	<?php if( !empty($messages['error']) ): ?>
	<div class="errors">
		Please correct the errors in the form.
	</div>
	<?php endif; ?>

	<?php if(!empty($show_preview)): ?>
	<div class="preview">
		<h4>Post Preview</h4>
		<h5><?php echo $topic->title;?></h5>
		<p><?php echo parse_bbcode( htmlentities($reply->content), 0, TRUE );?></p>
	</div>
	<?php endif; ?>

	<table class="form_table" border="0" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2" class="header">
					<?php if($method == 'new_reply'): ?>
						Post a new reply to "<?php echo $topic->title;?>" in <?php echo $forum->title;?>
					<?php elseif($method == 'edit_reply'): ?>
						Edit your reply to "<?php echo $topic->title;?>" in <?php echo $forum->title;?>
					<?php endif; ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>Formatting:</th>
				<td><?php echo $template['partials']['bbcode']; ?></td>
			</tr>
			<tr>
				<th class ="textarea_label">Message:</th>
				<td>
					<?php echo form_textarea(array('name' => 'content', 'id' => 'bbcode_input', 'value' => $reply->content)); ?>
					
					<?php echo form_error('content', '<p class="form_error">', '</p>'); ?></td>
			</tr>
			<tr>
				<th>Options:</th>
				<td class="form_options">
					<?php echo form_checkbox('notify', 1, ($reply->notify === TRUE ? 1 : 0)); ?> <label for="notify">Notify me via email when someone posts in this thread.</label>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="form_buttons"><input type="submit" name="preview" value="Preview" />&nbsp;<input type="submit" name="submit" class="submit" value="Submit Reply" /></td>
			</tr>
		</tbody>
	</table>

<?php echo form_close(); ?>