<h2><?php echo $album->title; ?></h2>
<p><?php echo $album->description; ?></p>

<a href="<?php echo image_path('photos/'.$album->id .'/' . $photo->filename); ?>" title="<?php echo $photo->caption; ?>" rel="modal">
	<?php echo image('photos/' . $album->id . '/' . $photo->filename, '', array('alt' => $photo->caption, 'class' => 'photo'));?>
</a>

<?php echo display_comments($photo->id); ?>