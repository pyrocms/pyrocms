<section class="padded">
<div class="container-fluid">


	<div class="row-fluid">


		<div class="span6 box" id="available-widgets">

			<section class="box-header">
				<span class="title"><?php echo lang('widgets:available_title') ?></span>
			</section>

			<section class="padded">

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

			</section>

		</div>


		<div class="span6 box" id="widget-areas">
			
			<section class="box-header">
				<span class="title"><?php echo lang('widgets:widget_area_wrapper') ?></span>
			</section>

			<section class="padded">

				<?php if ($widget_areas): ?>
				<!-- Available Widget Areas -->
				<div id="widget-areas-list">
					<?php $this->load->view('admin/areas/index', compact('widget_areas')) ?>
				</div>
				<?php else: ?>
					<?php echo anchor('admin/widgets/areas/create', lang('widgets:add_area'), 'class="add create-area"') ?>
				<?php endif ?>

			</section>

		</div>


	</div>


</div>
</section>