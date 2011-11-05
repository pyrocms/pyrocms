<style>
/* temp styles for permissions layout - need to work into site css */

.subpermissions {
	margin-top:10px;
	border:1px solid #ddd;
	border-radius:3px;
	background: #eee;
	padding:5px; 
	overflow:auto;

} 
.subpermissions .title {
	float:left;
	font-weight:bold;
	margin-right:12px;
	padding-top:3px;

}
.subpermissions .roles > ul {
	float:left; 
	border-left:1px solid #ddd;
	
}

.subpermissions .roles  li {
	padding: 0 6px 4px 6px;
	margin:0;

}
</style>

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
				<?php echo form_checkbox('modules[' . $module['slug'] . ']', TRUE, $module['checked']);?></td>
			<td>
				<?php echo $module['name']; ?>
			</td>
			<td>
				
				<?php foreach ($module['binary_roles'] as $role => $html): ?>
				
				<?php echo $html; ?>
				
				<?php endforeach; ?>
				
				

				<?php foreach ($module['array_roles'] as $rolename => $html): ?>
				
					<div class="subpermissions">
						<div class="title">
							<?php echo lang($module['slug'].'.role_'. $rolename); ?> : 
						</div>
						<div class="roles">	
							<?php echo $html; ?>
						</div>
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