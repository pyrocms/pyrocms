{$template.partials.breadcrumbs}
<?=form_open('forums/topics/new_topic/'.$forum->id);?>

<? if( !empty($validation_errors) ): ?>
<div class="errors">
	Please correct the errors in the form.
</div>
<?php endif; ?>

<? if($show_preview): ?>
<div class="preview">
	<h1>Topic Preview</h1>
	<h2><? echo set_value('title');?></h2>
	<p><?php echo parse_bbcode(set_value('content'));?></p>
</div>

<? endif; ?>


<table class="form_table" border="0" cellspacing="0">
	<thead>
		<tr>
			<th colspan="2" class="header">Post a New Topic to <strong><?php echo $forum->title;?></strong></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>Title:</th>
			<td><?php echo form_input(array('name' => 'title', 'id' => 'title', 'value' => set_value('title'))); ?><?php echo form_error('title', '<p class="form_error">', '</p>'); ?></td>
		</tr>
		<tr>
			<th>Formatting:</th>
			<td>{$template.partials.bbcode}</td>
		</tr>
		<tr>
			<th class ="textarea_label">Message:</th>
			<td><?php echo form_textarea(array('name' => 'content', 'id' => 'bbcode_input', 'value' => set_value('content'))); ?><?php echo form_error('content', '<p class="form_error">', '</p>'); ?></td>
		</tr>
		<tr>
			<th>Options:</th>
			<td class="form_options">
				<?php echo form_checkbox('notify', 1, set_value('notify') == 1 | empty($_POST)); ?> <label for="notify">Notify me via email when someone posts in this thread.</label>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="form_buttons"><input type="submit" name="preview" value="Preview" />&nbsp;<input type="submit" name="submit" class="submit" value="Submit Topic" /></td>
		</tr>
	</tbody>
</table>

<?php echo form_close(); ?>