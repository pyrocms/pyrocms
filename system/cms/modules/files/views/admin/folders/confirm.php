<?php if ($file_folders): ?>

<h2><?php echo lang('file_folders.delete_title'); ?></h2>
<div class="closable notification attention">
	<?php echo lang('file_folders.confirm_delete'); ?>
</div>

<?php echo form_open('admin/files/folders/delete/'); ?>
	<table border="0" class="table-list">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all', 'checked' => TRUE)); ?></th>
				<th><?php echo lang('files.name_label'); ?></th>
				<th width="100" class="align-center"><?php echo lang('file_folders.created_label'); ?></th>
				<th class="align-center">Subfolders</th>
				<th class="align-center">Files</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($file_folders as $folder): ?>
			<tr>
				<td><?php echo form_checkbox('action_to[]', $folder->id, TRUE); ?></td>
				<td><?php echo anchor('admin/files/folders/contents/' . $folder->id, repeater('&raquo; ', $folder->depth) . $folder->name, 'title="' . $folder->name .'" data-path="' . $folder->virtual_path . '" class="folder-hash"'); ?></td>
				<td class="align-center"><?php echo format_date($folder->date_added); ?></td>
				<td class="align-center"><?php echo $folder->count_subfolders; ?></td>
				<td class="align-center"><?php echo $folder->count_files; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<div class="align-center buttons buttons-small">
		<button type="button" name="btnAction" class="button cancel close-cbox">
			<span><?php echo lang('buttons.no'); ?></span>
		</button>
		<?php echo form_hidden('confirm_delete', 'yes'); ?>
		<button type="submit" name="btnAction" value="delete" class="button delete confirmation">
			<span><?php echo lang('buttons.yes'); ?></span>
		</button>
	</div>
<?php echo form_close(); ?>
<?php endif; ?>
