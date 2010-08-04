<?php if(isset($buttons) && is_array($buttons)): ?>

	<?php foreach($buttons as $button ): ?>		
		<?php if( $button == 'save' ): ?>
			<button type="submit" name="btnAction" value="save" class="pyro-button">
				<span>
					<?php echo lang('save_label');?>
				</span>
			</button>
		
		<?php elseif( $button == 'cancel' ): ?>
			<div class="pyro-button">
				<a href="<?php echo site_url('admin/'.$module);?>">
					<?php echo lang('cancel_label');?>
				</a>
			</div>
		
		<?php elseif( $button == 'delete' ): ?>
			<button type="submit" name="btnAction" value="delete" class="pyro-button confirm">
				<span>
					<?php echo lang('delete_label');?>
				</span>
			</button>
		
		<?php elseif( $button == 'approve' ): ?>
			<button type="submit" name="btnAction" value="approve" class="pyro-button">
				<span>
					<?php echo lang('approve_label');?>
				</span>
			</button>
		
		<?php elseif( $button == 'unapprove' ): ?>
			<button type="submit" name="btnAction" value="unapprove" class="pyro-button">
				<span>
					<?php echo lang('unapprove_label');?>
				</span>
			</button>
	
		<?php elseif( $button == 'activate' ): ?>
			<button type="submit" name="btnAction" value="activate" class="pyro-button">
				<span>
					<?php echo lang('activate_label');?>
				</span>
			</button>
	
		<?php elseif( $button == 'publish' ): ?>
			<button type="submit" name="btnAction" value="publish" class="pyro-button">
				<span>
					<?php echo lang('publish_label');?>
				</span>
			</button>
	
		<?php elseif( $button == 'upload' ): ?>
			<button type="submit" name="btnAction" value="upload" class="pyro-button">
				<span>
					<?php echo lang('upload_label');?>
				</span>
			</button>
		<?php endif; ?>			
	<?php endforeach; ?>

<?php endif; ?>