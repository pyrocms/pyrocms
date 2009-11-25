<?php echo form_open('admin/permissions/delete');?>
<p class="float-right">[ <?php echo anchor('admin/permissions/roles/create', lang('perm_role_add')) ?> ]</p>
<br class="clear-both" />

<?php if (!empty($roles)): ?>	
	<?php foreach ($roles as $role): ?>
		<h3 class="float-left"><?php echo $role->title; ?></h3>	
		<p class="float-right">
			[ <?php echo anchor('admin/permissions/roles/edit/'.$role->id, lang('perm_role_edit')); ?> | 
			  <?php echo anchor('admin/permissions/roles/delete/'.$role->id, lang('perm_role_delete'), 'class="delete_role"'); ?> ]
		</p>		
		<table border="0" class="listTable clear-both spacer-bottom">		  
		  <thead>
				<tr>
					<th><?php echo form_checkbox('action_to_all');?></th>
					<th><a href="#"><?php echo lang('perm_module_label');?></a></th>
					<th><a href="#"><?php echo lang('perm_controller_label');?></a></th>
					<th><a href="#"><?php echo lang('perm_method_label');?></a></th>
					<th class="width-10"><span><?php echo lang('perm_action_label');?></span></th>
				</tr>
		  </thead>
		  <tfoot>
		  	<tr>
		  		<td colspan="5">
		  			<div class="inner"></div>
		  		</td>
		  	</tr>
		  </tfoot>
			<tbody>
			<?php if (!empty($rules[$role->abbrev])): ?>			
				<?php foreach ($rules[$role->abbrev] as $navigation_link): ?>
					<tr>
						<td><input type="checkbox" name="delete[<?php echo $navigation_link->id;?>]" /></td>
						<td><?php echo $navigation_link->module;?></td>
						<td><?php echo $navigation_link->controller; ?></td>
						<td><?php echo $navigation_link->method;?></td>
						<td>
							<?php echo anchor('admin/permissions/edit/' . $navigation_link->id, lang('perm_rule_edit')) . ' | '; ?>
							<?php echo anchor('admin/permissions/delete/' . $navigation_link->id, lang('perm_rule_delete'), array('class'=>'confirm'));?>
						</td>
					</tr>
				<?php endforeach; ?>			
			<?php else:?>
				<tr>
					<td colspan="5"><?php echo lang('perm_role_no_rules');?></td>
				</tr>
			<?php endif; ?>			
			</tbody>
	</table>	
	<br/>	
	<?php endforeach; ?>
	
<?php else: ?>
	<p><?php echo lang('perm_no_roles');?></p>	
<?php endif; ?>

<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>