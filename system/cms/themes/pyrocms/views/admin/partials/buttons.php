<?php if (isset($buttons) && is_array($buttons)): ?>
	<?php foreach ($buttons as $key => $button): ?>
		<?php
		/**
		 * @var		$extra	array associative
		 * @since	1.2.0-beta2
		 */ ?>
		<?php $extra	= NULL; ?>
		<?php $button	= ! is_numeric($key) && ($extra = $button) ? $key : $button; ?>

		<?php switch ($button) :
			case 'delete': ?>
				<button type="submit" name="btnAction" value="delete" class="button confirm">
					<span><?php echo lang('buttons.delete'); ?></span>
				</button>
				<?php break;
			case 're-index': ?>
				<button type="submit" name="btnAction" value="re-index" class="button">
					<span><?php echo lang('buttons.re-index'); ?></span>
				</button>
				<?php break;
			case 'activate':
			case 'deactivate':
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
			case 'preview':
				echo anchor('admin/' . $this->module_details['slug'], lang('buttons.' . $button), 'class="button ' . $button . '"');
				break;

			/**
			 * @var		$id scalar - optionally can be received from an associative key from array $extra
			 * @since	1.2.0-beta2
			 */
			case 'edit':
				$id = is_array($extra) && array_key_exists('id', $extra) ? '/' . $button . '/' . $extra['id'] : NULL;

				echo anchor('admin/' . $this->module_details['slug'] . $id, lang('buttons.' . $button), 'class="button ' . $button . '"');
				break; ?>

		<?php endswitch; ?>
	<?php endforeach; ?>
<?php endif; ?>