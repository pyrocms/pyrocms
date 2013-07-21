<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('addons:widgets') ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php if ($widgets): ?>
				<?php echo form_open(uri_string(), 'class="crud"') ?>
				<!-- Available Widget List -->

				<table id="widgets-list" class="table table-hover table-striped">
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
							<td><?php echo $widget->title ?></td>
							<td><?php echo $widget->description ?></td>
							<td>
								<?php echo $widget->website ? anchor($widget->website, $widget->author, array('target' => '_blank')) : $widget->author ?>
							</td>
							<td class="text-center"><?php echo $widget->version ?></td>
							<td class="text-center">

								<div class="btn-group">
									<?php if ($widget->enabled == '1'): ?>
										<?php echo anchor('admin/addons/widgets/disable/' . $widget->id, lang('buttons:disable'), 'class="btn btn-small btn-danger"') ?>
									<?php else: ?>
										<?php echo anchor('admin/addons/widgets/enable/' . $widget->id, lang('buttons:enable'), 'class="btn btn-small btn-success"') ?>
									<?php endif ?>
								</div>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				<?php echo form_close() ?>

			<?php else: ?>
				<p class="alert margin"><?php echo lang('widgets:no_available_widgets') ?></p>
			<?php endif ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->


</div>
</section>