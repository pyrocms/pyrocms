<h2><?=lang('gal_photo_galleries_title');?></h2>
<? if ($galleries): ?>	
	<ul class="galleryHolder">
		<? foreach ($galleries as $gallery): ?>
			<li<?=$gallery->slug == 'home' ? 'class="box-hidden"' : '' ?>>
				<?=anchor('galleries/' . $gallery->slug, $gallery->title);?><br />
				<?=$gallery->description; ?><br />
				<?=$this->galleries_m->galleryPhotosList($gallery->slug);?>
			</li>
		<? endforeach; ?>
	</ul>
<? else: ?>
	<p><?=lang('gal_currently_no_photos_error');?></p>
<? endif; ?>