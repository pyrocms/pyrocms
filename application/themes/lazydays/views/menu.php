
	<h1>Menu</h1>
	<ul>
		<? if(!empty($navigation['sidebar'])) foreach($navigation['sidebar'] as $nav_link): ?>
		<li><?=anchor($nav_link->url, $nav_link->title); ?></li>
		<? endforeach; ?>
	</ul>
	