<?php echo form_open(uri_string(), 'class="box-container crud"'); ?>
	<header class="ui-corner-top"><h3><?php echo $widget->title; ?></h3></header>

	<?php echo form_hidden('widget_id', $widget->id); ?>
	<?php echo isset($widget->instance_id) ? form_hidden('widget_instance_id', $widget->instance_id) : NULL; ?>
	<?php echo isset($error) && $error ? $error : NULL; ?>

	<fieldset id="widget-options">
		<ol>
			<li>
				<label><?php echo lang('widgets.instance_title'); ?>:</label>
				<?php echo form_input('title', set_value('title', isset($widget->instance_title) ? $widget->instance_title : '')); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>

			<?php if (isset($widget_areas)): ?>
			<li>
				<label><?php echo lang('widgets.widget_area'); ?>:</label>
				<?php echo form_dropdown('widget_area_id', $widget_areas, $widget->widget_area_id); ?>
			</li>
			<?php endif; ?>
		</ol>
		<?php echo $form ? $form : NULL; ?>
	</fieldset>

	<div id="instance-actions" class="align-right padding-bottom padding-right buttons buttons-small">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
	</div>
<?php echo form_close(); ?>