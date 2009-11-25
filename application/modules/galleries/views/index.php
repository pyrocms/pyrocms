<h2><?php echo lang('gal_photo_galleries_title');?></h2>
<?php if ($galleries): ?>	
	<ul class="galleryHolder">
		<?php foreach ($galleries as $gallery): ?>
			<li<?php echo $gallery->slug == 'home' ? 'class="box-hidden"' : '' ?>>
				<?php echo anchor('galleries/' . $gallery->slug, $gallery->title);?><br />
				<?php echo $gallery->description; ?><br />
				<?php echo $this->galleries_m->galleryPhotosList($gallery->slug);?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<p><?php echo lang('gal_currently_no_photos_error');?></p>
<?php endif; ?>