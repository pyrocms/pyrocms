<h1><?php echo $image->title; ?></h1>

<p style="float:left; width: 40%;">
	<?php echo anchor('galleries/' . $image->gallery_slug . '/' . $image->id, NULL, 'target="_blank"'); ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
	<?php echo anchor('admin/galleries/manage/' . $image->gallery_id, lang('galleries.manage_label'), ' target="_parent"'); ?>
</p>

<iframe src="<?php echo site_url('galleries/' . $image->gallery_slug . '/' . $image->id); ?>" width="99%" height="400"></iframe>