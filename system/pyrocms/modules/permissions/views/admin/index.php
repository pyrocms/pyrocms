<p><?php echo lang('permissions.introduction'); ?></p>

<table border="0" class="table-list">
	<thead>
		<tr>
			<th><?php echo lang('permissions.group'); ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>

<?php foreach ($groups as $group): ?>
		<tr>
			<td><?php echo $group->description; ?></td>
			<td class="buttons align-right">
				<?php echo anchor('admin/permissions/group/' . $group->id, lang('permissions.edit'), array('class'=>'button')); ?>
			</td>
		</tr>
<?php endforeach; ?>

	</tbody>
</table>