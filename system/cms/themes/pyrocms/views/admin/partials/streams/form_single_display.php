<li class="row-fluid input-row">

	<?php if(isset($this->type->types->{$field['field_type']}->admin_display) and $this->type->types->{$field['field_type']}->admin_display == 'full'): ?>

		<label for="<?php echo $field['field_slug'];?>"><?php echo $field['field_name'];?> <?php if ($field['required']): ?><span>*</span><?php endif; ?>
		<?php if( $field['instructions'] != '' ): ?>
			<small><?php echo $field['instructions']; ?></small>
		<?php endif; ?>
		
		<div class="input">
			<?php echo $field['input']; ?>
		</div>

	<?php else: ?>

		<label class="span3" for="<?php echo $field['field_slug'];?>"><?php echo $field['field_name'];?> <?php if ($field['required']): ?><span>*</span><?php endif; ?>
		<?php if( $field['instructions'] != '' ): ?>
			<small><?php echo $field['instructions']; ?></small>
		<?php endif; ?>
		</label>

		<div class="input span9">
			<?php echo $field['input']; ?>
		</div>

	<?php endif; ?>

</li>