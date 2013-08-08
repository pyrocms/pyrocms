<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('maintenance:export_data') ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php if ( ! empty($tables)): ?>
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th><?php echo lang('maintenance:table_label') ?></th>
							<th class="text-center"><?php echo lang('maintenance:record_label') ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($tables as $table): ?>
						<tr>
							<td><?php echo $table['name'] ?></td>
							<td class="text-center"><?php echo $table['count'] ?></td>
							<td>

								<div class="btn-group pull-right">
									<?php if ($table['count'] > 0):
										echo anchor('admin/maintenance/export/'.$table['name'].'/xml', lang('maintenance:export_xml'), array('class'=>'btn btn-small')).' ';
										echo anchor('admin/maintenance/export/'.$table['name'].'/csv', lang('maintenance:export_csv'), array('class'=>'btn btn-small')).' ';
										echo anchor('admin/maintenance/export/'.$table['name'].'/json', lang('maintenance:export_json'), array('class'=>'btn btn-small')).' ';
									endif ?>
								</div>

							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif;?>

		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>




<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('maintenance:list_label') ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php if ( ! empty($folders)): ?>
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th><?php echo lang('name_label') ?></th>
							<th class="text-center"><?php echo lang('maintenance:count_label') ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($folders as $folder): ?>
						<tr>
							<td><?php echo $folder['name'] ?></td>
							<td class="text-center"><?php echo $folder['count'] ?></td>
							<td>

								<div class="btn-group pull-right">
									<?php if ($folder['count'] > 0) echo anchor('admin/maintenance/cleanup/'.$folder['name'], lang('global:empty'), array('class'=>'btn btn-small btn-warning')) ?>
									<?php if ( ! $folder['cannot_remove']) echo anchor('admin/maintenance/cleanup/'.$folder['name'].'/1', lang('global:remove'), array('class'=>'btn btn-small btn-warning')) ?>
								</div>

							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php else: ?>
				<div class="blank-slate">
					<h2><?php echo lang('maintenance:no_items') ?></h2>
				</div>
			<?php endif;?>
	

		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>