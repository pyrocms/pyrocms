<table class="table-list" cellspacing="0">

	<thead>
		<tr>
			<th><?php echo lang('name_label');?></th>
			<th class="collapse"><span><?php echo lang('desc_label');?></span></th>
			<th><?php echo lang('version_label');?></th>
		</tr>
		</thead>

	<tbody>
	<?php foreach ($plugins as $plugin): ?>
	<tr>
		<td width="30%"><?php echo $plugin['name'] ?></td>
		<td width="60%"><?php echo $plugin['description'] ?></td>
		<td><?php echo $plugin['version'] ?></td>
	</tr>
	<?php endforeach ?>
	</tbody>

</table>