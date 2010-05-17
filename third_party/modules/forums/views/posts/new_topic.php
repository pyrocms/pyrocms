<?php echo form_open('forums/topics/new_topic/'.$forum->id); ?>

<?php if( !empty($messages['error']) ): ?>
<div class="errors">
	Please correct the errors in the form.
</div>
<?php endif; ?>

<?php if($show_preview): ?>
<div class="preview">
	<h4>Topic Preview</h4>
	<h5><?php echo set_value('title');?></h5>
	<p><?php echo parse(htmlentities(set_value('content')), 0, TRUE);?></p>
</div>
<?php endif; ?>

<table class="form_table" border="0" cellspacing="0">
	<thead>
		<tr>
			<th colspan="2" class="header">Post a New Topic to <strong><?php echo $forum->title;?></strong></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Title:</th>
			<td><?php echo form_input(array('name' => 'title', 'id' => 'title', 'value' => htmlentities(set_value('title')))); ?><?php echo form_error('title', '<p class="form_error">', '</p>'); ?></td>
		</tr>
		<tr>
			<th>Formatting:</th>
			<td><?php echo $template['partials']['buttons']; ?></td>
		</tr>
		<tr>
			<th class ="textarea_label">Message:</th>
			<td><?php echo form_textarea(array('name' => 'content', 'id' => 'forum_input', 'value' => set_value('content'))); ?><?php echo form_error('content', '<p class="form_error">', '</p>'); ?></td>
		</tr>
		<tr>
			<th>Options:</th>
			<td class="form_options">
				<?php echo form_checkbox('notify', 1, 1); ?> <label for="notify">Notify me via email when someone posts in this thread.</label>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="form_buttons"><input type="submit" name="preview" value="Preview" />&nbsp;<input type="submit" name="submit" class="submit" value="Submit Topic" /></td>
		</tr>
	</tbody>
</table>

<?php echo form_close(); ?>