<?php if ($file_folders): ?>

	<h3><?php echo lang('file_folders.manage_title'); ?></h3>

	<?php echo form_open('admin/files/folders/action', 'id="folders_list"');?>

		<table border="0" class="table-list">
			<thead>
				<tr>
					<th width="20">
						<?php if (group_has_role('files', 'delete_folder')): ?>
						<?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?>
						<?php endif; ?>
					</th>
					<th><?php echo lang('files.name_label'); ?></th>
					<th width="100" class="align-center"><?php echo lang('file_folders.created_label'); ?></th>
					<th width="200" class="align-center">
						<?php if (group_has_role('files', 'edit_folder') OR group_has_role('files', 'delete_folder')): ?>
						<?php echo lang('files.actions_label'); ?>
						<?php endif; ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="4">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
			<?php foreach ($file_folders as $folder): ?>
				<tr>
					<td>
						<?php if (group_has_role('files', 'delete_folder')): ?>
						<?php echo form_checkbox('action_to[]', $folder->id); ?>
						<?php endif; ?>
					</td>
					<td><?php echo anchor('admin/files/folders/contents/' . $folder->id, repeater('&raquo; ', $folder->depth) . $folder->name, 'title="' . $folder->name .'" data-path="' . $folder->virtual_path . '" class="folder-hash"'); ?></td>
					<td class="align-center"><?php echo format_date($folder->date_added); ?></td>
					<td class="align-center buttons buttons-small">
						<?php if (group_has_role('files', 'edit_folder')): ?>
						<?php echo anchor('admin/files/folders/edit/' . $folder->id, lang('buttons.edit'), 'class="folder-edit button edit"'); ?>
						<?php endif; ?>
						<?php if (group_has_role('files', 'delete_folder')): ?>
						<?php echo anchor('admin/files/folders/delete/' . $folder->id, lang('buttons.delete'), array('class'=>'confirm button delete')); ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		
		<?php if (group_has_role('files', 'delete_folder')): ?>
		<div class="buttons buttons-small align-right padding-top">
			<button type="submit" name="btnAction" value="delete" class="button delete confirm">
				<span><?php echo lang('buttons.delete'); ?></span>
			</button>
		</div>
		<?php endif; ?>
		
	<?php echo form_close();?>
<?php else: ?>
	<div class="blank-slate file-folders">
		<h2><?php echo lang('file_folders.no_folders');?>
		<br />[ <?php echo anchor('admin/files/folders/create', lang('file_folders.create_title'), 'class="folder-create"'); ?> ]</h2>
	</div>
<?php endif; ?>