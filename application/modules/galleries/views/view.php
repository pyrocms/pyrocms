	
	<h2><?= $gallery->title; ?></h2>
	<p><?= $gallery->description; ?></p>

	<hr />
	
	<? if(!empty($children)): ?>
	
		<? foreach ($children as $child): ?>
				
			<li<?=$child->slug == 'home' ? 'class="box-hidden"' : '' ?>>
				<?=anchor('galleries/' . $child->slug, $child->title);?><br />
				<?=$child->description; ?><br />
				<?=$this->galleries_m->galleryPhotosList($child->slug);?>
			</li>
			
		<? endforeach; ?>
		
		<hr />
		
	<? endif; ?>

	<? // Show photos in this gallery ?>
	<? if(!empty($photos)): ?>
		<ul id="photos">
		<? foreach ($photos as $photo):?>
			<li><a href="<?= image_path('galleries/'.$gallery->slug .'/' . $photo->filename); ?>" title="<?=$photo->description;?>" rel="modal"><?=image('galleries/' . $gallery->slug . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description));?></a></li>
		<? endforeach; ?>
		</ul>
		
	<? else: ?>
	<p>There are no photos in this gallery.</p>
	<? endif; ?>
