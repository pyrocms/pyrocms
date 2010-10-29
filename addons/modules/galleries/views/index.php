<h2 id="page_title"><?php echo lang('galleries.galleries_label'); ?></h2>
<!-- Div containing all galleries -->
<div class="galleries_container" id="gallery_index">
	<?php if ( !empty($galleries) ): foreach ($galleries as $gallery): if (empty($gallery->parent)): ?>
	<div class="gallery clearfix">
		<!-- Heading -->
		<div class="gallery_heading">
			<?php if ( !empty($gallery->filename) ): ?>
			<img src="<?php echo BASE_URL.'uploads/galleries/' . $gallery->slug . '/thumbs/' . $gallery->filename . '_thumb' . $gallery->extension; ?>" alt="<?php echo $gallery->title; ?>" />
			<?php endif; ?>
			<h3><?php echo anchor('galleries/' . $gallery->slug, $gallery->title); ?></h3>
		</div>
		<!-- And the body -->
		<div class="gallery_description">
			<p>
				<?php if ( !empty($gallery->description) ) { echo $gallery->description; } else { echo "No description has been added yet.";} ?>
			</p>
		</div>
	</div>
	<?php endif; endforeach; else: ?>
	<p>No galleries have been added yet.</p>
	<?php endif; ?>
</div>