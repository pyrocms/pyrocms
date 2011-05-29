<div class="filter">
<?php echo form_open(uri_string()); ?>
<?php echo form_hidden('f_module', $module_details['slug']); ?>
<ul>
	<li>
		<?php echo lang('widgets.status_label', 'f_enabled'); ?>
		<?php echo form_dropdown('f_enabled', array(0 => lang('widgets.inactive_title'), 1 => lang('widgets.active_title')), (int) $widgets_active); ?>
    </li>
</ul>
<?php echo form_close(); ?>
<br class="clear-both">
</div>
