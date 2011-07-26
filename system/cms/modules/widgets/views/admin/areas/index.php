<?php if ($widget_areas): ?>
<?php foreach ($widget_areas as $widget_area): ?>
	<section class="widget-area-box" id="area-<?php echo $widget_area->slug; ?>" data-id="<?php echo $widget_area->id; ?>">
		<header class="clearfix">
			<h3><a href="#"><?php echo $widget_area->title; ?></a></h3>
		</header>
		<div class="widget-area-content accordion-content">
			<!-- Widget Area Actions -->
			<div class="buttons buttons-small">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('edit' => array('id' => '../areas/edit/' . $widget_area->slug), 'delete') )); ?>
			</div>

			<!-- Widget Area Tag -->
			<code class="tag"><?php echo sprintf('{%s:widgets:area slug="%s"}', config_item('tags_trigger'), $widget_area->slug); ?></code>

			<!-- Widget Area Instances -->
			<div class="widget-list">
				<?php $this->load->view('admin/instances/index', array('widgets' => $widget_area->widgets)); ?>
				<div style="clear:both"></div>
			</div>
		</div>
	</section>
<?php endforeach; ?>
<?php endif; ?>