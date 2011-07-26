<div id="upload-box">
	<h2><?php echo lang('files.upload_title'); ?><span class="close ui-icon ui-icon-closethick"><?php echo lang('buttons.close'); ?></span></h2>
	<?php echo form_open_multipart('admin/wysiwyg/upload'); ?>
		<?php echo form_hidden('redirect_to', 'files'); ?>
		<p>
			<?php echo form_input('name', set_value('name',lang('file_folders.name_label'))); ?>
			<?php echo form_upload('userfile'); ?>
		</p>
		<p>
			<?php echo form_dropdown('type', $file_types, array($this->input->post('type'))); ?>
		</p>
		<p>
			<?php echo form_dropdown('folder_id', array(0 => lang('files.dropdown_no_subfolders')) + $folders_tree); ?>
		</p>
		<p>
			<?php echo form_submit('button_action', lang('buttons.save'), 'class="button"'); ?>
		</p>
	<?php echo form_close(); ?>
</div>
<div id="files_browser">
    <div id="files_left_pane">
        <h3><?php echo lang('file_folders.folders_label'); ?></h3>
		<ul id="files-nav">
		<?php foreach ($folders as $folder): ?>
		<?php if ( ! $folder->parent_id): ?>
			<li id="folder-id-<?php echo $folder->id; ?>" class="<?php echo $current_folder && $current_folder->id == $folder->id ? 'current' : ''; ?>">
				<?php echo anchor("admin/wysiwyg/files/index/{$folder->id}", $folder->name, 'title="'.$folder->slug.'"'); ?>
			</li>
		<?php endif; ?>
		<?php endforeach; ?>
		<?php if ($folders): ?>
			<li class="upload">
				<?php echo anchor("admin/wysiwyg/files/upload", lang('files.upload_title'), 'title="upload"'); ?>  
			</li>
		<?php endif; ?>
		</ul>
	</div>
	<div id="files_right_pane">
		<div id="files-wrapper">
		<?php if ($current_folder): ?>
			<h3><?php echo $current_folder->name; ?></h3>
			<!-- subfolders -->
			<div id="files_toolbar">
				<ul>
					<li>
						<label for="folder"><?php echo lang('file_folders.subfolders_label'); ?>:</label>
						<?php echo form_dropdown('parent_id', $subfolders, $current_folder->id, 'id="parent_id" title="files"'); ?>
					</li>
				</ul>
			</div>
			<?php  if ($current_folder->items): ?>
			<table class="table-list" border="0">
				<thead>
					<tr>
						<th><?php echo lang('files.actions_label'); ?></th>
						<th><?php echo lang('files.name_label') . '/' . lang('files.description_label'); ?></th>
						<th><?php echo lang('files.file_name') . '/' . lang('file_folders.created_label'); ?></th>
						<th><?php echo lang('wysiwyg.meta.mime'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($current_folder->items as $file): ?>
					<tr class="<?php echo alternator('', 'alt'); ?>">
						<td class="image">
							<button onclick="javascript:insertFile('<?php echo $file->id; ?>', '<?php echo htmlentities($file->name); ?>');">
								Insert
							</button>
						</td>
						<td class="name-description">
							<p><?php echo $file->name; ?><p>
							<p><?php echo $file->description; ?></p>
						</td>
						<td class="filename">
							<p><?php echo $file->filename; ?></p>
							<p><?php echo format_date($file->date_added); ?></p>
						</td>
						<td class="meta width"><?php echo $file->mimetype; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php else: ?>
			<p><?php echo lang('files.no_files'); ?></p>
			<?php endif; ?>
		<?php else: ?>
			<div class="blank-slate file-folders">
				<h2><?php echo lang('file_folders.no_folders');?></h2>
			</div>
		<?php endif; ?>
		</div>
	</div>
</div>