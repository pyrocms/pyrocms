<?php echo form_open(uri_string()); ?>

	<?php if( !empty($messages['error']) ): ?>
	<div class="errors">
		Please correct the errors in the form.
	</div>
	<?php endif; ?>

	<?php if(!empty($show_preview)): ?>
	<div class="preview">
		<h1>Message Preview</h1>
		<h2><?php echo $message->subject;?></h2>
		<p><?php echo parse_bbcode(htmlentities($message->content));?></p>
	</div>
	<?php endif; ?>

	<table class="form_table" border="0" cellspacing="0">
		<tbody>
			<tr>
				<th class ="input_label">To (email):</th>
				<td>
					<?php echo form_input(array('name' => 'to', 'id' => 'message_to', 'value' => $message->to)); ?>

					<?php echo form_error('to', '<p class="form_error">', '</p>'); ?></td>
			</tr>
			<tr>
				<th class ="input_label">Subject:</th>
				<td>
					<?php echo form_input(array('name' => 'subject', 'value' => $message->subject)); ?>

					<?php echo form_error('subject', '<p class="form_error">', '</p>'); ?></td>
			</tr>
			<tr>
				<th>Formatting:</th>
				<td><?php $this->load->view('partials/bbcode'); ?></td>
			</tr>
			<tr>
				<th class ="textarea_label">Message:</th>
				<td>
					<?php echo form_textarea(array('name' => 'content', 'id' => 'bbcode_input', 'value' => $message->content)); ?>
					
					<?php echo form_error('content', '<p class="form_error">', '</p>'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="form_buttons"><input type="submit" name="preview" value="Preview" />&nbsp;<input type="submit" name="submit" class="submit" value="Send Message" /></td>
			</tr>
		</tbody>
	</table>

<?php echo form_close(); ?>