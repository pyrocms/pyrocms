<fieldset id="filters">
	<legend><?php echo lang('global:filters') ?></legend>
	
	<?php echo form_open('') ?>
		<?php echo form_hidden('f_module', $module_details['slug']) ?>
		<ul>  
			<li class="one_quarter">
        		<?php echo lang('blog_status_label', 'f_status') ?>
        		<?php echo form_dropdown('f_status', array(0 => lang('global:select-all'), 'draft'=>lang('blog_draft_label'), 'live'=>lang('blog_live_label'))) ?>
    		</li>
			<li class="one_quarter">
        		<?php echo lang('blog_category_label', 'f_category') ?>
       			<?php echo form_dropdown('f_category', array(0 => lang('global:select-all')) + $categories) ?>
    		</li>
			<li class="one_quarter"><?php echo form_input('f_keywords') ?></li>
			<li style="font-size:13px;" class="one_quarter last"><?php echo anchor(current_url() . '#', lang('buttons.cancel'), 'class="alignright button red"') ?></li>
		</ul>
	<?php echo form_close() ?>
</fieldset>