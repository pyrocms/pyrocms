<p>
	<small><?=anchor('', $breadcrumbBaseLabel) ?>
	
	<? foreach($breadcrumbs as $breadcrumb): ?>
		<? if(!$breadcrumb['current_page']): ?>
		:: <?=anchor($breadcrumb['url_ref'], $breadcrumb['name']); ?>
		<? else: ?>
		:: <?=$breadcrumb['name']; ?>
		<? endif; ?>
	<? endforeach; ?>
	</small>
</p>