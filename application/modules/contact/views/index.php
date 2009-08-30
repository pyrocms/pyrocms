<script type="text/javascript">
	$(function()
	{
		$('#other_subject').hide();
		$('select#subject').change(function()
		{
			if(this.value == 'other')
			{
				$('#other_subject').slideDown().val('');
			}
			else
			{
				$('#other_subject').slideUp();
			}
		});
	});
</script>

<h2><?=lang('contact_title');?></h2>
<?=@$this->validation->error_string; ?>
	<?=form_open('contact');?>
			
		<fieldset>
			<legend><?=lang('contact_details_label');?></legend>
			
			<label for="contact_email" class="float-left width-half"><?=lang('contact_name_label');?></label>
			<p><?=form_input('contact_name', $form_values->contact_name);?></p>
			
			<label for="contact_email" class="float-left width-half"><?=lang('contact_email_label');?></label>
			<p><?=form_input('contact_email', $form_values->contact_email);?></p>
			
			<label for="contact_email" class="float-left width-half"><?=lang('contact_company_name_label');?></label>
			<p><?=form_input('company_name', $form_values->company_name);?></p>
			
			<label for="contact_email" class="float-left width-half"><?=lang('contact_subject_label');?></label>			
			<div class="width-half float-left">
				<p><?=form_dropdown('subject', $subjects, $form_values->subject, 'id="subject"');?></p>	
				<p><input id="other_subject" name="other_subject" type="text" class="float-left" /></p>
			</div>
			
		</fieldset>
		
		<fieldset>
			<legend><?=lang('contact_message_label');?></legend>
			
			<?php echo form_textarea(array('id'=>'message', 'name'=>'message', 'value'=>$form_values->message, 'rows'=>8, 'style'=>'width:100%'));?>
			
			<?php if($this->settings->item('captcha_enabled') && !$this->user_lib->logged_in()): ?>
			<p>
				<?php echo lang('contact_capchar_text');?>
				<?php echo $captcha['image'];?><br />
				<input type="text" name="captcha" id="captcha" maxlength="40" />
				<input type="hidden" name="captcha_id" id="captcha_id" value="<?php echo $captcha['time']; ?>" />
			</p>
			<?php endif; ?>
			
		</fieldset>
			
	<?=form_submit('submit', lang('contact_send_label'));?>                        
<?=form_close(); ?>