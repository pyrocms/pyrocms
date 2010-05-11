<div id="area-<?php echo $widget_area->slug; ?>" class="widget-area box hidden">
	<h3><?php echo $widget_area->title; ?></h3>	
	
	<div class="box-container">
				
		<div class="button float-right">
			<a id="delete-area-<?php echo $widget_area->slug; ?>" class="delete-area" href="#">
				<?php echo lang('widgets.delete_area'); ?>
			</a>
		</div>

		<div class="widget-list"></div>
	
	</div>
</div>