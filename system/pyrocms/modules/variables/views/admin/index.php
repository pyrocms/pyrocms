<?php if ($variables): ?>  

	<h3><?php echo lang('variables.list_title');?></h3>

	<?php echo form_open('admin/variables/delete'); ?>
		<table border="0" class="table-list">
			<thead>
			<tr>
				<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th><?php echo lang('variables.name_label');?></th>
				<th><?php echo lang('variables.data_label');?></th>
				<th><?php echo lang('variables.syntax_label');?></th>
				<th class="width-10"><span><?php echo lang('variables.actions_label');?></span></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="3">
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
					<td><?php form_input('', printf('{pyro:variables:%s}', $variable->name));?></td>
					<td>
						<?php echo anchor('admin/variables/edit/' . $variable->id, lang('variables.edit_label'), 'rel="ajax-eip"') . ' | '; ?>
						<?php echo anchor('admin/variables/delete/' . $variable->id, lang('variables.delete_label'), array('class'=>'confirm'));?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="float-right">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		</div>
	<?php echo form_close(); ?>

<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('variables.no_variables');?></h2>
	</div>
<?php endif; ?>