<?php if(isset($buttons) && is_array($buttons)): ?>	
	<div class="buttons spacer-top">		
		<?php foreach($buttons as $button ): ?>		
			<?php if( $button == 'save' ): ?>
			<div class="float-left">
				<button type="submit" name="btnAction" value="save" class="button">
					<strong>
						<?php echo lang('save_label');?>
					</strong>
				</button>
			</div>
			
			<?php elseif( $button == 'cancel' ): ?>
			<div class="float-left">
				<a href="<?php echo site_url('admin/'.$module.'/index');?>" class="button ajax">
					<strong>
						<?php echo lang('cancel_label');?>
					</strong>
				</a>
			</div>
			
			<?php elseif( $button == 'delete' ): ?>
			<div class="float-left">
				<button type="submit" name="btnAction" value="delete" class="button confirm">
					<strong>
						<?php echo lang('delete_label');?>
					</strong>
				</button>
			</div>
			
			<?php elseif( $button == 'approve' ): ?>
			<div class="float-left">
				<button type="submit" name="btnAction" value="approve" class="button">
					<strong>
						<?php echo lang('approve_label');?>
					</strong>
				</button>
			</div>
			
			<?php elseif( $button == 'unapprove' ): ?>
			<div class="float-left">
				<button type="submit" name="btnAction" value="unapprove" class="button">
					<strong>
						<?php echo lang('unapprove_label');?>
					</strong>
				</button>
			</div>
		
			<?php elseif( $button == 'activate' ): ?>
			<div class="float-left">
				<button type="submit" name="btnAction" value="activate" class="button">
					<strong>
						<?php echo lang('activate_label');?>
					</strong>
				</button>
			</div>
		
			<?php elseif( $button == 'publish' ): ?>
			<div class="float-left">
				<button type="submit" name="btnAction" value="publish" class="button">
					<strong>
						<?php echo lang('publish_label');?>
					</strong>
				</button>
			</div>
		
			<?php elseif( $button == 'upload' ): ?>
			<div class="float-left">
				<button type="submit" name="btnAction" value="upload" class="button">
					<strong>
						<?php echo lang('upload_label');?>
					</strong>
				</button>
			</div>
			<?php endif; ?>			
		<?php endforeach; ?>
		<br class="clear-both" />		
	</div>
<?php endif; ?>