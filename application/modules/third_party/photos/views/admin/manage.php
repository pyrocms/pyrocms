<?php if ($photos): ?> 
	<h3><?php echo lang('photo_albums.manage_title');?></h3>
	<div id="photos">
		<?php echo form_open('admin/photos/delete_photo');?>
			<?php echo form_hidden('album', $album->id);?>
				<?php foreach($photos as $photo): ?>
					<div class="float-left align-center spacer-right">
						<?php echo form_checkbox('action_to[]', $photo->id); ?><br />
						<?php echo image('photos/' . $album->slug . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description));?><br />
					</div>
				<?php endforeach; ?>			
			<br class="clear-both" />
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		<?php echo form_close(); ?>	
	</div>
	<hr class="clear-both" />
<?php endif; ?>

<div class="box">
	<h3><?php echo lang('photo_albums.add_photo_title');?></h3>
	
	<div class="box-container">
	
		<?php echo form_open_multipart('admin/photos/upload/' . $this->uri->segment(4), array('class' => "crud")); ?>
	
			<ol class="spacer-bottom">
				<li>
					<label><?php echo lang('photos.photo_label');?></label>
					<?php echo form_upload('userfile'); ?>
				</li>
				
				<li class="even">
					<label><?php echo lang('photos.desc_label');?></label>
					<?php echo form_input('description', $this->input->post('description'), 'maxlength="100"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
			</ol>
		
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	
		<?php echo form_close();?>
	</div>	
</div>