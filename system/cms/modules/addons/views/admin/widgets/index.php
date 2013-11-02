<div class="p">

	<div class="p-b">
		<?php file_partial('notices'); ?>
	</div>

	<section id="page-title">
		<h1><?php echo lang('addons:widgets') ?></h1>
	</section>


	<!-- .panel -->
	<section class="panel panel-default">
	
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('addons:plugins:core_field_types') ?></h3>
		</div>

		<!-- .panel-content -->
		<div class="panel-content">


			<?php if ($widgets): ?>
				<?php echo form_open(uri_string(), 'class="crud"') ?>
				<!-- Available Widget List -->

				<table class="table n-m">
					<thead>
					<tr>
						<th width="30"></th>
						<th width="20%"><?php echo lang('global:title') ?></th>
						<th><?php echo lang('desc_label') ?></th>
						<th width="130"><?php echo lang('global:author') ?></th>
						<th width="80" class="text-center"><?php echo lang('version_label') ?></th>
						<th width="150"></th>
					</tr>
					</thead>
					<tbody>
						<?php foreach ($widgets as $widget): ?>
						<tr>
							<td><span class="move-handle"></span></td>
							<td><?php echo $widget->name ?></td>
							<td><?php echo $widget->description ?></td>
							<td>
								<?php echo $widget->website ? anchor($widget->website, $widget->author, array('target' => '_blank')) : $widget->author ?>
							</td>
							<td class="text-center"><?php echo $widget->version ?></td>
							<td class="text-right">
							<?php if ($widget->enabled): ?>
								<?php echo anchor('admin/addons/widgets/disable/' . $widget->id, lang('buttons:disable'), 'class="btn btn-sm btn-warning disable"') ?>
							<?php else: ?>
								<?php echo anchor('admin/addons/widgets/enable/' . $widget->id, lang('buttons:enable'), 'class="btn btn-small btn-success enable"') ?>
							<?php endif ?>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				<?php echo form_close() ?>

			<?php else: ?>
				<p><?php echo lang('widgets:no_available_widgets') ?></p>
			<?php endif ?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>