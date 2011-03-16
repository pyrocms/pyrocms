<div class="filter">
<?php echo form_open(); ?>
<?php echo form_hidden('f_module', $module_details['slug']); ?>
<ul>  
	<li>
            <?php echo lang('blog_status_label', 'f_status'); ?>
            <?php echo form_dropdown('f_status', array(0 => lang('select.all'), 'draft'=>lang('blog_draft_label'), 'live'=>lang('blog_live_label'))); ?>
        </li>
	<li>
            <?php echo lang('blog_category_label', 'f_category'); ?>
            <?php echo form_dropdown('f_category', array(0 => lang('select.all')) + $categories); ?>
        </li>
	<li><?php echo form_input('f_keywords'); ?></li>
	<li><?php echo anchor(current_url() . '#', lang('buttons.cancel'), 'class="cancel"'); ?></li>
</ul>
<?php echo form_close(); ?>
<br class="clear-both">
</div>