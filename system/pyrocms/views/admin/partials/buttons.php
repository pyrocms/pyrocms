<?php if(isset($buttons) && is_array($buttons)): ?>

	<?php foreach($buttons as $button ): ?>
		<?php if( $button == 'save' ): ?>
			<button type="submit" name="btnAction" value="save" class="button">
				<span>
					<?php echo lang('buttons.save');?>
				</span>
			</button>

		<?php elseif( $button == 'save_exit' ): ?>
			<button type="submit" name="btnAction" value="save_exit" class="button">
				<span>
					<?php echo lang('buttons.save_exit');?>
				</span>
			</button>

		<?php elseif( $button == 'cancel' ): ?>

				<a href="<?php echo site_url('admin/'.$this->module_details['slug']);?>" class="button">
					<?php echo lang('buttons.cancel');?>
				</a>

		<?php elseif( $button == 'delete' ): ?>
			<button type="submit" name="btnAction" value="delete" class="button confirm">
				<span>
					<?php echo lang('buttons.delete');?>
				</span>
			</button>

		<?php elseif( $button == 'approve' ): ?>
			<button type="submit" name="btnAction" value="approve" class="button">
				<span>
					<?php echo lang('buttons.approve');?>
				</span>
			</button>

		<?php elseif( $button == 'unapprove' ): ?>
			<button type="submit" name="btnAction" value="unapprove" class="button">
				<span>
					<?php echo lang('buttons.unapprove');?>
				</span>
			</button>

		<?php elseif( $button == 'activate' ): ?>
			<button type="submit" name="btnAction" value="activate" class="button">
				<span>
					<?php echo lang('buttons.activate');?>
				</span>
			</button>

		<?php elseif( $button == 'publish' ): ?>
			<button type="submit" name="btnAction" value="publish" class="button">
				<span>
					<?php echo lang('buttons.publish');?>
				</span>
			</button>

		<?php elseif( $button == 'upload' ): ?>
			<button type="submit" name="btnAction" value="upload" class="button">
				<span>
					<?php echo lang('buttons.upload');?>
				</span>
			</button>
		<?php endif; ?>
	<?php endforeach; ?>

<?php endif; ?>
