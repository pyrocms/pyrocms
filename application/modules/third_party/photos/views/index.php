<h2><?php echo lang('photos.title');?></h2>

<?php if (!empty($photo_albums)): ?>	
	<ul class="photos">
		<?php foreach ($photos as $gallery): ?>
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