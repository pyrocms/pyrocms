<? if($this->uri->segment(3,'add') == 'add'): ?>
	<h2><?= lang('user_add_title');?></h2>
	
<? else: ?>
	<h2><?= sprintf(lang('user_edit_title'), $member->full_name);?></h2>
<? endif; ?>

<?=form_open($this->uri->uri_string()); ?>
	<fieldset>
		<legend><?= lang('user_details_label');?></legend>
		
		<div class="field">
			<label for="first_name"><?= lang('user_first_name_label');?></label>
			<?= form_input('first_name', $member->first_name, 'class="text"'); ?>
		</div>
		
		<div class="field">
			<label for="first_name"><?= lang('user_last_name_label');?></label>
			<?= form_input('last_name', $member->last_name, 'class="text"'); ?>
		</div>
		
		<div class="field">
			<label for="email"><?= lang('user_email_label');?></label>
			<?= form_input('email', $member->email, 'class="text"'); ?>
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
	
	<fieldset>
		<legend><?= lang('user_password_label');?></legend>
	
		<div class="field">
			<label for="password"><?= lang('user_password_label');?></label>
			<?= form_password('password', '', 'class="text"'); ?>
		</div>
		
		<div class="field">
			<label for="confirm_password"><?= lang('user_password_confirm_label');?></label>
			<?= form_password('confirm_password', '', 'class="text"'); ?>
		</div>
		
	</fieldset>
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?=form_close(); ?>