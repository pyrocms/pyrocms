<h2><?=lang('pack_packages_title');?></h2>
<ul>
	<? if ($packages): ?>
		<? foreach ($packages as $package): ?>
			<li><?=anchor('packages/view/' . $package->slug, $package->title);?><br /><?=word_limiter($package->description, 30);?></li>
		<? endforeach; ?>
	<? else: ?>
		<li><?=lang('pack_no_packages_error');?></li>
	<? endif; ?>
</ul>