<h2 id="page_title"><?php echo lang('galleries.galleries_label'); ?></h2>
<!-- Div containing all galleries -->
<div class="galleries_container" id="gallery_index">
	<?php if ( ! empty($galleries)): foreach ($galleries as $gallery): if (empty($gallery->parent)): ?>
	<div class="gallery clearfix">
		<!-- Heading -->
		<div class="gallery_heading">
			<?php if ( ! empty($gallery->filename)): ?>
			<a href="<?php echo site_url() . 'galleries/' . $gallery->slug; ?>">
				<?php echo img(array('src' => site_url() . 'files/thumb/' . $gallery->file_id . '/150/150', 'alt' => $gallery->title)); ?>
			</a>
			<?php endif; ?>
			<h3><?php echo anchor('galleries/' . $gallery->slug, $gallery->title); ?></h3>
		</div>
		<!-- And the body -->
		<div class="gallery_description">
			<p>
				<?php echo ( ! empty($gallery->description)) ? $gallery->description : lang('galleries.no_gallery_description'); ?>
			</p>
		</div>
	</div>
	<?php endif; endforeach; else: ?>
	<p><?php echo lang('galleries.no_galleries_error'); ?></p>
	<?php endif; ?>
</div>