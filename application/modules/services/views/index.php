<h2><?php echo lang('service_title');?></h2>
<?php if ($services): ?>		
	<?php foreach ($services as $service): ?>
		<p><?php echo anchor('services/view/' . $service->slug, $service->title);?><br /><?php echo word_limiter($service->description, 30);?></p>
	<?php endforeach; ?>
<?php else: ?>
	<p><?php echo lang('service_no_offered_services');?></p>
<?php endif; ?>