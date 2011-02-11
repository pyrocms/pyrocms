<div id="filter">
<?php echo form_open('', 'class="filter"'); ?>
<?php echo form_hidden('f_module', $module_details['slug']); ?>
<ul>  
	<li>
		<?php echo lang('comments.status_label', 'f_active'); ?>
		<?php echo form_dropdown('f_active', array(0 =>lang('comments.inactive_title'), 1 => lang('comments.active_title'))); ?>
    </li>
	<li>
            <?php echo lang('comments.module_label', 'module_slug'); ?>
            <?php echo form_dropdown('module_slug', array(0 => lang('select.all')) + $module_list); ?>
        </li>
	
	<li><?php echo anchor(current_url() . '#', lang('buttons.cancel'), 'class="cancel"'); ?></li>
</ul>
<?php echo form_close(); ?>
<br class="clear-both">
</div>
