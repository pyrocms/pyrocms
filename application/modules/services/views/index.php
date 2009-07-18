<h2><?=lang('service_title');?></h2>
<? if ($services): ?>		
	<? foreach ($services as $service): ?>
		<p><?=anchor('services/view/' . $service->slug, $service->title);?><br /><?=word_limiter($service->description, 30);?></p>
	<? endforeach; ?>
<? else: ?>
	<p><?=lang('service_no_offered_services');?></p>
<? endif; ?>