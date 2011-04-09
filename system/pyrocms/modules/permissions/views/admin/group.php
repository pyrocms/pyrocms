<h3><?php echo $group->description; ?></h3>

<?php echo form_open(uri_string(), 'class="crud"'); ?>

	<table>
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th>Module</th>
				<th>Roles</th>
			</tr>
		</thead>
		<tbody>

		<?php foreach ($permisison_modules as $module): ?>
			<tr>
				<td style="width: 30px"><?php echo form_checkbox('modules[' . $module['slug'] . ']', 1, in_array($module['slug'], $edit_permissions)); ?></td>
				<td>
					<?php echo $module['name']; ?>
				</td>
	
				<td>
					<?php if ( ! empty($module['roles'])): ?>
	
						<?php foreach ($module['roles'] as $role): ?>
	
							<?php echo form_checkbox('module_roles[' . $module['slug'] . ']['.$role.']', 1); ?>
							<?php echo lang('blog.role_'.$role); ?>
	
						<?php endforeach; ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>

		</tbody>
	</table>

	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
	</div>

<?php echo form_close(); ?>