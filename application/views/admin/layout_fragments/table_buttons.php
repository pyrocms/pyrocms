<? if(isset($buttons) && is_array($buttons)): ?>
	
	<div class="buttons spacer-top">
	
		<? if( in_array('save', $buttons) ): ?>
		<div class="float-left">
			<button type="submit" name="btnAction" value="save" class="button">
				<strong>
					Save
					<img class="icon" alt="" src="<?=image_url('admin/icons/accepted_48.png');?>" />
				</strong>
			</button>
		</div>
		<? endif; ?>
	
		<? if( in_array('activate', $buttons) ): ?>
		<div class="float-left">
			<button type="submit" name="btnAction" value="activate" class="button">
				<strong>
					Activate
					<img class="icon" alt="" src="<?=image_url('admin/icons/accepted_48.png');?>" />
				</strong>
			</button>
		</div>
		<? endif; ?>
	
		<? if( in_array('upload', $buttons) ): ?>
		<div class="float-left">
			<button type="submit" name="btnAction" value="upload" class="button">
				<strong>
					Upload
					<img class="icon" alt="" src="<?=image_url('admin/icons/box_upload_48.png');?>" />
				</strong>
			</button>
		</div>
		<? endif; ?>
		
		<? if( in_array('cancel', $buttons) ): ?>
		<div class="float-left">
			<a href="/admin/<?=$module;?>/index" class="button width-7">
				<strong>
					Cancel
					<img class="icon" alt="Cancel" src="<?=image_url('admin/icons/cancel_48.png');?>"/>
				</strong>
			</a>
		</div>
		<? endif; ?>
		
		<? if( in_array('delete', $buttons) ): ?>
		<div class="float-left">
			<button type="submit" name="btnAction" value="delete" class="button confirm">
				<strong>
					Delete
					<img class="icon" alt="Delete selected" src="<?=image_url('admin/icons/cross_48.png');?>" />
				</strong>
			</button>
		</div>
		<? endif; ?>
		
		<br class="clear-both" />
		
	</div>
<? endif; ?>