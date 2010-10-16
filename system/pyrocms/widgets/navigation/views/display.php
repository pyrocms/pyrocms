<ul class="navigation">
	<?php foreach( navigation($group) as $link): ?>
		<li<?php echo (current_url() == $link->url ? ' class="current"' : ''); ?>><?php echo anchor($link->url, $link->title, 'target="'.$link->target.'"'); ?></li>
	<?php endforeach; ?>
</ul>