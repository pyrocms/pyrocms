<h3><?php echo $gallery->title; ?></h3>

<p style="float:left; width: 40%;">
	<?php echo anchor('galleries/' . $gallery->slug, NULL, 'target="_blank"'); ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
	<?php echo anchor('admin/galleries/manage/' . $gallery->id, lang('galleries.manage_label'), ' target="_parent"'); ?>
</p>

<iframe src="<?php echo site_url('galleries/' . $gallery->slug); ?>" width="99%" height="400"></iframe>