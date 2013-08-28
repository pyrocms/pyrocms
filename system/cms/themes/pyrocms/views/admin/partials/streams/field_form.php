<?php echo form_open(uri_string()); ?>

<input type="hidden" name="fields_current_namespace" id="fields_current_namespace" value="<?php echo $this->config->item('streams:core_namespace');?>" />
<input type="hidden" name="field_namespace" id="field_namespace" value="<?php echo $this->config->item('streams:core_namespace');?>" />

<div class="form_inputs">

	<ul>

		<li>
			<label for="field_name"><?php echo lang('streams:label.field_name');?> <span>*</span></label>
			<div class="input"><?php echo form_input('field_name', $field->field_name, 'maxlength="60" id="field_name" autocomplete="off"'); ?></div>
		</li>
		<li>
			<label for="field_slug"><?php echo lang('streams:label.field_slug');?> <span>*</span></label>
			<div class="input"><?php echo form_input('field_slug', $field->field_slug, 'maxlength="60" id="field_slug"'); ?></div>
		</li>

		<?php
		
			// We send some special params in an edit situation
			$ajax_url = 'streams/ajax/build_parameters';	
		
			if ($this->uri->segment(4) == 'edit')
			{
				$ajax_url .= '/edit/'.$current_field->id;
			}
		
		?>
		
		<li>
			<label for="field_type"><?php echo lang('streams:label.field_type'); ?> <span>*</span></label>
			<div class="input"><?php echo form_dropdown('field_type', $field_types, $field->field_type, 'data-placeholder="'.lang('streams:choose_a_field_type').'" id="field_type"'); ?></div>
		</li>
	
		<div id="parameters">
		
			<?php echo $parameters; ?>
		
		</div>
	
	</ul>
		
		<div class="float-right buttons">
		<button type="submit" name="btnAction" value="save" class="btn blue"><span><?php echo lang('buttons:save'); ?></span></button>	
		<a href="<?php echo site_url('admin/streams/fields'); ?>" class="btn gray cancel"><?php echo lang('buttons:cancel'); ?></a>
	</div>
	
<?php echo form_close();?>