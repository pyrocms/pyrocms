<ul>
<?php foreach ($media_folders as $folder): ?>
	<li><a href="<?php echo site_url('admin/media/folders/contents/' . $folder->id); ?>"><?php echo $folder->name;?></a></li>
<?php endforeach; ?>
	<li><a href="<?php echo site_url('admin/media/folders'); ?>" title="folders"><span><?php echo lang('media.folders.manage_title'); ?></span></a></li>
</ul>
