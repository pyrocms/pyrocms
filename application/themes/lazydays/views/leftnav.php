<? if(!empty($navigation['sidebar'])): ?>
	<h1><?= lang('navigation_headline');?></h1>
	<ul>
		<? foreach($navigation['sidebar'] as $nav_link): ?>
		<li><?=anchor($nav_link->url, $nav_link->title,array('target' => $nav_link->target)); ?></li>
		<? endforeach; ?>
	</ul>
<? endif; ?>