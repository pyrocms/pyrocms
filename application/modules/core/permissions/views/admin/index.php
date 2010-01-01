<?php echo form_open('admin/permissions/delete');?>

<?php if (!empty($roles)): ?>	
	<?php foreach ($roles as $role): ?>
	
		<div class="box">
		
			<h3><?php echo $role->title; ?></h3>	
		
			<div class="box-container">
				
				<div class="float-right">
					<div class="button">
						<?php echo anchor('admin/permissions/roles/edit/'.$role->id, lang('perm_role_edit')); ?>
					</div>
					
					<div class="button">
						<?php echo anchor('admin/permissions/roles/delete/'.$role->id, lang('perm_role_delete'), 'class="delete_role"'); ?>
					</div>
				</div>
				
				<?php if (!empty($rules[$role->abbrev])): ?>
					<table border="0" class="table-list clear-both spacer-bottom">		  
					  <thead>
							<tr>
								<th><?php echo form_checkbox('action_to_all');?></th>
								<th><?php echo lang('perm_module_label');?></th>
								<th><?php echo lang('perm_controller_label');?></th>
								<th><?php echo lang('perm_method_label');?></th>
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
						</tbody>
				</table>
				
			<?php else:?>
				<p><?php echo lang('perm_role_no_rules');?></p>
			<?php endif; ?>	
			
		</div>
	</div>
	<?php endforeach; ?>
	
<?php else: ?>
	<p><?php echo lang('perm_no_roles');?></p>	
<?php endif; ?>

<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>