<nav id="shortcuts">
	<h6><?php echo lang('cp_shortcuts_title'); ?></h6>
	<ul>
		<li><?php echo anchor('#', lang('widgets.add_area'), 'id="add-area" class="add"') ?></li>
	</ul>
	<br class="clear-both" />
</nav>

<?php if($available_widgets): ?>
<div class="box">
	<h3 class="yellow"><?php echo lang('widgets.available_title')?></h3>
	<span class="widget-instructions"><?php echo lang('widgets.instructions')?></span>
	
	<div class="box-container">
		<ul id="available-widgets">
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>">
				<h6 class="title"><?php echo $widget->title; ?></h6>
				<span class="description"><?php echo $widget->description; ?></span><br />
				<span class="author"><?php echo lang('widgets.widget_author').': '.$widget->author; ?>
				<br /><?php echo anchor($widget->website); ?></span>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="clear-both"></div>
<?php endif; ?>