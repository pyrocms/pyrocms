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
					
		<h3><?=lang('gal_comments_title');?></h3>
		
		<fieldset class="alternative float-left width-half">
			<legend><?=lang('gal_other_comments_label');?></legend>
			<?= $this->load->module_view('comments', 'comments', array('comments' => $this->comments_m->getComments(array('module' => $this->module, 'module_id' => $gallery->id, 'is_active' => 1)))); ?>
		</fieldset>
										
		<fieldset class="float-right width-half">
			<legend><?=lang('gal_your_comments_label');?></legend>
			<?= $this->load->module_view('comments', 'form', array('module'=>$this->module, 'id' => $gallery->id)); ?> 
		</fieldset>
		
<? else: ?>
	<p><?=lang('gal_no_photos_in_gallery_error');?></p>
<? endif; ?>