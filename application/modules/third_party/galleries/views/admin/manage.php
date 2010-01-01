<?php if ($photos): ?> 
	<h3><?php echo lang('gal_manage_title');?></h3>
	<div id="photos">
		<?php echo form_open('admin/galleries/delete_photo');?>
			<?php echo form_hidden('gallery', $gallery->slug);?>
				<?php foreach($photos as $photo): ?>
					<div class="float-left align-center spacer-right">
						<input type="checkbox" name="action_to[]" value="<?php echo $photo->id?>" /><br />
						<?php echo image('galleries/' . $gallery->slug . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description));?><br />
					</div>
				<?php endforeach; ?>			
			<br class="clear-both" />
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		<?php echo form_close(); ?>	
	</div>
	<hr class="clear-both" />
<?php endif; ?>

<?php echo form_open_multipart('admin/galleries/upload/' . $this->uri->segment(4)); ?>
	<div class="fieldset fieldsetBlock active tabs">		
		<div class="header">
			<h3><?php echo lang('gal_add_photo_title');?></h3>
		</div>
		
		<div class="tabs">
			<ul class="clearfix">
				<li><a href="#fieldset1" title="Upload"><span><?php echo lang('gal_upload_label');?></span></a></li>
			</ul>
			
			<!-- Page content tab -->
			<fieldset id="fieldset1" >
				<legend><?php echo lang('gal_page_content_label');?></legend>	
		
				<div class="field">
					<label><?php echo lang('gal_photo_label');?></label>
					<input type="file" class="text" name="userfile" id="userfile" />
				</div>
				
				<div class="field">
					<label><?php echo lang('gal_desc_label');?></label>
					<input type="text" class="text" name="description" id="description" maxlength="100" />
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</div>
				
				<div class="spacer-left">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
				</div>
				
			</fieldset>	
		</div>	
	</div>
<?php echo form_close();?>