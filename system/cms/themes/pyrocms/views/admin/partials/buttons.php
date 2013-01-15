<?php if (isset($buttons) && is_array($buttons)): ?>

	<?php 
	
		// What type of buttons?
		if(isset($button_type) && $button_type == 'primary'):
			$btn_class = 'btn';
		elseif(isset($button_type) && $button_type == 'secondary'):
			$btn_class = 'button';
		else:
			// Default to primary
			$btn_class = 'btn';
		endif;
	
	?>

	<?php foreach ($buttons as $key => $button): ?>
		<?php
		/**
		 * @var		$extra	array associative
		 * @since	1.2.0-beta2
		 */ ?>
		<?php $extra	= NULL; ?>
		<?php $button	= ! is_numeric($key) && ($extra = $button) ? $key : $button; ?>

		<?php switch ($button) :
			case 'delete': 
				if($btn_class == 'btn') $btn_class .= ' red';
			
			?>
				<button type="submit" name="btnAction" value="delete" class="<?php echo $btn_class; ?> confirm">
					<span><?php echo lang('buttons:delete'); ?></span>
				</button>
				<?php break;
			case 're-index': ?>
				<button type="submit" name="btnAction" value="re-index" class="btn orange">
					<span><?php echo lang('buttons:re-index'); ?></span>
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
				<button type="submit" name="btnAction" value="<?php echo $button ?>" class="<?php echo $btn_class; ?> blue">
					<span><?php echo lang('buttons:' . $button); ?></span>
				</button>
				<?php break;
			case 'cancel':
			case 'close':
			case 'preview':
				if($btn_class == 'btn') $btn_class .= ' gray';
				$uri = 'admin/' . $this->module_details['slug'];
				$active_section = $this->load->get_var('active_section');

				if ($active_section && isset($this->module_details['sections'][$active_section]['uri']))
				{
					$uri = $this->module_details['sections'][$active_section]['uri'];
				}
				
				echo anchor($uri, lang('buttons:' . $button), 'class="'.$btn_class. ' ' . $button . '"');
				break;

			/**
			 * @var		$id scalar - optionally can be received from an associative key from array $extra
			 * @since	1.2.0-beta2
			 */
			case 'edit':
				$id = is_array($extra) && array_key_exists('id', $extra) ? '/' . $button . '/' . $extra['id'] : NULL;
				if($btn_class == 'btn') $btn_class .= ' gray';

				echo anchor('admin/' . $this->module_details['slug'] . $id, lang('buttons:' . $button), 'class="'.$btn_class.' ' . $button . '"');
				break; ?>

		<?php endswitch; ?>
	<?php endforeach; ?>
<?php endif; ?>
