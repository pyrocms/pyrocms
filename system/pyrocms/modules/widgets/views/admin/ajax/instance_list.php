<ol>
<?php foreach($widgets as $widget): ?>

	<li id="instance-<?php echo $widget->id; ?>" class="widget-instance">
		
		<h4><?php echo $widget->instance_title; ?></h4>
		
		<div class="widget-type"><?php echo $widget->title; ?></div>
		
		<pre class="widget-code no-sortable"><code><?php echo sprintf('{%s:widgets:instance id="%s"}', config_item('tags_trigger'), $widget->id);?></code></pre>
		
		<div class="widget-actions buttons buttons-small">
			<a href="#" class="edit-instance button edit"><?php echo lang('widgets.instance_edit'); ?></a>
			<a href="#" class="delete-instance confirm button delete"><?php echo lang('widgets.instance_delete'); ?></a>
		</div>
		
		<div style="clear:both"></div>
	</li>
	
<?php endforeach; ?>
	<li class="empty-drop-item"></li>
</ol>