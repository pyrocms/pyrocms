<?php $this->lang->load('newsletter'); ?>

<h2><?=lang('letter_letter_title');?></h2>
<p><?=lang('letter_subscripe_desc');?></p>

<?=form_open('newsletters/subscribe'); ?>
	<p>
		<label for="email"><?=lang('letter_email_label');?>:</label>
		<?=form_input(array('name'=>'email', 'value'=>'user@example.com', 'size'=>20, 'onfocus'=>"this.value=''")); ?>
	</p>
		
	<p><?=form_submit('btnSignup', lang('letter_subscripe_label')) ?></p>
<?=form_close(); ?>