<label class="col-lg-2 control-label" for="<?php echo $field_type->form_slug;?>">
	<?php echo lang_label($field_type->getField()->field_name);?>
	<?php if($field_type->getField()->is_required): ?><span class="required">*</span><?php endif; ?>

	<?php if( lang_label($field_type->getField()->instructions) != '' ): ?>
		<p class="help-block c-gray-light"><?php echo lang_label($field_type->getField()->instructions); ?></p>
	<?php endif; ?>
</label>

<div  class="col-lg-10">
	<?php echo $field_type->formInput(); ?>
</div>