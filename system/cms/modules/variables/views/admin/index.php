<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

<section class="item">
<?php if ($variables): ?>

	<?php echo form_open('admin/variables/delete'); ?>
		<table border="0" class="table-list">
			<thead>
			<tr>
				<th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th width="20%"><?php echo lang('name_label');?></th>
				<th><?php echo lang('variables.data_label');?></th>
				<th width="20%"><?php echo lang('variables.syntax_label');?></th>
				<th width="140"></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach ($variables as $variable): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $variable->id); ?></td>
					<td><?php echo $variable->name;?></td>
					<td><?php echo $variable->data;?></td>
					<td><?php form_input('', printf('{{&nbsp;variables:%s&nbsp;}}', $variable->name));?></td>
					<td class="actions">
						<?php echo anchor('admin/variables/edit/' . $variable->id, lang('buttons.edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/variables/delete/' . $variable->id, lang('buttons.delete'), array('class'=>'confirm button delete')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		</div>
	<?php echo form_close(); ?>

<?php else: ?>
		<div class="no_data"><?php echo lang('variables.no_variables');?></div>
<?php endif; ?>
</section>