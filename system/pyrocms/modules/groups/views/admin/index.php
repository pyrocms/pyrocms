<?php if ($groups): ?>
    <table class="table-list">
		<thead>
			<tr>
				<th width="40%"><?php echo lang('groups.name');?></th>
				<th><?php echo lang('groups.short_name');?></th>
				<th width="200" class="align-center"><?php echo lang('action_label'); ?></th>
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
		<?php foreach ($groups as $group):?>
			<tr>
				<td><?php echo $group->description; ?></td>
				<td><?php echo $group->name; ?></td>
				<td class="align-center buttons buttons-small">
				<?php echo anchor('admin/groups/edit/'.$group->id, lang('groups.edit'), 'class="button edit"'); ?>
				<?php if ( ! in_array($group->name, array('user', 'admin'))): ?>
					<?php echo anchor('admin/groups/delete/'.$group->id, lang('groups.delete'), 'class="confirm button delete"'); ?>
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('groups.no_groups');?></h2>
	</div>
<?php endif;?>