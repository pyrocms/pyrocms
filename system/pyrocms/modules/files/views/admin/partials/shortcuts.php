<nav id="shortcuts">
	<h6><?php echo lang('cp_shortcuts_title'); ?></h6>
	<ul>
		<li><?php echo anchor('admin/files', lang('files.files_title'), ''); ?></li>
		<?php if (group_has_role('files', 'edit_file')): ?>
		<li><?php echo anchor('admin/files/folders/create', lang('file_folders.create_title'), 'class="add folder-create"'); ?></li>
		<li class="files-uploader <?php echo ! isset($folder->id) ? 'hidden' : NULL; ?>"><?php echo anchor('admin/files/upload', lang('files.upload_title'), 'class="open-files-uploader"'); ?></li>		
		<?php endif; ?>
	</ul>
	<br class="clear-both" />
</nav>