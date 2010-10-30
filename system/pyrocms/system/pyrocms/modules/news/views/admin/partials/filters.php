<div id="filter">
<?php echo form_open('', 'class="filter"'); ?>
<?php echo form_hidden('f_module', $module_details['slug']); ?>
<ul>  
	<li>
            <?php echo lang('news_status_label', 'f_status'); ?>
            <?php echo form_dropdown('f_status', array(0 => '', 'draft'=>lang('news_draft_label'), 'live'=>lang('news_live_label'))); ?>
        </li>
	<li>
            <?php echo lang('news_category_label', 'f_category'); ?>
            <?php echo form_dropdown('f_category', $categories); ?>
        </li>
	<li><?php echo form_input('f_keywords'); ?></li>
	<?php echo form_button('f_clear', lang('buttons.cancel')); ?>
</ul>
<?php echo form_close(); ?>
<br class="clear-both">
</div>
