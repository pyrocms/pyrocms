<?php if (!empty($groups)): ?>
    <table class="table-list">
		<thead>
			<tr>
				    <th width="20%"><?php echo lang('groups.name');?></th>
				    <th width="45%"><?php echo lang('groups.description');?></th>
				    <th width="10%"></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($groups as $group):?>
			<tr>
				<td><?php echo $group->name; ?></td>
				<td><?php echo $group->description; ?></td>
				<td>
					<?php if (!in_array($group->name, array('user', 'admin'))): ?>
						<?php echo anchor('admin/groups/edit/'.$group->id, lang('groups.edit')); ?>&nbsp;&nbsp;|&nbsp;&nbsp;
						<?php echo anchor('admin/groups/delete/'.$group->id, lang('groups.delete')); ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php else: ?>
    <p><?php echo lang('groups.no_groups'); ?></p>
<?php endif;?>