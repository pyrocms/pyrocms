<h3><?php echo lang('file_folders.folders_title'); ?></h3>
<ul id="files-nav">
	<?php if (group_has_role('files', 'edit_file')): ?>
	<li class="<?php echo ( ! $current_id) ? 'current' : NULL; ?>"><a href="<?php echo site_url('admin/files/folders'); ?>" title="<?php echo lang('file_folders.manage_title'); ?>" data-path="" class="folder-hash"><span><?php echo lang('file_folders.manage_title'); ?></span></a></li>
	<?php endif; ?>

	<?php foreach ($file_folders as $folder): ?>
	<?php if ( ! $folder->parent_id): ?>
	<li class="<?php echo ($current_id === $folder->id) ? 'current' : NULL; ?>"><a href="<?php echo site_url('admin/files/folders/contents/' . $folder->id); ?>" title="<?php echo $folder->name; ?>" data-path="<?php echo $folder->virtual_path; ?>" class="folder-hash"><?php echo $folder->name; ?></a></li>
	<?php endif; ?>
	<?php endforeach; ?>
</ul>