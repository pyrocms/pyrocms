<?php if (isset($buttons) && is_array($buttons)): ?>
	<?php foreach ($buttons as $button ):
			switch ($button) :

			case 'save': ?>
			<button type="submit" name="btnAction" value="save" class="button">
				<span>
					<?php echo lang('buttons.save');?>
				</span>
			</button>
		<?php break; ?>

		<?php case 'save_exit': ?>
			<button type="submit" name="btnAction" value="save_exit" class="button">
				<span>
					<?php echo lang('buttons.save_exit');?>
				</span>
			</button>
		<?php break; ?>

		<?php case 'cancel': ?>
				<a href="<?php echo site_url('admin/'.$this->module_details['slug']);?>" class="button cancel">
					<?php echo lang('buttons.cancel');?>
				</a>
		<?php break; ?>

		<?php case 'delete': ?>
			<button type="submit" name="btnAction" value="delete" class="button confirm">
				<span>
					<?php echo lang('buttons.delete');?>
				</span>
			</button>
		<?php break; ?>

		<?php case 'approve': ?>
			<button type="submit" name="btnAction" value="approve" class="button">
				<span>
					<?php echo lang('buttons.approve');?>
				</span>
			</button>
		<?php break; ?>

		<?php case 'unapprove': ?>
			<button type="submit" name="btnAction" value="unapprove" class="button">
				<span>
					<?php echo lang('buttons.unapprove');?>
				</span>
			</button>
		<?php break; ?>

		<?php case 'activate': ?>
			<button type="submit" name="btnAction" value="activate" class="button">
				<span>
					<?php echo lang('buttons.activate');?>
				</span>
			</button>
		<?php break; ?>

		<?php case 'publish': ?>
			<button type="submit" name="btnAction" value="publish" class="button">
				<span>
					<?php echo lang('buttons.publish');?>
				</span>
			</button>
		<?php break; ?>

		<?php case 'upload': ?>
			<button type="submit" name="btnAction" value="upload" class="button">
				<span>
					<?php echo lang('buttons.upload');?>
				</span>
			</button>
		<?php break; ?>

		<?php case 'preview': ?>
				<a href="<?php echo site_url('admin/'.$this->module_details['slug']);?>" class="button preview">
					<?php echo lang('buttons.preview');?>
				</a>
		<?php break; ?>

		<?php case 'close': ?>
				<a href="<?php echo site_url('admin/'.$this->module_details['slug']);?>" class="button close">
					<?php echo lang('buttons.close');?>
				</a>
		<?php break; ?>

		<?php endswitch; ?>
	<?php endforeach; ?>
<?php endif; ?>
