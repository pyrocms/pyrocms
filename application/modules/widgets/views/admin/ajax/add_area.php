<div id="area-<?php echo $widget_area->slug; ?>" class="widget-area box hidden">
	<h3><?php echo $widget_area->title; ?></h3>	
	
	<div class="box-container">

			<div class="header-squish">

				<span class="tag">
					<?php echo sprintf('{widget_area(\'%s\')}', $widget_area->slug);?>
				</span>
				
				<div class="button float-right">
					<a id="delete-area-<?php echo $widget_area->slug; ?>" class="delete-area" href="#">
						<?php echo lang('widgets.delete_area'); ?>
					</a>
				</div>

			</div>

		<div class="widget-list"></div>
	
	</div>
</div>
