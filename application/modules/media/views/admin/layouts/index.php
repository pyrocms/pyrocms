<div class="tabs">
	<?php echo $template['partials']['nav']; ?>

	<div id="images">
		<?php echo form_open('admin/index');?>
		<div id="toolbar">
			<ul>
				<li>
					<label for="folder"><?php echo lang('media.folders.label'); ?>:</label>
					<?php echo form_dropdown('folder', $folders, $selected_folder); ?>
				</li>
			</ul>
		</div>
		<?php if (!empty($media_folders)): ?>

			<table border="0" class="table-list">
				<thead>
					<tr>
						<th><?php echo form_checkbox('action_to_all');?></th>
						<th><?php echo lang('media.folders.name');?></th>
						<th><?php echo lang('media.folders.created');?></th>
						<th class="width-10"><span><?php echo lang('media.labels.action');?></span></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($media_folders as $folder): ?>
						<tr>
							<td><?php echo form_checkbox('action_to[]', $folder->id);?></td>
							<td><?php echo $folder->name;?></td>
							<td><?php echo date("m.d.y \a\\t g.i a", $folder->date_added);?></td>
							<td>
								<?php echo anchor('admin/media/folders/edit/' . $folder->id, lang('media.labels.edit'));?> |
								<?php echo anchor('admin/media/folders/delete/' . $folder->id, lang('media.labels.delete'), array('class'=>'confirm')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>

		<?php else: ?>
			<p><?php echo lang('media.no_files');?></p>
		<?php endif; ?>

		<?php echo form_close();?>
	</div>
	<div id="documents">&nbsp;</div>
	<div id="video">&nbsp;</div>
	<div id="audio">&nbsp;</div>
	<div id="folders">&nbsp;</div>
</div>