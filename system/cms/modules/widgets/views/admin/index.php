<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

<section class="item">

<p><?php echo lang('widgets.instructions') ?></p>

<table>
	<tbody style="border-bottom: none">
		<tr>

			<!-- Available Widgets -->
			<td id="available-widgets" class="one_half">
			
				<h5>Available Widgets</h5>

				<?php if ($available_widgets): ?>
				<ul>
					<?php foreach ($available_widgets as $widget): ?>
					<li id="widget-<?php echo $widget->slug; ?>" class="widget-box">
						<p><span><?php echo $widget->title; ?></span> <?php echo $widget->description; ?></p>
						<div class="widget_info" style="display: none;">
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
			<td id="widget-areas" class="one_half last">
			
				<h5><?php echo lang('widgets.widget_area_wrapper'); ?></h5>

				<?php if ($widget_areas): ?>
				<!-- Available Widget Areas -->
				<div id="widget-areas-list">
					<?php $this->load->view('admin/areas/index', compact('widget_areas')); ?>
				</div>
				<?php else: ?>
					<?php echo anchor('admin/widgets/areas/create', lang('widgets.add_area'), 'class="add create-area"'); ?>
				<?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>
</section>