<div id="mainMenu">
	  <ul class="float-left">
		<?php foreach(navigation('header') as $nav_link): ?>
		<li><?php echo anchor($nav_link->url, $nav_link->title, $nav_link->current_link ? 'class="here"' : ''); ?></li>
		<?php endforeach; ?>
	  </ul>
</div>