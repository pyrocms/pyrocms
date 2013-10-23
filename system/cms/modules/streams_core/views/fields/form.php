<?php echo form_open(uri_string()); ?>

<!-- .panel-body -->
<div class="panel-body">

	<div class="form-group">
	<div class="row">
		
		<label class="col-lg-2" for="field_name"><?php echo lang('streams:label.field_name');?> <span>*</span></label>
		
		<div class="col-lg-10">
			<?php

			if ($current_field->isFieldNameLang()) {
				echo '<p><em>'.$current_field->field_name.'</em></p>';
				echo form_hidden('field_name', $current_field->field_name);
			} else {
				echo form_input('field_name', $current_field->field_name, 'maxlength="60" id="field_name" class="form-control" autocomplete="off"');
			}

			?>
		</div>

	</div>
	</div>

	
	<div class="form-group">
	<div class="row">
		
		<label class="col-lg-2" for="field_slug"><?php echo lang('streams:label.field_slug');?> <span>*</span>

			<small class="help-block"><?php echo lang('global:slug_instructions'); ?></small>
		</label>

		<div class="col-lg-10">
			<?php echo form_input('field_slug', $current_field->field_slug, 'maxlength="60" class="form-control" id="field_slug"'); ?>
		</div>

	</div>
	</div>
		

	<?php if (isset($stream)): ?>
	
		<div class="form-group">
		<div class="row">
			
			<label class="col-lg-10 col-lg-offset-2" for="is_required">
				<?php echo form_checkbox('is_required', 'yes', isset($assignment) ? $assignment->is_required : false, 'id="is_required"');?>
				&nbsp;
				<?php echo lang('streams:label.field_required');?>
			</label>

		</div>
		</div>
	

		<div class="form-group">
		<div class="row">

			<label class="col-lg-10 col-lg-offset-2" for="is_required">
				<?php echo form_checkbox('is_unique', 'yes', isset($assignment) ? $assignment->is_unique : false, 'id="is_unique"'); ?>
				&nbsp;
				<?php echo lang('streams:label.field_unique');?>
			</label>			

		</div>
		</div>
	

		<div class="form-group">
		<div class="row">
			
			<label class="col-lg-2" for="field_instructions"><?php echo lang('streams:label.field_instructions');?>

				<small class="help-block"><?php echo lang('streams:instr.field_instructions');?></small>
			</label>

			<div class="col-lg-10">
				<?php echo form_textarea('instructions', isset($assignment) ? $assignment->instructions : null, 'class="form-control" id="field_instructions"');?>
			</div>

		</div>
		</div>
	

		<?php if ($allow_title_column_set): ?>
		<div class="form-group">
		<div class="row">
			
			<label class="col-lg-2" for="title_column"><?php echo lang('streams:label.make_field_title_column');?></label>

			<div class="col-lg-10">
				<?php echo form_checkbox('title_column', 'yes', $title_column_status, 'id="title_column"');?>
			</div>

		</div>
		</div>
		<?php endif; ?>

	<?php endif; ?>

	<?php

		// We send some special params in an edit situation
		$ajax_url = 'streams/ajax/build_parameters';

		if($this->uri->segment(4) == 'edit'):

			$ajax_url .= '/edit/'.$current_field->id;

		endif;

	?>

	<div class="form-group">
	<div class="row">
		
		<label class="col-lg-2" for="field_type"><?php echo lang('streams:label.field_type'); ?> <span>*</span></label>

		<div class="col-lg-10">
			<?php echo form_dropdown('field_type', $field_types, $current_field->field_type, 'data-placeholder="'.lang('streams:choose_a_field_type').'" id="field_type"'); ?>
		</div>

	</div>
	</div>
		


	<div id="parameters">
	
		<?php echo $parameters; ?>
	
	</div>

	
</div>
<!-- /.panel-body -->


<div class="panel-footer">

	<button type="submit" name="btnAction" value="save" class="btn btn-success"><span><?php echo lang('buttons:save'); ?></span></button>	
	<?php if ($cancel_uri): ?>
	<a href="<?php echo site_url($cancel_uri); ?>" class="btn btn-default"><?php echo lang('buttons:cancel'); ?></a>
	<?php endif; ?>

</div>


<?php echo form_close();