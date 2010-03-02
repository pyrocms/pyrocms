<div class="box">
	<h3 class="yellow"><?php echo lang('widgets.available_title')?></h3>
	
	<div class="box-container">
		<ul class="list-links">
			<?php foreach($widgets as $widget): ?>
			<li><?php echo anchor('admin/widgets/about/' . $widget->slug, $widget->title, 'rel="modal"') ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>