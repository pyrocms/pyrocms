<div class="box">

	<h3><?php echo lang('perm_rule_add'); ?></h3>

	<div class="box-container">
		<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>

			<fieldset>
				<ol>
					<li>
						<label for="module"><?php echo lang('perm_type_label');?></label>
						<span class="spacer-right"><?php echo form_radio('role_type', 'role', $permission_rule->permission_role_id > 0) ?> <?php echo lang('perm_role_label');?></span> 
						<?php echo form_radio('role_type', 'user', $permission_rule->user_id > 0) ?> <?php echo lang('perm_user_label');?>
					</li>
					
					<li class="even <?php echo $permission_rule->user_id == 0 ? 'hidden' : ''; ?>">
						<label for="user_id"><?php echo lang('perm_user_label');?></label>
						<?php echo form_dropdown('user_id', array(''=> lang('perm_user_select_default'))+$users_select, $permission_rule->user_id) ?>
					</li>
						
					<li class="even <?php echo $permission_rule->permission_role_id == 0 ? 'hidden' : ''; ?>">
						<label for="permission_role_id"><?php echo lang('perm_role_label');?></label>
						<?php echo form_dropdown('permission_role_id', array(''=> lang('perm_rule_select_default'))+$roles_select, $permission_rule->permission_role_id) ?>
					</li>	
				
					<li>
						<label for="module"><?php echo lang('perm_module_label');?></label>
						<?php echo form_dropdown('module', $modules_select, $permission_rule->module) ?>
					</li>
						
					<li class="even">
						<label for="controller"><?php echo lang('perm_controller_label');?></label>
						<?php echo form_dropdown('controller', $controllers_select, $permission_rule->controller) ?>
					</li>
						
					<li>
						<label for="method"><?php echo lang('perm_method_label');?></label>
						<?php echo form_dropdown('method', $methods_select, $permission_rule->method) ?>
					</li>
				</ol>
			</fieldset>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		
		<?php echo form_close(); ?>
	</div>
</div>