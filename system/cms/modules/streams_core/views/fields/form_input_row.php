<label class="col-lg-2 control-label" for="<?php echo $fields->form_slug;?>">
	<?php echo lang_label($field->field_name);?>
	<?php if($field->is_required): ?><span class="required">*</span><?php endif; ?>

	<?php if( lang_label($field->instructions) != '' ): ?>
		<p class="help-block c-gray-light"><?php echo lang_label($field->instructions); ?></p>
	<?php endif; ?>
</label>

<div  class="col-lg-10">
	<?php echo $field->form_input(); ?>
</div>