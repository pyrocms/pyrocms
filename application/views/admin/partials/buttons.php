<?php if(isset($buttons) && is_array($buttons)): ?>

	<?php foreach($buttons as $button ): ?>		
		<?php if( $button == 'save' ): ?>
			<button type="submit" name="btnAction" value="save">
				<span>
					<?php echo lang('save_label');?>
				</span>
			</button>
		
		<?php elseif( $button == 'cancel' ): ?>
			<div class="button">
				<a href="<?php echo site_url('admin/'.$module);?>" class="ajax">
					<?php echo lang('cancel_label');?>
				</a>
			</div>
		
		<?php elseif( $button == 'delete' ): ?>
			<button type="submit" name="btnAction" value="delete" class="confirm">
				<span>
					<?php echo lang('delete_label');?>
				</span>
			</button>
		
		<?php elseif( $button == 'approve' ): ?>
			<button type="submit" name="btnAction" value="approve">
				<span>
					<?php echo lang('approve_label');?>
				</span>
			</button>
		
		<?php elseif( $button == 'unapprove' ): ?>
			<button type="submit" name="btnAction" value="unapprove">
				<span>
					<?php echo lang('unapprove_label');?>
				</span>
			</button>
	
		<?php elseif( $button == 'activate' ): ?>
			<button type="submit" name="btnAction" value="activate">
				<span>
					<?php echo lang('activate_label');?>
				</span>
			</button>
	
		<?php elseif( $button == 'publish' ): ?>
			<button type="submit" name="btnAction" value="publish">
				<span>
					<?php echo lang('publish_label');?>
				</span>
			</button>
	
		<?php elseif( $button == 'upload' ): ?>
			<button type="submit" name="btnAction" value="upload">
				<span>
					<?php echo lang('upload_label');?>
				</span>
			</button>
		<?php endif; ?>			
	<?php endforeach; ?>

<?php endif; ?>