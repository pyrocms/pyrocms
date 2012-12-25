<div class="one_full">
<section class="title">
	<h4><?php echo lang('addons:modules:addon_list');?></h4>
</section>

<section class="item">
	<div class="content">
		<?php if ($addon_modules): ?>
		<table class="table-list" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo lang('name_label');?></th>
					<th class="collapse"><span><?php echo lang('desc_label');?></span></th>
					<th><?php echo lang('version_label');?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($addon_modules as $module): ?>
				<tr>
					<td class="collapse"><?php echo ($module['is_backend'] and $module['installed']) ? anchor('admin/'.$module['slug'], $module['name']) : $module['name'] ?></td>
	
					<td><?php echo $module['description'] ?></td>
					<td class="align-center"><?php echo $module['version'] ?></td>
					<td class="actions">
						<?php if ($module['installed']): ?>
							<?php if ($module['enabled']): ?>
								<?php echo anchor('admin/addons/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm button small', 'title'=>lang('addons:modules:confirm_disable'))) ?>
							<?php else: ?>
								<?php echo anchor('admin/addons/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm button small', 'title'=>lang('addons:modules:confirm_enable'))) ?>
							<?php endif ?>
							<?php if ($module['is_current']): ?>
								<?php echo anchor('admin/addons/modules/uninstall/'.$module['slug'], lang('global:uninstall'), array('class'=>'confirm button small', 'title'=>lang('addons:modules:confirm_uninstall'))) ?>
							<?php else: ?>
								<?php echo anchor('admin/addons/modules/upgrade/'.$module['slug'], lang('global:upgrade'), array('class'=>'confirm button small', 'title'=>lang('addons:modules:confirm_upgrade'))) ?>
							<?php endif ?>
						<?php else: ?>
							<?php echo anchor('admin/addons/modules/install/'.$module['slug'], lang('global:install'), array('class'=>'confirm button small', 'title'=>lang('addons:modules:confirm_install'))) ?>
						<?php endif ?>
						<?php echo anchor('admin/addons/modules/delete/'.$module['slug'], lang('global:delete'), array('class'=>'confirm button small', 'title'=>lang('addons:modules:confirm_delete'))) ?>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
	
		<?php endif ?>
	</div>
</section>
</div>

<div class="one_full">
<section class="title">
	<h4><?php echo lang('addons:modules:core_list');?></h4>
</section>

<section class="item">
	<div class="content">
		<p><?php echo lang('addons:modules:core_introduction') ?></p>
	
		<table class="table-list" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo lang('name_label');?></th>
					<th><span><?php echo lang('desc_label');?></span></th>
					<th><?php echo lang('version_label');?></th>
					<th></th>
				</tr>
			</thead>	
			<tbody>
			<?php foreach ($core_modules as $module): ?>
			<?php if ($module['slug'] === 'addons') continue ?>
				<tr>
					<td><?php echo $module['is_backend'] ? anchor('admin/'.$module['slug'], $module['name']) : $module['name'] ?></td>
					<td><?php echo $module['description'] ?></td>
					<td class="align-center"><?php echo $module['version'] ?></td>
					<td class="actions">
					<?php if ($module['enabled']): ?>
	 					<?php echo anchor('admin/addons/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm button small', 'title'=>lang('addons:modules:confirm_disable'))) ?>
					<?php else: ?>
						<?php echo anchor('admin/addons/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm button small', 'title'=>lang('addons:modules:confirm_enable'))) ?>
					<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>	
		</table>
		
	</div>
</section>
</div>