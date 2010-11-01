<!-- Add Area Box -->
<div id="add-area-box" class="hidden">

	<h3><?php echo lang('widgets.add_area'); ?></h3>

	<form class="box-container crud">
	
		<ol>
			<li>
				<label for="title"><?php echo lang('widgets.widget_area_title'); ?></label>
				<?php echo form_input('title', null, 'class="new-area-title"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			</li>
			
			<li class="even">
				<label for="slug"><?php echo lang('widgets.widget_area_slug'); ?></label>
				<?php echo form_input('slug', null, 'class="new-area-slug"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			</li>
			
		</ol>
	
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
<div id="edit-area-box" class="hidden">

	<h3><?php echo lang('widgets.edit_area'); ?></h3>

	<form class="box-container crud">
	
		<ol>
			<li>
				<label for="title"><?php echo lang('widgets.widget_area_title'); ?></label>
				<?php echo form_input('title', null, 'class="new-area-title"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			</li>
			
			<li class="even">
				<label for="slug"><?php echo lang('widgets.widget_area_slug'); ?></label>
				<?php echo form_input('slug', null, 'class="new-area-slug"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
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

<!-- Add Instance Box -->
<li id="add-instance-box" class="box hidden widget-instance">
	<form class="box-container crud">
	
	</form>
</li>

<!-- Edit Instance Box -->
<li id="edit-instance-box" class="box hidden widget-instance">

	<h3><?php echo lang('widgets.edit_instance'); ?></h3>

	<form class="box-container crud">
	
	</form>
</li>

<!-- Available Widgets Area -->
<div style="width: 65%; float: left" id="available-widgets">
<?php if ($available_widgets): ?>
	<span class="widget-instructions float-right" style="margin-right: 20px"><?php echo lang('widgets.instructions')?></span>

	<h3><?php echo lang('widgets.available_title')?></h3>

		<?php foreach($available_widgets as $widget): ?>
		<section id="widget-<?php echo $widget->slug; ?>" class="box widget-box" style="<?php echo alternator('clear:both;', '', '', ''); ?>">
			<header>
				<h3 class="title"><?php echo $widget->title; ?></h3>
			</header>
			
			<div class="widget-box-body">
				<p class="description"><?php echo $widget->description; ?></p>
				<p class="author"><?php echo lang('widgets.widget_author').': '.($widget->website ? anchor($widget->website, $widget->author) : $widget->author); ?>
			</div>
		</section>
		<?php endforeach; ?>
</div>
<?php else: ?>
	<p>There are no available widgets.</p>
<?php endif; ?>


<!-- Widget Areas -->
<section id="widget-wrapper">
	<header>
		<h3><?php echo lang('widgets.widget_area_wrapper'); ?></h3>
	</header>

	<?php if (!empty($widget_areas)): ?>

		<div class="accordion">
		<?php foreach ($widget_areas as $widget_area): ?>

			<section id="area-<?php echo $widget_area->slug; ?>">
				<header class="widget-area-header">
					<h3><a href="#"><?php echo $widget_area->title; ?></a></h3>
					<a id="edit-area-<?php echo $widget_area->slug; ?>" class="accordion-header-link edit-area" href="#">
						<?php echo lang('widgets.edit_area'); ?>
					</a>
					<a id="delete-area-<?php echo $widget_area->slug; ?>" class="accordion-header-link delete-area" href="#">
						<?php echo lang('widgets.delete_area'); ?>
					</a>
				</header>
				
				<div class="accordion-content">
					<p class="tag"><?php echo sprintf('{pyro:widgets:area slug="%s"}', $widget_area->slug);?></p>
	
					<div class="widget-list">
						<?php $this->load->view('admin/ajax/instance_list', array('widgets' => $widget_area->widgets)); ?>
						
						<div style="clear:both"></div>
					</div>
				</div>
			</section>

		<?php endforeach; ?>
		</div>

	<?php else: ?>
		<p><?php echo lang('nav_no_groups');?></p>
	<?php endif; ?>

</section>

</div>