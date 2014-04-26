<fieldset id="filters">
	<legend><?php echo lang('global:filters') ?></legend>

	<?php echo form_open('', '', array('f_module' => $module_details['slug'])) ?>
		<ul>
			<li class="">
        		<label for="f_status"><?php echo lang('blog:status_label') ?></label>
        		<?php echo form_dropdown('f_status', array(0 => lang('global:select-all'), 'draft'=>lang('blog:draft_label'), 'live'=>lang('blog:live_label'))) ?>
    		</li>

			<li class="">
        		<label for="f_category"><?php echo lang('blog:category_label') ?></label>
       			<?php echo form_dropdown('f_category', array(0 => lang('global:select-all')) + $categories) ?>
    		</li>

			<li class="">
				<label for="f_category"><?php echo lang('global:keywords') ?></label>
				<?php echo form_input('f_keywords', '', 'style="width: 55%;"') ?>
			</li>

			<li class="">
				<?php echo anchor(current_url() . '#', lang('buttons:cancel'), 'class="button red"') ?>
			</li>
		</ul>
	<?php echo form_close() ?>
</fieldset>
