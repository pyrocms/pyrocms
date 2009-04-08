
	<h2>Photo Galleries</h2>
	
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
	<p>There are no photos at the moment. Please come back another time.</p>
<? endif; ?>