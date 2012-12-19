<div class="one_half" id="available-widgets">
	<section class="title">
		<h4><?php echo lang('widgets:available_title') ?></h4>
	</section>
	<section class="item">
		<div class="content">
			<?php if ($available_widgets): ?>
			<ul>
				<?php foreach ($available_widgets as $widget): ?>
				<li id="widget-<?php echo $widget->slug ?>" class="widget-box">
					<p><span><?php echo $widget->title ?></span> <?php echo $widget->description ?></p>
					<div class="widget_info" style="display: none;">
						<p class="author"><?php echo lang('widgets:widget_author') . ': ' . ($widget->website ? anchor($widget->website, $widget->author, array('target' => '_blank')) : $widget->author) ?>
					</div>
				</li>
				<?php endforeach ?>
			</ul>
			<?php else: ?>
			<p><?php echo lang('widgets:no_available_widgets') ?></p>
			<?php endif ?>
		</div>
	</section>
</div>

<div class="one_half last" id="widget-areas">
	<section class="title">
		<h4><?php echo lang('widgets:widget_area_wrapper') ?></h4>
	</section>
	<section class="item">
		<div class="content">
			<?php if ($widget_areas): ?>
			<!-- Available Widget Areas -->
			<div id="widget-areas-list">
				<?php $this->load->view('admin/areas/index', compact('widget_areas')) ?>
			</div>
			<?php else: ?>
				<?php echo anchor('admin/widgets/areas/create', lang('widgets:add_area'), 'class="add create-area"') ?>
			<?php endif ?>
		</div>
	</section>
</div>