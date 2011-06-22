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
					<?php $this->load->view('admin/areas/index', compact('widget_areas')); ?>
				</div>
				<?php else: ?>
				<p><?php echo lang('nav_no_groups'); ?></p>
				<?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>