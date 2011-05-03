<h1><?php echo $page->title; ?></h1>

<p><?php echo anchor($page->uri, NULL, 'target="_blank"'); ?></p>

<iframe src="<?php echo site_url($page->uri); ?>" width="99%" height="400"></iframe>