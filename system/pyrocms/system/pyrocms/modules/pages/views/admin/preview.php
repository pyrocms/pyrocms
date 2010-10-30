<h1><?php echo $page->title; ?></h1>

<p><?php echo anchor($page->path, NULL, 'target="_blank"'); ?></p>

<iframe src="<?php echo site_url($page->path); ?>" width="99%" height="480"></iframe>