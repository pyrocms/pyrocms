<?php echo form_open('newsletters/subscribe', 'class="newsletter"'); ?>

	<?php if($options['html_upper']): ?>
	<p>
		<?php echo $options['html_upper']; ?>
	</p>
	<?php endif; ?>
	
	<p>
		<label for="email"><?php echo lang('letter_email_label');?></label>
		<?php echo form_input(array('name'=>'email', 'value'=>'user@example.com', 'size'=>20, 'onfocus'=>"this.value=''")); ?>
		<?php echo form_submit('btnSignup', lang('newsletters.subscribe')); ?>
	</p>

	<?php if($options['html_lower']): ?>
	<p>
		<?php echo $options['html_lower']; ?>		
	</p>
	<?php endif; ?>
<?php echo form_close(); ?>