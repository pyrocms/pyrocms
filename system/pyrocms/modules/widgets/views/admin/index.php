<!-- Available Widgets Area -->
<table>
	<tbody style="border-bottom: none">
		<tr>

			<!-- Available Widgets -->
			<td id="available-widgets">
				<header>
					<h2><?php echo lang('widgets.available_title') ?></h2>
					<p><?php echo lang('widgets.instructions') ?></p>
				</header>

				<?php if ($available_widgets): ?>
				<!-- Available Widget List -->
				<ul>
					<?php foreach ($available_widgets as $widget): ?>
					<li id="widget-<?php echo $widget->slug; ?>" class="widget-box">
						<h3><?php echo $widget->title; ?></h3>
						<div class="widget-box-body">
							<p class="description"><?php echo $widget->description; ?></p>
							<p class="author"><?php echo lang('widgets.widget_author') . ': ' . ($widget->website ? anchor($widget->website, $widget->author, array('target' => '_blank')) : $widget->author); ?>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php else: ?>
				<p><?php echo lang('widgets.no_available_widgets'); ?></p>
				<?php endif; ?>

			</td>


			<!-- Widget Areas -->
			<td id="widget-areas">
				<header>
					<h2><?php echo lang('widgets.widget_area_wrapper'); ?></h2>
				</header>

				<?php if ($widget_areas): ?>
				<!-- Available Widget Areas -->
				<div id="widget-areas-list">
					<?php foreach ($widget_areas as $widget_area): ?>
					<section class="widget-area-box" id="area-<?php echo $widget_area->slug; ?>" data-id="<?php echo $widget_area->id; ?>" data-title="<?php echo $widget_area->title; ?>">
						<header class="clearfix">
							<h3><a href="#"><?php echo $widget_area->title; ?></a></h3>
						</header>
						<div class="widget-area-content accordion-content">
							<!-- Widget Area Actions -->
							<div class="buttons buttons-small">
								<?php $this->load->view('admin/partials/buttons', array('buttons' => array('edit' => array('id' => 'area/' . $widget_area->slug), 'delete') )); ?>
							</div>

							<!-- Widget Area Tag -->
							<code class="tag"><?php echo sprintf('{%s:widgets:area slug="%s"}', config_item('tags_trigger'), $widget_area->slug); ?></code>

							<!-- Widget Area Instances -->
							<div class="widget-list">
								<?php $this->load->view('admin/ajax/instance_list', array('widgets' => $widget_area->widgets)); ?>
								<div style="clear:both"></div>
							</div>
						</div>
					</section>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
				<p><?php echo lang('nav_no_groups'); ?></p>
				<?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>