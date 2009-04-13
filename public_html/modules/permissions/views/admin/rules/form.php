<?= form_open($this->uri->uri_string()); ?>

<fieldset>
	<legend>Who</legend>

	<p>Rules can be set for <strong>users <small>(almost finished)</small></strong> or for <strong>roles</strong>. Select the "Type" of rule and then select the user or user role it applies to.</p>

	<div class="field">
		<label for="module">Type</label>
		<span class="spacer-right"><?=form_radio('role_type', 'role', $permission_rule->permission_role_id > 0) ?> Role</span> 
		<?=form_radio('role_type', 'user', $permission_rule->user_id > 0) ?> User
	</div>
	
	<div class="field <?=$permission_rule->user_id == 0 ? 'hidden' : ''; ?>">
		<label for="user_id">User</label>
		<?=form_dropdown('user_id', array(''=>'-- Coming soon --'), NULL, 'disabled="disabled"') ?>
	</div>
	
	<div class="field <?=$permission_rule->permission_role_id == 0 ? 'hidden' : ''; ?>">
		<label for="permission_role_id">Role</label>
		<?=form_dropdown('permission_role_id', array(''=>'-- Select --')+$roles_select, $permission_rule->permission_role_id) ?>
	</div>
	
</fieldset>

<fieldset>
	<legend>What</legend>

	<div class="field">
		<label for="module">Module</label>
		<?=form_dropdown('module', $modules_select, $permission_rule->module) ?>
	</div>
	
	<div class="field">
		<label for="controller">Controller</label>
		<?=form_dropdown('controller', $controllers_select, $permission_rule->controller) ?>
	</div>
	
	<div class="field">
		<label for="method">Method</label>
		<?=form_dropdown('method', $methods_select, $permission_rule->method) ?>
	</div>

</fieldset>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
	
 <?= form_close(); ?>