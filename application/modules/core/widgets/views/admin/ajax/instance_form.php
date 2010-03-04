<h4><?php echo $widget->title; ?> in <?php echo $widget_area->title; ?></h4>

<?php if(isset($widget->instance_id)): ?>
<?php echo form_hidden('widget_instance_id', $widget->instance_id); ?>
<?php endif; ?>

<?php echo form_hidden('widget_id', $widget->id); ?>
<?php echo form_hidden('widget_area_id', $widget_area->id); ?>
<?php echo form_hidden('widget_area_slug', $widget_area->slug); ?>

<?php if(!empty($error)): ?>
	<?php echo $error; ?>
<?php endif; ?>

<ol>
	<li>
		<label>Title:</label>
		<?php echo form_input('title'); ?>
	</li>
</ol>

<fieldset id="widget-options">
	<?php echo $this->widgets->render_backend($widget->slug, isset($widget->options) ? $widget->options : array()); ?>
</fieldset>

<button type="submit">
	<span><?php echo lang('save_label'); ?></span>
</button>

<button id="widget-instance-cancel">
	<span><?php echo lang('cancel_label'); ?></span>
</button>