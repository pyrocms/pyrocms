<? if(!empty($navigation['sidebar'])): ?>
	<h1>Menu</h1>
	<ul>
		<? foreach($navigation['sidebar'] as $nav_link): ?>
		<li><?=anchor($nav_link->url, $nav_link->title); ?></li>
		<? endforeach; ?>
	</ul>
<? endif; ?>