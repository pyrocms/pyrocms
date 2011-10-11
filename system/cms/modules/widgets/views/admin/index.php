<section class="title"></section>
<section class="item">
<!-- Available Widgets Area -->
<table>
	<tbody style="border-bottom: none">
		<tr>

			<!-- Available Widgets -->
			<td id="available-widgets" class="one_half">
				<header>
					<h4><?php echo lang('widgets.available_title') ?></h4>
					<p><?php echo lang('widgets.instructions') ?></p>
				</header>

				<?php if ($available_widgets): ?>
				<!-- Available Widget List -->
				<ul>
					<?php foreach ($available_widgets as $widget): ?>
					<li id="widget-<?php echo $widget->slug; ?>" class="widget-box">
						<p><?php echo $widget->title; ?></p>
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
			<td id="widget-areas" class="one_half last">
				<header>
					<h4><?php echo lang('widgets.widget_area_wrapper'); ?></h4>
				</header>

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