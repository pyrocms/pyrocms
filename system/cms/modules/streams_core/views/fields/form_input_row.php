
<!-- The $field_type object is also available in the view -->

<label for="<?php echo $form_slug;?>"><?php echo lang_label($field->field_name);?>

	<?php if($is_required): ?><span class="required">*</span><?php endif; ?>

	<?php if( ! empty($field->instructions)): ?>
		<br /><small><?php echo lang_label($field->field_name); ?></small>
	<?php endif; ?>

</label>

<div class="input"><?php echo $field->formInput(); ?></div>