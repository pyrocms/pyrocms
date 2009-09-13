<script type="text/javascript">
	(function($) {
		$(function() {
			
			$('input#other_subject').hide();
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
	})(jQuery);
</script>

<h2><?php echo lang('contact_title');?></h2>
<?php echo @$this->validation->error_string; ?>
	<?php echo form_open('contact');?>
			
		<fieldset>
			<legend><?php echo lang('contact_details_label');?></legend>
			
			<label for="contact_email" class="float-left width-half"><?php echo lang('contact_name_label');?></label>
			<p><?php echo form_input('contact_name', $form_values->contact_name);?></p>
			
			<label for="contact_email" class="float-left width-half"><?php echo lang('contact_email_label');?></label>
			<p><?php echo form_input('contact_email', $form_values->contact_email);?></p>
			
			<label for="contact_email" class="float-left width-half"><?php echo lang('contact_company_name_label');?></label>
			<p><?php echo form_input('company_name', $form_values->company_name);?></p>
			
			<label for="contact_email" class="float-left width-half"><?php echo lang('contact_subject_label');?></label>			
			<div class="width-half float-left">
				<p><?php echo form_dropdown('subject', $subjects, $form_values->subject, 'id="subject"');?></p>	
				<p><input id="other_subject" name="other_subject" type="text" class="float-left" /></p>
			</div>
			
		</fieldset>
		
		<fieldset>
			<legend><?php echo lang('contact_message_label');?></legend>
			
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
			
	<?php echo form_submit('submit', lang('contact_send_label'));?>                        
<?php echo form_close(); ?>