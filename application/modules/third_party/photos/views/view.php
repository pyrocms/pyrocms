<h2><?php echo $album->title; ?></h2>
<p><?php echo $album->description; ?></p>

<?php if(!empty($album->children)): ?>

	<ul class="album-children">
	<?php foreach ($album->children as $child): ?>				
		<li>
			<?php echo anchor('photos/' . $child->slug, $child->title);?><br />
			<?php echo $child->description; ?>
		</li>			
	<?php endforeach; ?>
	</ul>

<?php endif; ?>

<?php if(!empty($photos)): ?>

	<ul id="photos" class="list-unstyled">
		<?php foreach ($photos as $photo):?>
			<li>
				<a href="<?php echo image_path('photos/'.$album->id .'/' . $photo->filename); ?>" title="<?php echo $photo->description;?>" rel="modal">
					<?php echo image('photos/' . $album->id . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('alt' => $photo->description));?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
	
	<br class="clear-both" />

	<?php echo $this->load->view('comments/comments', array('module' => $this->module, 'module_id' => $photo->id)); ?>
		
<?php else: ?>
	<p><?php echo lang('photo_albums.no_photos_in_album_error');?></p>
<?php endif; ?>