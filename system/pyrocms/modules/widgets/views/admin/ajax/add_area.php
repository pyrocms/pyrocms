<section id="area-<?php echo $widget_area->slug; ?>">
	<header class="clearfix widget-area-header">
		<h3><a href="#"><?php echo $widget_area->title; ?></a></h3>
		<div class="float-right padding-top-half padding-right-half padding-bottom-half buttons buttons-small">
			<a id="edit-area-<?php echo $widget_area->slug; ?>" class="button edit edit-area" data-title="<?php echo $widget_area->title; ?>" href="#">
				<?php echo lang('widgets.edit_area'); ?>
			</a>
			<a id="delete-area-<?php echo $widget_area->slug; ?>" class="confirm button delete delete-area" href="#">
				<?php echo lang('widgets.delete_area'); ?>
			</a>
		</div>
	</header>
	<div class="widget-area-content accordion-content">
		<p class="tag"><?php echo sprintf('{%s:widgets:area slug="%s"}', config_item('tags_trigger'), $widget_area->slug);?></p>

		<div class="widget-list">
			<ol>
				<li class="empty-drop-item"></li>
			</ol>
		
			<div style="clear:both"></div>
		</div>
	</div>
</section>