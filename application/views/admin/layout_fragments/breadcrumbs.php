<p><?=anchor('admin', lang('cp_breadcrumb_home_title')) ?>	
	<? foreach($breadcrumbs as $breadcrumb): ?>
		<? if(!$breadcrumb['current_page']): ?>
		:: <?=anchor($breadcrumb['url_ref'], $breadcrumb['name']); ?>
		<? else: ?>
		:: <?=$breadcrumb['name']; ?>
		<? endif; ?>
	<? endforeach; ?>	
	<? //<a class="fcc-current" href="">This Page</a> ?>
</p>