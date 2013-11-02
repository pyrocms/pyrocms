<div class="p n-p-b">
	<?php file_partial('notices'); ?>
</div>

<div class="p">


	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('maintenance:export_data') ?></h3>
		</div>


		<!-- .panel-content -->
		<div class="panel-content">

		
			<?php if ( ! empty($tables)): ?>
				<table class="table n-m">
					<thead>
						<tr>
							<th><?php echo lang('maintenance:table_label') ?></th>
							<th class="align-center"><?php echo lang('maintenance:record_label') ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($tables as $table): ?>
						<tr>
							<td><?php echo $table['name'] ?></td>
							<td class="align-center"><?php echo $table['count'] ?></td>
							<td class="text-right">
								<?php if ($table['count'] > 0):
									echo anchor('admin/maintenance/export/'.$table['name'].'/xml', lang('maintenance:export_xml'), array('class'=>'btn-sm btn-success')).' ';
									echo anchor('admin/maintenance/export/'.$table['name'].'/csv', lang('maintenance:export_csv'), array('class'=>'btn-sm btn-success')).' ';
									echo anchor('admin/maintenance/export/'.$table['name'].'/json', lang('maintenance:export_json'), array('class'=>'btn-sm btn-success')).' ';
								endif ?>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif;?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->



	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('maintenance:list_label') ?></h3>
		</div>


		<!-- .panel-content -->
		<div class="panel-content">

		
			<?php if ( ! empty($folders)): ?>
				<table class="table n-m">
					<thead>
						<tr>
							<th><?php echo lang('name_label') ?></th>
							<th class="align-center"><?php echo lang('maintenance:count_label') ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($folders as $folder): ?>
						<tr>
							<td><?php echo $folder['name'] ?></td>
							<td class="align-center"><?php echo $folder['count'] ?></td>
							<td class="text-right">
								<?php if ($folder['count'] > 0) echo anchor('admin/maintenance/cleanup/'.$folder['name'], lang('global:empty'), array('class'=>'btn-sm btn-warning')) ?>
								<?php if ( ! $folder['cannot_remove']) echo anchor('admin/maintenance/cleanup/'.$folder['name'].'/1', lang('global:remove'), array('class'=>'btn-sm btn-warning')) ?>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php else: ?>
				<div class="margin padding alert alert-info">
					<h2><?php echo lang('maintenance:no_items') ?></h2>
				</div>
			<?php endif;?>

		
		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>