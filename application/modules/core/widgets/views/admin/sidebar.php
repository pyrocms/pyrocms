<div class="box">
	<h3 class="yellow"><?php echo lang('cp_sidebar_title')?></h3>
	
	<div class="box-container">
		<ul class="list-links">
			<li><?php echo anchor('#', lang('widgets.add_area'), 'id="add-area"') ?></li>
		</ul>
	</div>
</div>

<div class="box">
	<h3 class="yellow"><?php echo lang('widgets.available_title')?></h3>
	
	<div class="box-container">
		<ul id="available-widgets" class="list-links">
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="mod2al"') ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<div class="box" id="droppable">
	<h3 class="yellow"><?php echo lang('widgets.uninstalled_title')?></h3>
	<div class="box-container">
		<ul id="uninstalled-widgets" class="list-links">
			<?php foreach($uninstalled_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>"><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="modal"') ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>