<?php echo form_open('admin/permissions/delete');?>

<?php if (!empty($groups)): ?>
<?php foreach ($groups as $group): ?>

	<h3><?php echo $group->title; ?></h3>

	<div class="float-right">
		<?php if (!in_array($group->name, array('user', 'admin'))): ?>
			<?php echo anchor('admin/groups/edit/'.$group->id, lang('groups.edit')); ?> }
			<?php echo anchor('admin/groups/delete/'.$group->id, lang('groups.delete'), 'class="delete_role"'); ?>
		<?php endif; ?>
	</div>

	<?php if (!empty($rules[$group->name])): ?>
		<table border="0" class="table-list clear-both spacer-bottom">
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th><?php echo lang('perm_module_label');?></th>
					<th><?php echo lang('perm_controller_label');?></th>
					<th><?php echo lang('perm_method_label');?></th>
					<th class="width-10"><span><?php echo lang('perm_action_label');?></span></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($rules[$group->name] as $navigation_link): ?>
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

		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>

	<?php else:?>
		<p><?php echo lang('perm_role_no_rules');?></p>
	<?php endif; ?>

<?php endforeach; ?>

<?php else: ?>
<p><?php echo lang('perm_no_roles');?></p>	
<?php endif; ?>

<?php echo form_close(); ?>