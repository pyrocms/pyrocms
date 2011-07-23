<?php if ($widgets): ?>

	<h3><?php echo lang($widgets_active ? 'widgets.active_title' : 'widgets.inactive_title'); ?></h3>

	<?php echo form_open(uri_string(), 'class="crud"'); ?>
	<!-- Available Widget List -->

	<table border="0" id="widgets-list" class="table-list">
		<thead>
		<tr>
			<th width="30"></th>
			<th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
			<th width="20%"><?php echo lang('title_label'); ?></th>
			<th><?php echo lang('desc_label'); ?></th>
			<th width="130"><?php echo lang('author_label'); ?></th>
			<th width="80" class="align-center"><?php echo lang('version_label'); ?></th>
			<th width="150" class="align-center"><span><?php echo lang('actions_label');?></span></th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($widgets as $widget): ?>
			<tr>
				<td><span class="move-handle"></span></td>
				<td><?php echo form_checkbox('action_to[]', $widget->id); ?></td>
				<td><?php echo $widget->title; ?></td>
				<td><?php echo $widget->description; ?></td>
				<td>
					<?php echo $widget->website ? anchor($widget->website, $widget->author, array('target' => '_blank')) : $widget->author; ?>
				</td>
				<td class="align-center"><?php echo $widget->version; ?></td>
				<td class="align-center buttons buttons-small actions">
				<?php if ($widgets_active): ?>
					<?php echo anchor('admin/widgets/disable/' . $widget->id, lang('buttons.disable'), 'class="button disable"'); ?>
				<?php else: ?>
					<?php echo anchor('admin/widgets/enable/' . $widget->id, lang('buttons.enable'), 'class="button enable"'); ?>
				<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php /* ?>
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save'))); ?>
	</div>
 <?php */ ?>
	<?php echo form_close(); ?>

<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('widgets.no_available_widgets'); ?></h2>
	</div>
<?php endif; ?>