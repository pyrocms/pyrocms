	
	<h2>Services</h2>
	
	<? if ($services): ?>
		
	<? foreach ($services as $service): ?>
			<p><?=anchor('services/view/' . $service->slug, $service->title);?><br /><?=word_limiter($service->description, 30);?></p>
		<? endforeach; ?>

	<? else: ?>
		<p>We are currently not offering any services.</p>
	<? endif; ?>