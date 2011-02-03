<?php if(isset($buttons) && is_array($buttons)): ?>

	<?php foreach($buttons as $button ): ?>
		<?php if( $button == 'save' ): ?>
			<button type="submit" name="btnAction" value="save" class="button">
				<span>
					<?php echo lang('buttons.save');?>
				</span>
			</button>

		<?php elseif( $button == 'custom_button' ): ?>
			<button type="submit" name="btnAction" value="custom_button" class="button">
				<span>
					<?php echo lang('sample.custom_button');?>
				</span>
			</button>
			
		<?php endif; ?>
	<?php endforeach; ?>

<?php endif; ?>
