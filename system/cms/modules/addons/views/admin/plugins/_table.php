<table class="table table-hover table-bordered table-striped">

	<thead>
		<tr>
			<th><?php echo lang('name_label');?></th>
			<th class="collapse"><span><?php echo lang('desc_label');?></span></th>
			<th><?php echo lang('version_label');?></th>
			<th></th>
		</tr>
		</thead>

	<tbody>
	<?php foreach ($plugins as $plugin): ?>
	<tr>
		<td width="30%"><?php echo $plugin['name'] ?></td>
		<td width="60%"><?php echo $plugin['description'] ?></td>
		<td><?php echo $plugin['version'] ?></td>
		<td><?php if ($plugin['self_doc']): ?>
			<a  href="#plugin-<?php echo $plugin['slug'] ?>" 
				title="<?php echo lang('global:preview')?>" 
				class="icon-search ti"
				role="button"
				data-toggle="modal">&nbsp;</a>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
	</tbody>

</table>