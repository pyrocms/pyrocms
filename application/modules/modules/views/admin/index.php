<div class="box">
	<h3><?php echo lang('modules.installed_list');?></h3>

	<div class="box-container">
		<div style="text-align: right;">
			<div class="button">
				<a href="<?php echo site_url('admin/modules/install');?>"><?php echo lang('install_label'); ?></a>
			</div>
		</div>

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
				<tr>
					<td><?php echo $module['name']; ?></td>
					<td><?php echo $module['description']; ?></td>
					<td class="align-center"><?php echo $module['version']; ?></td>
					<td class="align-center">
					<?php if(!$module['is_core']): ?>
						<?php echo anchor('admin/modules/disable/' . $module['slug'], lang('disable_label'), "");?> |
						<?php echo anchor('admin/modules/uninstall/' . $module['slug'], lang('uninstall_label'), array('class'=>'confirm')); ?>
					<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>	
		</table>
		
	</div>
</div>