<section class="title">
	<h4><?php echo lang('modules.addon_list');?></h4>
</section>

<section class="item">		
		<p><?php echo lang('modules.introduction'); ?></p>

		<table class="table-list">
			<thead>
				<tr>
					<th><?php echo lang('name_label');?></th>
					<th class="collapse"><span><?php echo lang('desc_label');?></span></th>
					<th><?php echo lang('version_label');?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($all_modules as $module): ?>
			<?php if ($module['is_core']) continue; ?>
				<tr>
					<td class="collapse"><?php echo ($module['is_backend'] AND $module['installed']) ? anchor('admin/'.$module['slug'], $module['name']) : $module['name']; ?></td>
					<td><?php echo $module['description']; ?></td>
					<td class="align-center"><?php echo $module['version']; ?></td>
					<td class="actions">
						<?php if ($module['installed']): ?>
							<?php if ($module['enabled']): ?>
								<?php echo anchor('admin/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm button small', 'title'=>lang('modules.confirm_disable'))); ?>
							<?php else: ?>
								<?php echo anchor('admin/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm button small', 'title'=>lang('modules.confirm_enable'))); ?>
							<?php endif; ?>
							<?php if ($module['is_current']): ?>
								<?php echo anchor('admin/modules/uninstall/'.$module['slug'], lang('global:uninstall'), array('class'=>'confirm button small', 'title'=>lang('modules.confirm_uninstall'))); ?>
							<?php else: ?>
								<?php echo anchor('admin/modules/upgrade/'.$module['slug'], lang('global:upgrade'), array('class'=>'confirm button small', 'title'=>lang('modules.confirm_upgrade'))); ?>
							<?php endif; ?>
						<?php else: ?>
							<?php echo anchor('admin/modules/install/'.$module['slug'], lang('global:install'), array('class'=>'confirm button small', 'title'=>lang('modules.confirm_install'))); ?>
						<?php endif; ?>
						<?php echo anchor('admin/modules/delete/'.$module['slug'], lang('global:delete'), array('class'=>'confirm button small', 'title'=>lang('modules.confirm_delete'))); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

</section>

<section class="title">
	<h4><?php echo lang('modules.core_list');?></h4>
</section>

<section class="item">
		<p><?php echo lang('modules.core_introduction'); ?></p>

		<table class="table-list">
			<thead>
				<tr>
					<th><?php echo lang('name_label');?></th>
					<th><span><?php echo lang('desc_label');?></span></th>
					<th><?php echo lang('version_label');?></th>
					<th></th>
				</tr>
			</thead>	
			<tbody>
			<?php foreach($all_modules as $module): ?>
			<?php if ( ! $module['is_core']) continue; ?>
				<tr>
					<td><?php echo $module['is_backend'] ? anchor('admin/' .$module['slug'], $module['name']) : $module['name']; ?></td>
					<td><?php echo $module['description']; ?></td>
					<td class="align-center"><?php echo $module['version']; ?></td>
					<td class="actions">
					<?php if ($module['enabled']): ?>
     					<?php echo anchor('admin/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm button small', 'title'=>lang('modules.confirm_disable'))); ?>
					<?php else: ?>
						<?php echo anchor('admin/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm button small', 'title'=>lang('modules.confirm_enable'))); ?>
					<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>	
		</table>
		
</section>