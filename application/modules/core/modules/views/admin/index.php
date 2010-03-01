<div class="box">
	<h3><?php echo lang('modules.installed_list');?></h3>

	<div class="box-container">

		<p><?php echo lang('modules.introduction'); ?></p>
		
		<table class="table-list">
			<thead>
				<tr>
					<th></th>
					<th><?php echo lang('name_label');?></th>
					<th><span><?php echo lang('desc_label');?></span></th>
					<th><?php echo lang('version_label');?></th>
				</tr>
			</thead>	
			<tbody>
			<?php foreach($modules as $module): ?>
				<tr>
					<td></td>
					<td><?php echo $module['name']; ?></td>
					<td><?php echo $module['description']; ?></td>
					<td class="align-center"><?php echo $module['version']; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>	
		</table>
		
	</div>
</div>