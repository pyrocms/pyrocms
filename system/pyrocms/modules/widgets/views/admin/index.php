<!-- Add Area Box -->
<div id="add-area-box" class="hidden">

	<h3><?php echo lang('widgets.add_area'); ?></h3>

	<form class="crud">

		<ul>
			<li>
				<label for="title"><?php echo lang('widgets.widget_area_title'); ?></label>
				<?php echo form_input('title', NULL, 'class="new-area-title"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>

			<li class="even">
				<label for="slug"><?php echo lang('widgets.widget_area_slug'); ?></label>
				<?php echo form_input('slug', NULL, 'class="new-area-slug"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>

		</ul>

		<div class="float-right">
			<button type="submit">
				<span><?php echo lang('save_label'); ?></span>
			</button>

			<button id="widget-area-cancel">
				<span><?php echo lang('cancel_label'); ?></span>
			</button>
		</div>

	</form>

	<div style="clear: both"></div>
</div>
<!-- Edit Area Box -->
<div id="edit-area-box" class="hidden">

	<h3><?php echo lang('widgets.edit_area'); ?></h3>

	<form class="box-container crud">

		<ol>
			<li>
				<label for="title"><?php echo lang('widgets.widget_area_title'); ?></label>
				<?php echo form_input('title', NULL, 'class="new-area-title"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>

			<li class="even">
				<label for="slug"><?php echo lang('widgets.widget_area_slug'); ?></label>
				<?php echo form_input('slug', NULL, 'class="new-area-slug"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>

		</ol>

		<div class="float-right">
			<button type="submit">
				<span><?php echo lang('save_label'); ?></span>
			</button>

			<button id="widget-edit-area-cancel">
				<span><?php echo lang('cancel_label'); ?></span>
			</button>
		</div>

	</form>

	<div style="clear: both"></div>
</div>
<!-- Instance form -->
<ol class="hidden">
	<!-- Add Instance Box -->
	<li id="add-instance-box" class="box hidden widget-instance no-sortable">
		<form class="box-container crud"></form>
	</li>
	<!-- Edit Instance Box -->
	<li id="edit-instance-box" class="box hidden no-sortable">
		<form class="box-container crud"></form>
	</li>
</ol>

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
						<!-- Widget Area Title / Actions -->
						<header class="clearfix">
							<h3><a href="#"><?php echo $widget_area->title; ?></a></h3>
						</header>
						<div class="widget-area-content accordion-content">
							<div class="buttons buttons-small">
								<?php $this->load->view('admin/partials/buttons', array('buttons' => array('edit' => array('id' => 'area/' . $widget_area->slug), 'delete') )); ?>
							</div>

							<code class="tag"><?php echo sprintf('{%s:widgets:area slug="%s"}', config_item('tags_trigger'), $widget_area->slug); ?></code>

							<!-- Widget Area Instances List -->
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

<!-- Widget Areas -->
<?php /* <section id="widget-wrapper">
  <header></header>
  <div style="height:150px;"></div>
  </section> */ ?>