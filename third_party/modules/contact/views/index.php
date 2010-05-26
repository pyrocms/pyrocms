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
<?php echo validation_errors(); ?>
<?php echo form_open('contact');?>

<h3><?php echo lang('contact_details_label');?></h3>
<ul id="contact-details">
	<li>
		<label for="contact_email"><?php echo lang('contact_name_label');?></label>
		<?php echo form_input('contact_name', $form_values->contact_name);?>
	</li>
	<li>
		<label for="contact_email"><?php echo lang('contact_email_label');?></label>
		<?php echo form_input('contact_email', $form_values->contact_email);?>
	</li>
	<li>
		<label for="contact_email"><?php echo lang('contact_company_name_label');?></label>
		<?php echo form_input('company_name', $form_values->company_name);?>
	</li>
	<li>
		<label for="contact_email"><?php echo lang('contact_subject_label');?></label
		<?php echo form_dropdown('subject', $subjects, $form_values->subject, 'id="subject"');?>
		<input id="other_subject" name="other_subject" type="text" />
	</li>
</ul>

<?php echo form_close(); ?>