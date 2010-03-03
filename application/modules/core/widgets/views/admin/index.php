<div id="add-area-box" class="box hidden">

	<h3><?php echo lang('widgets.add_area'); ?></h3>

	<form class="box-container crud">
	
		<ol>
			<li>
				<label for="title">Area name</label>
				<?php echo form_input('title'); ?>
			</li>
			
			<li class="even">
				<label for="slug">Area short name</label>
				<?php echo form_input('slug'); ?>
			</li>
			
		</ol>
	
		<?php echo form_submit('', 'Add'); ?>
	
	</form>
</div>

<div id="add-instance-box" class="box hidden">

	<h3><?php echo lang('widgets.add_instance'); ?></h3>

	<form class="box-container crud">
	
		<?php echo form_submit('', 'Add'); ?>
	
	</form>
</div>

<?php if (!empty($widget_areas)): ?>
	<?php foreach ($widget_areas as $widget_area): ?>
	
		<div id="area-<?php echo $widget_area->slug; ?>" class="box widget-area">
			<h3><?php echo $widget_area->title; ?></h3>	
			
			<div class="box-container">
				
				<div class="button float-right">
					<a id="delete-area-<?php echo $widget_area->slug; ?>" class="delete-area" href="#">
						<?php echo lang('widgets.delete_area'); ?>
					</a>
				</div>
				
			</div>
		</div>
		
	<?php endforeach; ?>
		
<?php else: ?>
	<p><?php echo lang('nav_no_groups');?></p>
<?php endif; ?>