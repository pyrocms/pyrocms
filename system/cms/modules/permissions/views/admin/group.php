<section class="title">
	<h4><?php echo $group->description; ?></h4>
</section>

	<section class="item">
	<?php echo form_open(uri_string(), 'class="crud"'); ?>
	
	<table>
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th>Module</th>
				<th>Roles</th>
			</tr>
		</thead>
		<tbody>
	
	<?php foreach ($permission_modules as $module){ ?>
		<tr>
			<td style="width: 30px">
				<?php echo form_checkbox('modules[' . $module['slug'] . ']', TRUE, array_key_exists($module['slug'], $edit_permissions), 'id="'.$module['slug'].'"'); ?>
			</td>
			<td>
				<label class="inline" for="<?php echo $module['slug']; ?>"><?php echo $module['name']; ?></label>
			</td>
			<td>
			<?php 	if ( ! empty($module['roles']))
					{ 							
						foreach ($module['roles'] as $role)
						{
							if (is_array($role))
							{
								//use role permissions - keep as object rather than convert to array..any reason why not?
								$role_permissions =  @$edit_permissions[$module['slug']]->$role['name'];
								//css work needed below
								?>

								<div style="border:1px solid #e4e4e4; padding:5px 5px 8px 5px; border-radius:5px; margin-top:5px;">
									<span style="font-weight:bold; margin-right:12px;">
										<?php echo lang($module['slug'].'.role_'. $role['name'])?> : 
									</span>
																			
								<?php
								
								$query = $this->db->get($role['table']);
								
									foreach ($query->result() as $row) 
									{
									?>
										<label class="inline"><?php echo form_checkbox('module_roles[' . $module['slug'] . ']['.$role['name'] .']['.$row->id .']', TRUE, isset($edit_permissions[$module['slug']]) AND @$role_permissions->{$row->id} ); ?> 
										<?php echo $row->{$role['field']} ?></label>
									<?php
									}
								?>
								</div>
								<?php
							} 
							else 
							{
							?>
								<label class="inline"><?php echo form_checkbox('module_roles[' . $module['slug'] . ']['.$role.']', TRUE, isset($edit_permissions[$module['slug']]) AND array_key_exists($role, (array) $edit_permissions[$module['slug']])); ?>
								<?php echo lang($module['slug'].'.role_'.$role); ?></label>

							<?php
							};
						} //endforeach role; 
					} //endif; 
					?>
			 </td>
		 </tr>
	<?php } //endforeach module; ?>	
		</tbody>
	</table>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
	</div>
	
	<?php echo form_close(); ?>
</section>