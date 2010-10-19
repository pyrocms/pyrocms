<h2>Title: <?php echo $doc->title; ?></h2>

<span id="filepath">
	<strong>Documents</strong>

	<?php foreach($folders as $folder): ?>
		&raquo; <?php echo $folder->title; ?>
	<?php endforeach; ?>
</span>

<p><?php echo anchor('libraries/download/document/' . $doc->id, 'Download'); ?>