<script type="text/javascript">
(function ($) { 
	$(function(){

		// Stops Firefox from being an ass and remembering YOUR password in this box
		$('input[name="password"], input[name="confirm_password"]').val('');
		
	});
})(jQuery);
</script>

<?=form_open($this->uri->uri_string()); ?>

	<div class="fieldset fieldsetBlock active tabs">
		<div class="header">
			
		<? if($this->uri->segment(3,'add') == 'add'): ?>
			<h3><?= lang('user_add_title');?></h3>
			
		<? else: ?>
			<h3><?= sprintf(lang('user_edit_title'), $member->full_name);?></h3>
		<? endif; ?>
		
		</div>
		
		<div class="tabs">
			
			<ul class="clear-both">
				<li><a href="#fieldset1"><span><?=lang('user_details_label');?></span></a></li>
				<li><a href="#fieldset2"><span><?=lang('user_password_label');?></span></a></li>
			</ul>
			
			<!-- Content tab -->
			<fieldset id="fieldset1">
				<legend><?= lang('user_details_label');?></legend>
				
				<div class="field">
					<label for="first_name"><?= lang('user_first_name_label');?></label>
					<?= form_input('first_name', $member->first_name); ?>
				</div>
				
				<div class="field">
					<label for="first_name"><?= lang('user_last_name_label');?></label>
					<?= form_input('last_name', $member->last_name); ?>
				</div>
				
				<div class="field">
					<label for="email"><?= lang('user_email_label');?></label>
					<?= form_input('email', $member->email); ?>
				</div>
				
				<div class="field">
					<label for="active"><?= lang('user_role_label');?></label>
					<?= form_dropdown('role', $roles, $member->role); ?>
				</div>
				
				<div class="field">
					<label for="active"><?= lang('user_activate_label');?></label>
					<?= form_checkbox('is_active', 1, $member->is_active == 1); ?>
				</div>
		
			</fieldset>
	
			<fieldset id="fieldset2">
				<legend><?= lang('user_password_label');?></legend>
			
				<div class="field">
					<label for="password"><?= lang('user_password_label');?></label>
					<?= form_password('password'); ?>
				</div>
				
				<div class="field">
					<label for="confirm_password"><?= lang('user_password_confirm_label');?></label>
					<?= form_password('confirm_password'); ?>
				</div>
				
			</fieldset>
			
		</div>
	</div>
			
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
	
<?=form_close(); ?>