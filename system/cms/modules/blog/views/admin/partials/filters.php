<fieldset id="filters">
	<legend><?php echo lang('global:filters') ?></legend>

	<?php echo form_open('', '', array('f_module' => $module_details['slug'])) ?>
		<ul>
			<li class="one_quarter">
        		<label for="f_status"><?php echo lang('blog:status_label') ?></label>
        		<?php echo form_dropdown('f_status', array(0 => lang('global:select-all'), 'draft'=>lang('blog_draft_label'), 'live'=>lang('blog_live_label'))) ?>
    		</li>

			<li class="one_quarter">
        		<label for="f_category"><?php echo lang('blog:category_label') ?></label>
       			<?php echo form_dropdown('f_category', array(0 => lang('global:select-all')) + $categories) ?>
    		</li>

			<li class="one_quarter">
				<label for="f_category"><?php echo lang('global:keywords') ?></label>
				<?php echo form_input('f_keywords', '', 'style="width: 55%;"') ?>
			</li>

			<li class="one_quarter last">
				<?php echo anchor(current_url() . '#', lang('buttons.cancel'), 'class="alignright button red"') ?>
			</li>
		</ul>
	<?php echo form_close() ?>
</fieldset>