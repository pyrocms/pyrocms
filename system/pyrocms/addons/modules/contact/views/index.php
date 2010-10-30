<h2 id="page_title"><?php echo lang('contact_title');?></h2>

<?php if (validation_errors()): ?>
<div class="error_box">
	<?php echo validation_errors();?>
</div>
<?php endif; ?>
<?php echo form_open('contact');?>
	<p>
		<label for="contact_email"><?php echo lang('contact_name_label');?></label>
		<?php echo form_input('contact_name', $form_values->contact_name);?>
	</p>
	<p>
		<label for="contact_email"><?php echo lang('contact_email_label');?></label>
		<?php echo form_input('contact_email', $form_values->contact_email);?>
	</p>
	<p>
		<label for="contact_email"><?php echo lang('contact_company_name_label');?></label>
		<?php echo form_input('company_name', $form_values->company_name);?>
	</p>
	<p>
		<label for="contact_email"><?php echo lang('contact_subject_label');?></label>
		<?php echo form_dropdown('subject', $subjects, $form_values->subject, 'id="subject"'); ?>
		<input id="other_subject" name="other_subject" type="text" />
	</p>
	<p>
		<label for="message"><?php echo lang('contact_message_label'); ?></label>
		<?php echo form_textarea('message', $form_values->message, 'id="message"'); ?>
	</p>
	<p class="form_buttons">
		<input type="submit" value="<?php echo lang('contact_send_label') ?>" name="btnSubmit" />
	</p>
<?php echo form_close(); ?>