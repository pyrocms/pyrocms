<h4><?php echo $widget->title; ?> in <?php echo $widget_area->title; ?></h4>

<?php echo form_hidden('widget_id', $widget->id); ?>
<?php echo form_hidden('widget_area_id', $widget_area->id); ?>

<ol>
	<li>
		<label>Title:</label>
		<?php echo form_input('title'); ?>
	</li>
</ol>

<fieldset id="widget-options">
	<?php echo $this->widgets->render_backend($widget->slug); ?>
</fieldset>

<button type="submit">
	<span><?php echo lang('widgets.save_button'); ?></span>
</button>