<header>
	<h3><?php echo $widget->title; ?></h3>
</header>

<?php if(isset($widget->instance_id)): ?>
	<?php echo form_hidden('widget_instance_id', $widget->instance_id); ?>
<?php endif; ?>

<?php echo form_hidden('widget_id', $widget->id); ?>

<?php if(!isset($widget_areas)): ?>
		<?php echo form_hidden('widget_area_id', $widget_area->id); ?>
<?php endif; ?>

<?php if(!empty($error)): ?>
	<?php echo $error; ?>
<?php endif; ?>

<ol>
	<li>
		<label><?php echo lang('widgets.instance_title'); ?>:</label>
		<?php echo form_input('title', set_value('title', isset($widget->instance_title) ? $widget->instance_title : '')); ?>
		<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
	</li>
	
	<?php if(isset($widget_areas)): ?>
	<li>	
		<label><?php echo lang('widgets.widget_area'); ?>:</label>	
		<?php echo form_dropdown('widget_area_id', $widget_areas, $widget_area->id); ?>
	</li>
	<?php endif; ?>
</ol>

<?php
$form = $this->widgets->render_backend($widget->slug, isset($widget->options) ? $widget->options : array());
if($form):
?>
	<fieldset id="widget-options">
		<?php echo $form; ?>
	</fieldset>
<?php endif; ?>

<div class="float-right" style="padding: 5px">
	<button type="submit">
		<span><?php echo lang('save_label'); ?></span>
	</button>
	
	<button id="widget-instance-cancel">
		<span><?php echo lang('cancel_label'); ?></span>
	</button>
</div>