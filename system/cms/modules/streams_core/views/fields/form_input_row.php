<label class="col-lg-2 control-label" for="<?php echo $fields[$field]['input_slug'];?>">
	<?php echo lang_label($input_label);?>
	<?php if($is_required): ?><span class="required">*</span><?php endif; ?>

	<?php if( $instructions != '' ): ?>
		<p class="help-block c-gray-light"><?php echo lang_label($instructions); ?></p>
	<?php endif; ?>
</label>

<div  class="col-lg-10">
	<?php echo $form_input; ?>
</div>