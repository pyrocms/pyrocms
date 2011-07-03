<h2 id="page_title"><?php echo $gallery->title; ?></h2>
<!-- Div containing all galleries -->
<div class="galleries_container" id="gallery_single">
	<div class="gallery clearfix">
		<!-- A gallery needs a description.. -->
		<div class="gallery_heading">
			<p><?php echo $gallery->description; ?></p>
		</div>
		<!-- The list containing the gallery images -->
		<ul class="galleries_list">
			<?php if ($gallery_images): ?>
			<?php foreach ( $gallery_images as $image): ?>
			<li>
				<a href="<?php echo site_url('galleries/' . $gallery->slug . '/' . $image->id); ?>" class="gallery-image" rel="gallery-image" data-src="<?php echo site_url() . 'files/large/' . $image->file_id; ?>" title="<?php echo $image->name; ?>">
					<?php echo img(array('src' => site_url() . 'files/thumb/' . $image->file_id, 'alt' => $image->name)); ?>
				</a>
			</li>
			<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</div>
<br style="clear: both;" />
<?php if ( ! empty($sub_galleries) ): ?>
<h2><?php echo lang('galleries.sub-galleries_label'); ?></h2>
<!-- Show all sub-galleries -->
<div class="sub_galleries_container">
	<?php foreach ($sub_galleries as $sub_gallery): ?>
	<div class="gallery clearfix">
		<!-- Heading -->
		<div class="gallery_heading">
			<?php if ( ! empty($sub_gallery->filename)) : ?>
			<a href="<?php echo site_url() . 'galleries/' . $sub_gallery->slug; ?>">
				<?php echo img(array('src' => site_url() . 'files/thumb/' . $sub_gallery->file_id, 'alt' => $sub_gallery->title)); ?>
			</a>
			<?php endif; ?>
			<h3><?php echo anchor('galleries/' . $sub_gallery->slug, $sub_gallery->title); ?></h3>
		</div>
		<!-- And the body -->
		<div class="gallery_body">
			<p>
				<?php echo ( ! empty($sub_gallery->description)) ? $sub_gallery->description : lang('galleries.no_gallery_description'); ?>
			</p>
		</div>
	</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<br style="clear: both;" />

<?php if ($gallery->enable_comments == 1): ?>
	<?php echo display_comments($gallery->id);?>
<?php endif; ?>