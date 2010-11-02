<ol>
<?php foreach($widgets as $widget): ?>

	<li id="instance-<?php echo $widget->id; ?>" class="widget-instance">
		
		<h4><?php echo $widget->instance_title;?></h4>
		
		<div class="widget-type"><?php echo $widget->title;?></div>
		
		<div class="widget-actions">
			<a href="#" class="edit-instance"><?php echo lang('widgets.instance_edit'); ?></a> | 
			<a href="#" class="delete-instance"><?php echo lang('widgets.instance_delete'); ?></a>
		</div>
		
		<div class="widget-code"><?php echo sprintf('{pyro:widgets:instance id="%s"}', $widget->id);?></div>
		
		<div style="clear:both"></div>
	</li>
	
<?php endforeach; ?>
	<li class="empty-drop-item"></li>
</ol>