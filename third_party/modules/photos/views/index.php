<h2><?php echo lang('photos.title');?></h2>

<?php if (!empty($photo_albums)): ?>	

		<?php foreach ($photo_albums as $album): ?>
		<div class="album_previews">
			<dt class="album_previews_title"><?php echo anchor('photos/' . $album->slug, $album->title);?></dt>
			<?php if($album->preview > ''){ echo anchor('photos/'.$album->slug, image('photos/' . $album->id . '/' . substr($album->preview, 0, -4) . '_thumb' . substr($album->preview, -4), '', array('alt' => $album->title.' preview')));};?>
			<dd class="album_previews_description"><?php echo $album->description; ?></dd>
		</div>
		<?php endforeach; ?>

<?php else: ?>
	<p><?php echo lang('gal_currently_no_photos_error');?></p>
<?php endif; ?>
