<ul class="navigation">
	<?php foreach( navigation($group) as $link): ?>
		<li><?php echo anchor($link->url, $link->title, 'target="'.$link->target.'"'); ?></li>
	<?php endforeach; ?>
</ul>