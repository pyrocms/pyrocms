<section class="box">

	<header>
		<h3><?php echo lang('modules.addon_list');?></h3>
	</header>
		
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
			<?php foreach($all_modules as $module): ?>
			<?php if($module['is_core']) continue; ?>
				<tr>
					<td><?php echo $module['is_backend'] ? anchor('admin/'  . $module['slug'], $module['name']) : $module['name']; ?></td>
					<td><?php echo $module['description']; ?></td>
					<td class="align-center"><?php echo $module['version']; ?></td>
					<td class="align-center">

					<?php if ($module['installed']): ?>

						<?php if ($module['enabled']): ?>
							<?php echo anchor('admin/modules/disable/' . $module['slug'], lang('disable_label'), array('class'=>'confirm minibutton', 'title'=>lang('modules.confirm_disable'))); ?>
						<?php else: ?>
							<?php echo anchor('admin/modules/enable/' . $module['slug'], lang('enable_label'), array('class'=>'confirm minibutton', 'title'=>lang('modules.confirm_enable'))); ?>
						<?php endif; ?>
						&nbsp;&nbsp;
						<?php echo anchor('admin/modules/uninstall/' . $module['slug'], lang('uninstall_label'), array('class'=>'confirm minibutton', 'title'=>lang('modules.confirm_uninstall'))); ?>

					<?php else: ?>
						
						<?php echo anchor('admin/modules/install/' . $module['slug'], lang('install_label'), array('class'=>'confirm minibutton', 'title'=>lang('modules.confirm_install'))); ?>

					<?php endif; ?>

					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

</section>

<section class="box">
	<header>
		<h3><?php echo lang('modules.core_list');?></h3>
	</header>

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
			<?php foreach($all_modules as $module): ?>
			<?php if(!$module['is_core']) continue; ?>
				<tr>
					<td><?php echo $module['is_backend'] ? anchor('admin/'  . $module['slug'], $module['name']) : $module['name']; ?></td>
					<td><?php echo $module['description']; ?></td>
					<td class="align-center"><?php echo $module['version']; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>	
		</table>
		
</section>