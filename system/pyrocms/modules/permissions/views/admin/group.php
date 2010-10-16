<h3><?php echo $group->description; ?></h3>

<?php echo form_open(uri_string(), 'class="crud"'); ?>

	<table>
		<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>

		<?php foreach($module_groups as $module): ?>
			<tr>
				<td style="width: 30px"><?php echo form_checkbox('modules['.$module['slug'].']', 1, in_array($module['slug'], $edit_permissions)); ?></td>
				<td><?php echo $module['name']; ?></td>
			</tr>
		<?php endforeach; ?>

		</tbody>
	</table>

	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>

<?php echo form_close(); ?>