<table class="table table-hover n-m">

	<thead>
		<tr>
			<th><?php echo lang('name_label');?></th>
			<th class="collapse"><span><?php echo lang('desc_label');?></span></th>
			<th><?php echo lang('version_label');?></th>
			<th></th>
			<th></th>
		</tr>
		</thead>

	<tbody>
	<?php foreach ($plugins as $plugin): ?>
	<tr>
		<td width="30%"><?php echo $plugin['name'] ?></td>
		<td width="60%"><?php echo $plugin['description'] ?></td>
		<td><?php echo $plugin['version'] ?></td>
		<td class="text-right">
			<?php if ($plugin['self_doc']): ?>
				<a data-inline-modal="#<?php echo $plugin['slug'] ?>" href="<?php echo site_url('#') ?>" title="<?php echo lang('global:preview')?>" class="fa fa-search btn-sm btn-default"></a>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
	</tbody>

</table>
