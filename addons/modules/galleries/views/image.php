<h2 id="page_title"><?php echo $gallery_image->title; ?></h2>
<!-- Div containing all galleries -->
<div class="galleries_container" id="gallery_image">
	<div class="gallery clearfix">
		<!-- Div containing the full sized image -->
		<div class="gallery_image_full">
			<img src="<?php echo BASE_URL.'uploads/galleries/' . $gallery->slug . '/full/' . $gallery_image->filename . $gallery_image->extension; ?>" alt="<?php echo $gallery_image->title; ?>" />
		</div>
		<?php if ( !empty($gallery_image->description) ):?>
		<!-- An image needs a description.. -->
		<div class="gallery_image_description">
			<p><?php echo $gallery_image->description; ?></p>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php if($gallery->enable_comments == 1): ?>
	<?php echo display_comments($gallery_image->id, 'gallery-image'); ?>
<?php endif; ?>
