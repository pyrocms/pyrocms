<div class="p n-p-b">
	<?php file_partial('notices'); ?>
</div>

<div class="p">

	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('addons:modules:addon_list');?></h3>
		</div>


		<!-- .panel-content -->
		<div class="panel-content">
			
			<?php if ($addon_modules): ?>
			<table class="table table-hover n-m">
				<thead>
					<tr>
						<th><?php echo lang('name_label');?></th>
						<th><span><?php echo lang('desc_label');?></span></th>
						<th class="text-center"><?php echo lang('version_label');?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($addon_modules as $module): ?>
					<tr>
						<th ><?php echo ($module['is_backend'] and $module['installed']) ? anchor('admin/'.$module['slug'], $module['name']) : $module['name'] ?></th>

						<td><?php echo $module['description'] ?></td>
						<td class="text-center"><?php echo $module['version'] ?></td>
						<td class="text-right">
							<?php if ($module['installed']): ?>
								<?php if ($module['enabled']): ?>
									<?php echo anchor('admin/addons/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm btn-sm btn-warning', 'title'=>lang('addons:modules:confirm_disable'))) ?>
								<?php else: ?>
									<?php echo anchor('admin/addons/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm btn-sm btn-success', 'title'=>lang('addons:modules:confirm_enable'))) ?>
								<?php endif ?>
								<?php if ($module['is_current']): ?>
									<?php echo anchor('admin/addons/modules/uninstall/'.$module['slug'], lang('global:uninstall'), array('class'=>'confirm btn-sm btn-danger', 'title'=>lang('addons:modules:confirm_uninstall'))) ?>
								<?php else: ?>
									<?php echo anchor('admin/addons/modules/upgrade/'.$module['slug'], lang('global:upgrade'), array('class'=>'confirm btn-sm btn-warning', 'title'=>lang('addons:modules:confirm_upgrade'))) ?>
								<?php endif ?>
							<?php else: ?>
								<?php echo anchor('admin/addons/modules/install/'.$module['slug'], lang('global:install'), array('class'=>'confirm btn-sm btn-success', 'title'=>lang('addons:modules:confirm_install'))) ?>
							<?php endif ?>
							<?php echo anchor('admin/addons/modules/delete/'.$module['slug'], lang('global:delete'), array('class'=>'confirm btn-sm btn-danger', 'title'=>lang('addons:modules:confirm_delete'))) ?>
						</td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
			<?php endif ?>

		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->



	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<p><h3 class="panel-title"><?php echo lang('addons:modules:core_list');?></h3></p>
			<p><?php echo lang('addons:modules:core_introduction') ?></p>
		</div>


		<!-- .panel-content -->
		<div class="panel-content">

			<table class="table table-hover n-m">
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
						<th><?php echo $module['is_backend'] ? anchor('admin/'.$module['slug'], $module['name']) : $module['name'] ?></th>
						<td><?php echo $module['description'] ?></td>
						<td class="align-center"><?php echo $module['version'] ?></td>
						<td class="text-right">
						<?php if ($module['enabled']): ?>
		 					<?php echo anchor('admin/addons/modules/disable/'.$module['slug'], lang('global:disable'), array('class'=>'confirm btn-sm btn-warning', 'title'=>lang('addons:modules:confirm_disable'))) ?>
						<?php else: ?>
							<?php echo anchor('admin/addons/modules/enable/'.$module['slug'], lang('global:enable'), array('class'=>'confirm btn-sm btn-success', 'title'=>lang('addons:modules:confirm_enable'))) ?>
						<?php endif ?>
						</td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>

		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>