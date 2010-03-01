<h1><?php echo lang('navigation_headline');?></h1>
<ul>
	<?php foreach(navigation('sidebar') as $nav_link): ?>
	<li><?php echo anchor($nav_link->url, $nav_link->title,array('target' => $nav_link->target)); ?></li>
	<?php endforeach; ?>
</ul>