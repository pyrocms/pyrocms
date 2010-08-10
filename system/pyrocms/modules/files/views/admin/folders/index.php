<?php echo form_open('admin/files');?>
	<h3><?php echo lang('files.folders.manage_title'); ?></h3>
	
	<div id="files_toolbar">
		<ul>
			<li><a href="<?php echo site_url('admin/files/folders/create');?>" id="new_folder"><?php echo lang('files.folders.create'); ?></a></li>
		</ul>
	</div>
	
		<?php if (!empty($file_folders)): ?>

			<table border="0" class="table-list">
				<thead>
					<tr>
						<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
						<th><?php echo lang('files.folders.name');?></th>
						<th><?php echo lang('files.folders.created');?></th>
						<th class="width-10"><span><?php echo lang('files.labels.action');?></span></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($file_folders as $folder): ?>
						<tr>
							<td><?php echo form_checkbox('action_to[]', $folder->id);?></td>
							<td><?php echo $folder->name;?></td>
							<td><?php echo date("m.d.y \a\\t g.i a", $folder->date_added);?></td>
							<td>
								<?php echo anchor('admin/files/folders/edit/' . $folder->id, lang('files.labels.edit'));?> |
								<?php echo anchor('admin/files/folders/delete/' . $folder->id, lang('files.labels.delete'), array('class'=>'confirm')); ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>

		<?php else: ?>
			<p><?php echo lang('files.folders.no_folders');?></p>
		<?php endif; ?>
<?php echo form_close();?>
<script type="text/javascript">
	(function($)
	{
		$(function() {
			$("#new_folder").fancybox();
		});
	});
</script>