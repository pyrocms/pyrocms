<h2><?php echo lang('photos.title');?></h2>

<?php if (!empty($photo_albums)): ?>	
	<dl class="photos">
		<?php foreach ($photo_albums as $album): ?>
			<dt><?php echo anchor('photos/' . $album->slug, $album->title);?></dt>
			<dd><?php echo $album->description; ?></dd>
		<?php endforeach; ?>
	</dl>
<?php else: ?>
	<p><?php echo lang('gal_currently_no_photos_error');?></p>
<?php endif; ?>