
	<h2>Packages</h2>
	
	<ul>
	<? if ($packages):
		foreach ($packages as $package): ?>
			<li><?=anchor('packages/view/' . $package->slug, $package->title);?><br />
			<?=word_limiter($package->description, 30);?></li>
		<? endforeach;
	else:?>
		<li>There are no packages.</li>
	<? endif; ?>
	</ul>
