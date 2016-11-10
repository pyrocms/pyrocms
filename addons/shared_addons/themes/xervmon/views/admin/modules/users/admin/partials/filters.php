<fieldset id="filters">
 
	<legend><?php echo lang('global:filters') ?></legend>
	
	<?php echo form_open('') ?>
	<?php echo form_hidden('f_module', $module_details['slug']) ?>
		  <div class="control-group">
                   
			  <div class="controls">
				<?php echo lang('user:active', 'f_active') ?>
				<?php echo form_dropdown('f_active', array(0 => lang('global:select-all'), 1 => lang('global:yes'), 2 => lang('global:no') ), array(0)) ?>
			</div>

			  <div class="controls">
				<?php echo lang('user:group_label', 'f_group') ?>
				<?php echo form_dropdown('f_group', array(0 => lang('global:select-all')) + $groups_select) ?>
			</div>
			
			  <div class="controls" style="margin-top: 31px; "><?php echo form_input('f_keywords','','style="width: 200px"') ?></div>
			  <div class="controls" style="margin-top: 32px;"><?php echo anchor(current_url(), lang('buttons:cancel'), 'class="cancel btn"') ?></div>
		 </div>
	<?php echo form_close() ?>
       
</fieldset>