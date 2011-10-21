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
	
	<?php foreach ($permission_modules as $module): ?>
		<tr>
			<td style="width: 30px">
				<?php echo form_checkbox('modules[' . $module['slug'] . ']', TRUE, $module['checked'], 'id="'.$module['slug'].'"');?>
			</td>
			<td>
				<label class="inline" for="<?php echo $module['slug']; ?>"><?php echo $module['name']; ?></label>
			</td>
			<td>
				<?php foreach ($module['binary_roles'] as $rolename => $checked): ?>
					<label class="inline">
					<?php echo form_checkbox('module_roles[' . $module['slug'] . ']['.$rolename.']',TRUE, $checked);?> 
					<?php echo lang($module['slug'].'.role_'.$rolename); ?>
					</label>
				<?php endforeach; ?>
				
				<?php foreach ($module['array_roles'] as $rolename => $subs): ?>
					<?php 
					//TODO: css input needed here
					?>
					<div style="border:1px solid #e4e4e4; padding:5px; margin-top:5px;">
						<label style="margin-right:12px;">
							<?php echo lang($module['slug'].'.role_'. $rolename)?> : 
						</label>
						<?php foreach ($subs as $subid => $sub): ?>
							<label class="inline">
							<?php echo form_checkbox('module_roles[' . $module['slug'] . ']['.$rolename .']['.$subid .']', TRUE, $sub['checked']); ?>
							<?php echo $sub['name']; ?>
							</label>
						<?php endforeach; ?>

					</div>				
 				<?php endforeach; ?>
				
			</td>
		</tr>
	<?php endforeach; ?>

		</tbody>
	</table>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
	</div>
	
	<?php echo form_close(); ?>
</section>