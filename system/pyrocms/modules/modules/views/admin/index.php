<div class="box">
	<h3><?php echo lang('modules.addon_list');?></h3>
	<div class="box-container">
		<p><?php echo lang('modules.introduction'); ?></p>

		<table class="table-list">
			<thead>
				<tr>
					<th><?php echo lang('name_label');?></th>
					<th><span><?php echo lang('desc_label');?></span></th>
					<th><?php echo lang('version_label');?></th>
					<th class="align-center"><?php echo lang('action_label'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($modules as $module): ?>
			<?php if($module['is_core']) continue; ?>
				<tr>
					<td><?php echo $module['is_backend'] ? anchor('admin/'  . $module['slug'], $module['name']) : $module['name']; ?></td>
					<td><?php echo $module['description']; ?></td>
					<td class="align-center"><?php echo $module['version']; ?></td>
					<td class="align-center">
					<?php $make_status = ($module['enabled']) ? 'disable' : 'enable'; ?>
					<?php echo anchor('admin/modules/' . $make_status . '/' . $module['slug'], lang($make_status . '_label'), "");?>
					<?php echo ' | ' . anchor('admin/modules/uninstall/' . $module['slug'], lang('uninstall_label'), array('class'=>'confirm')); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

	</div>
</div>

<div class="box">
	<h3><?php echo lang('modules.core_list');?></h3>

	<div class="box-container">
		<p><?php echo lang('modules.introduction'); ?></p>

		<table class="table-list">
			<thead>
				<tr>
					<th><?php echo lang('name_label');?></th>
					<th><span><?php echo lang('desc_label');?></span></th>
					<th><?php echo lang('version_label');?></th>
				</tr>
			</thead>	
			<tbody>
			<?php foreach($modules as $module): ?>
			<?php if(!$module['is_core']) continue; ?>
				<tr>
					<td><?php echo $module['name']; ?></td>
					<td><?php echo $module['description']; ?></td>
					<td class="align-center"><?php echo $module['version']; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>	
		</table>
		
	</div>
</div>