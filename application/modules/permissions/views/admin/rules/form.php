<?= form_open($this->uri->uri_string()); ?>
<fieldset>
	<legend><?= lang('perm_who_label');?></legend>
	<p><?= lang('perm_rule_desc');?></p>	
	<div class="field">
		<label for="module"><?= lang('perm_type_label');?></label>
		<span class="spacer-right"><?=form_radio('role_type', 'role', $permission_rule->permission_role_id > 0) ?> <?= lang('perm_role_label');?></span> 
		<?=form_radio('role_type', 'user', $permission_rule->user_id > 0) ?> <?= lang('perm_user_label');?>
	</div>	
	<div class="field <?=$permission_rule->user_id == 0 ? 'hidden' : ''; ?>">
		<label for="user_id"><?= lang('perm_user_label');?></label>
		<?=form_dropdown('user_id', array(''=> lang('perm_user_select_default')), NULL, 'disabled="disabled"') ?>
	</div>	
	<div class="field <?=$permission_rule->permission_role_id == 0 ? 'hidden' : ''; ?>">
		<label for="permission_role_id"><?= lang('perm_role_label');?></label>
		<?=form_dropdown('permission_role_id', array(''=> lang('perm_rule_select_default'))+$roles_select, $permission_rule->permission_role_id) ?>
	</div>	
</fieldset>
<fieldset>
	<legend><?= lang('perm_what_label');?></legend>
	<div class="field">
		<label for="module"><?= lang('perm_module_label');?></label>
		<?=form_dropdown('module', $modules_select, $permission_rule->module) ?>
	</div>	
	<div class="field">
		<label for="controller"><?= lang('perm_controller_label');?></label>
		<?=form_dropdown('controller', $controllers_select, $permission_rule->controller) ?>
	</div>	
	<div class="field">
		<label for="method"><?= lang('perm_method_label');?></label>
		<?=form_dropdown('method', $methods_select, $permission_rule->method) ?>
	</div>
</fieldset>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>