<?php echo form_open('admin/index');?>
	<h3>
		<div class="button float-right">
			<a href="<?php echo site_url('admin/media/folders/create');?>"><?php echo lang('media.folders.create'); ?></a>
		</div>

		<?php echo lang('media.folders.title');?>
	</h3>
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
								<?php echo anchor('admin/media/folders/delete/' . $folder->id, lang('media.labels.delete')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>

		<?php else: ?>
			<p><?php echo lang('media.folders.no_folders');?></p>
		<?php endif; ?>
<?php echo form_close();?>
