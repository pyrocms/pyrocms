<div class="accordion-group ">
<section class="accordion-heading">
	<h4><?php echo lang('addons:widgets') ?></h4>
</div>
<div class="accordion-body collapse in lst">
<div class="content">
<?php if ($widgets): ?>
	<?php echo form_open(uri_string(), 'class="crud"') ?>
	<!-- Available Widget List -->

	<table class="table table-striped" id="widgets-list" cellspacing="0">
		<thead>
		<tr>
			<th width="30"></th>
			<th width="20%"><?php echo lang('global:title') ?></th>
			<th><?php echo lang('desc_label') ?></th>
			<th width="130"><?php echo lang('global:author') ?></th>
			<th width="80" class="align-center"><?php echo lang('version_label') ?></th>
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
				<td class="align-center"><?php echo $widget->version ?></td>
				<td class="align-center buttons buttons-small actions">
				<?php if ($widget->enabled == '1'): ?>
					<?php echo anchor('admin/addons/widgets/disable/' . $widget->id, lang('buttons:disable'), 'class="button disable btn"') ?>
				<?php else: ?>
					<?php echo anchor('admin/addons/widgets/enable/' . $widget->id, lang('buttons:enable'), 'class="button enable btn"') ?>
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
</section>
</div>