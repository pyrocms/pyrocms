	<li<?php if(isset($this->type->types->{$field['field_type']}->admin_display) and $this->type->types->{$field['field_type']}->admin_display == 'full'): ?> class="full_width_input"<?php endif; ?>>

		<label for="<?php echo $field['field_slug'];?>"><?php echo $field['field_name'];?> <?php if ($field['required']): ?><span>*</span><?php endif; ?>
		
		<?php if( $field['instructions'] != '' ): ?>
			<br /><small><?php echo $field['instructions']; ?></small>
		<?php endif; ?>
		</label>

		<div class="input"><?php echo $field['input']; ?></div>

	</li>