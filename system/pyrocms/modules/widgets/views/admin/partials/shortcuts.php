<nav id="shortcuts">
	<h6><?php echo lang('cp_shortcuts_title'); ?></h6>
	<ul>
		<li><?php echo anchor('#', lang('widgets.add_area'), 'id="add-area"') ?></li>
	</ul>
	<br class="clear-both" />
</nav>

<?php if($available_widgets): ?>
<div class="box">
	<h3 class="yellow"><?php echo lang('widgets.available_title')?></h3>
	
	<div class="box-container">
		<ul id="available-widgets" class="list-links">
			<?php foreach($available_widgets as $widget): ?>
			<li id="widget-<?php echo $widget->slug; ?>">
				<?php echo anchor('admin/widgets/about_available/' . $widget->slug, $widget->title, 'rel="modal"') ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
<?php endif; ?>