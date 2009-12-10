<h2><?php echo $gallery->title; ?></h2>
<p><?php echo $gallery->description; ?></p>
<hr />
	
<?php if(!empty($children)): ?>
	<?php foreach ($children as $child): ?>				
		<li<?php echo $child->slug == 'home' ? 'class="box-hidden"' : '' ?>>
			<?php echo anchor('galleries/' . $child->slug, $child->title);?><br />
			<?php echo $child->description; ?><br />
			<?php echo $this->galleries_m->galleryPhotosList($child->slug);?>
		</li>			
	<?php endforeach; ?>
	<hr />
<?php endif; ?>

<?php // Show photos in this gallery ?>
<?php if(!empty($photos)): ?>

		<ul id="photos">
			<?php foreach ($photos as $photo):?>
				<li><a href="<?php echo image_path('galleries/'.$gallery->slug .'/' . $photo->filename); ?>" title="<?php echo $photo->description;?>" rel="modal"><?php echo image('galleries/' . $gallery->slug . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description));?></a></li>
			<?php endforeach; ?>
		</ul>
					
		<h3><?php echo lang('gal_comments_title');?></h3>
		
		<fieldset class="alternative float-left width-half">
			<legend><?php echo lang('gal_other_comments_label');?></legend>
			<?php echo $this->load->view('comments/comments', array('comments' => $this->comments_m->get_comments(array('module' => $this->module, 'module_id' => $gallery->id, 'is_active' => 1)))); ?>
		</fieldset>
										
		<fieldset class="float-right width-half">
			<legend><?php echo lang('gal_your_comments_label');?></legend>
			<?php echo $this->load->view('comments/form', array('module'=>$this->module, 'id' => $gallery->id)); ?> 
		</fieldset>
		
<?php else: ?>
	<p><?php echo lang('gal_no_photos_in_gallery_error');?></p>
<?php endif; ?>