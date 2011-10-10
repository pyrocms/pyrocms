<ol>
<?php if ($widgets): ?>
	<?php foreach($widgets as $widget): ?>
	<li id="instance-<?php echo $widget->id; ?>" class="widget-instance">
		
		<h4><?php echo $widget->instance_title; ?></h4>
		
		<div class="widget-type"><?php echo $widget->title; ?></div>
		
		<code class="widget-code"><?php echo sprintf('{%s:widgets:instance id="%s"}', config_item('tags_trigger'), $widget->id);?></code>
		
		<div class="widget-actions buttons buttons-small">
			<?php $this->load->view('admin/partials/buttons', array('button_type'=>'secondary', 'buttons' => array('edit' => array('id' => '../instances/edit/' . $widget->id), 'delete')) ); ?>
		</div>
		
		<div style="clear:both"></div>
	</li>
	<?php endforeach; ?>
<?php endif; ?>
	<li class="empty-drop-item no-sortable"></li>
</ol>