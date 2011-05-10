<?php if (isset($buttons) && is_array($buttons)): ?>
	<?php foreach ($buttons as $button): ?>
		<?php switch ($button) :
			case 'delete': ?>
				<button type="submit" name="btnAction" value="delete" class="button confirm">
					<span><?php echo lang('buttons.delete'); ?></span>
				</button>
				<?php break;
			case 'activate':
			case 'approve':
			case 'publish':
			case 'save':
			case 'save_exit':
			case 'unapprove':
			case 'upload': ?>
				<button type="submit" name="btnAction" value="<?php echo $button ?>" class="button">
					<span><?php echo lang('buttons.' . $button); ?></span>
				</button>
				<?php break;
			case 'cancel':
			case 'close':
			case 'edit':
			case 'preview':
				echo anchor('admin/' . $this->module_details['slug'], lang('buttons.' . $button), 'class="button ' . $button . '"');
				break; ?>

		<?php endswitch; ?>
	<?php endforeach; ?>
<?php endif; ?>