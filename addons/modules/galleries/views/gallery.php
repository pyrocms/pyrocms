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
				<?php echo anchor('galleries/' . $gallery->slug . '/' . $image->id,
								  img(array('src' => base_url() . 'files/thumb/' . $image->file_id, 'alt' => $image->name))); ?>
			</li>
			<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
</div>
<?php if ( ! empty($sub_galleries) ): ?>
<h2><?php echo lang('galleries.sub-galleries_label'); ?></h2>
<!-- Show all sub-galleries -->
<div class="sub_galleries_container">
	<?php foreach ( $sub_galleries as $gallery ): ?>
	<div class="gallery clearfix">
		<!-- Heading -->
		<div class="gallery_heading">
			<img src="<?php echo BASE_URL.'uploads/galleries/' . $gallery->filename; ?>" alt="<?php echo $gallery->name; ?>" />
			<h3><?php echo anchor('galleries/' . $gallery->slug, $gallery->name); ?></h3>
		</div>
		<!-- And the body -->
		<div class="gallery_body">
			<p>
				<?php if ( !empty($gallery->description) ) { echo $gallery->description; } else { echo "No description has been added yet.";} ?>
			</p>
		</div>
	</div>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<div class="clear-both"></div>

<?php if($gallery->enable_comments == 1): ?>
	<?php echo display_comments($gallery->id, 'gallery'); ?>
<?php endif; ?>
