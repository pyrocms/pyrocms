
	<h2>Navigation</h2>
	<ul class="spacer-left-dbl">
		<? if(!empty($navigation['sidebar'])) foreach($navigation['sidebar'] as $nav_link): ?>
		<li><?=anchor($nav_link->url, $nav_link->title); ?></li>
		<? endforeach; ?>
	</ul>
	