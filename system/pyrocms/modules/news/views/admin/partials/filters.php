<div id="filter">
<?php echo form_open('', 'class="filter"'); ?>
<?php echo form_hidden('f_module', $module['slug']); ?>
<ul>
	<li><?php echo form_dropdown('f_status', array(0 => '', 'draft'=>lang('news_draft_label'), 'live'=>lang('news_live_label'))); ?></li>
	<li><?php echo form_dropdown('f_category', array(0 => 'fixme')); ?></li>
	<li><?php echo form_input('f_keywords'); ?></li>
	<li><?php echo form_button('f_clear', 'Clear'); ?></li>
</ul>
<?php echo form_close(); ?>
</div>