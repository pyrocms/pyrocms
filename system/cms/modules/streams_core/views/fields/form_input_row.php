<label for="<?php echo $form_slug;?>"><?php echo $input_label;?>

	<?php if($is_required): ?><span class="required">*</span><?php endif; ?>

	<?php if( ! empty($instructions)): ?>
		<br /><small><?php echo $instructions; ?></small>
	<?php endif; ?>

</label>

<div class="input"><?php echo $form_input; ?></div>