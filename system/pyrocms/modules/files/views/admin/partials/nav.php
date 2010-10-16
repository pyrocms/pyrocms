<ul id="files-nav">
<?php foreach ($file_folders as $folder): ?>
	<li><a href="<?php echo site_url('admin/files/folders/contents/' . $folder->id); ?>" title="<?php echo $folder->slug; ?>"><?php echo $folder->name;?></a></li>
<?php endforeach; ?>
	<li><a href="<?php echo site_url('admin/files/folders'); ?>" title="folders"><span><?php echo lang('files.folders.manage_title'); ?></span></a></li>
</ul>
