<section id="area-<?php echo $widget_area->slug; ?>">
	<header class="widget-area-header">
		<h3><a href="#"><?php echo $widget_area->title; ?></a></h3>
		
		<a id="delete-area-<?php echo $widget_area->slug; ?>" class="accordion-header-link delete-area" href="#">
			<?php echo lang('widgets.delete_area'); ?>
		</a>
	</header>
	
	<div class="accordion-content hidden">
		<p class="tag"><?php echo sprintf('{widget_area(\'%s\')}', $widget_area->slug);?></p>

		<div class="widget-list">
			<ol>
				<li class="empty-drop-item"></li>
			</ol>
		
			<div style="clear:both"></div>
		</div>
	</div>
</section>