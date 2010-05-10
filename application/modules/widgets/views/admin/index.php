<div id="add-area-box" class="box hidden">

	<h3><?php echo lang('widgets.add_area'); ?></h3>

	<form class="box-container crud">
	
		<ol>
			<li>
				<label for="title"><?php echo lang('widgets.widget_area_title'); ?></label>
				<?php echo form_input('title'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			</li>
			
			<li class="even">
				<label for="slug"><?php echo lang('widgets.widget_area_slug'); ?></label>
				<?php echo form_input('slug'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			</li>
			
		</ol>
	
		<button type="submit">
			<span><?php echo lang('save_label'); ?></span>
		</button>
		
		<button id="widget-area-cancel">
			<span><?php echo lang('cancel_label'); ?></span>
		</button>
	
	</form>
</div>

<div id="add-instance-box" class="box hidden">

	<h3><?php echo lang('widgets.add_instance'); ?></h3>

	<form class="box-container crud">
	
	</form>
</div>

<div id="edit-instance-box" class="box hidden">

	<h3><?php echo lang('widgets.edit_instance'); ?></h3>

	<form class="box-container crud">
	
	</form>
</div>

<div class="widget-wrapper">

	<?php if (!empty($widget_areas)): ?>

		<?php foreach ($widget_areas as $widget_area): ?>

			<div id="area-<?php echo $widget_area->slug; ?>" class="box widget-area">
				<h3><?php echo $widget_area->title; ?></h3>

				<div class="box-container">

					<div class="header-squish">

						<span class="tag">
							<?php echo sprintf('{widget_area(\'%s\')}', $widget_area->slug);?>
						</span>

						<div class="button">
							<a id="delete-area-<?php echo $widget_area->slug; ?>" class="delete-area" href="#">
								<?php echo lang('widgets.delete_area'); ?>
							</a>
						</div>

					</div>

					<div class="widget-list">
						<?php $this->load->view('admin/ajax/instance_list', array('widgets' => $widget_area->widgets)); ?>
					</div>
				</div>
			</div>

		<?php endforeach; ?>

	<?php else: ?>
		<p><?php echo lang('nav_no_groups');?></p>
	<?php endif; ?>

</div>