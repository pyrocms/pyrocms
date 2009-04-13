<? if($this->uri->segment(3,'add') == 'add'): ?>
	<h2>Create user</h2>
	
<? else: ?>
	<h2>Edit user "<?= $member->full_name; ?>"</h2>
<? endif; ?>

<?=form_open($this->uri->uri_string()); ?>

<fieldset>
	<legend>Details</legend>
	
	<div class="field">
		<label for="first_name">First Name</label>
		<?= form_input('first_name', $member->first_name, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="first_name">Surname</label>
		<?= form_input('last_name', $member->last_name, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="email">E-mail</label>
		<?= form_input('email', $member->email, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="active">Activate</label>
		<?= form_checkbox('is_active', 1, $member->is_active == 1); ?>
	</div>
	
</fieldset>

<fieldset>
	<legend>Password</legend>

	<div class="field">
		<label for="password">Password</label>
		<?= form_password('password', '', 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="confirm_password">Confirm Password</label>
		<?= form_password('confirm_password', '', 'class="text"'); ?>
	</div>
	
</fieldset>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?=form_close(); ?>