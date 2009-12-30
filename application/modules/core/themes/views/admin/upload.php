<div class="box">

	<h3><?php echo lang('themes.upload_title');?></h3>

	<div class="box-container">
	
		<?php echo form_open_multipart('admin/themes/upload', 'class="crud"');?>
	
			<p>
				<?php echo lang('themes.upload_desc');?><br />
				<input id="fileToUpload" type="file" name="userfile" class="input">
			</p>
		
		<?php $this->load->view('admin/partials/table_buttons', array('buttons' => array('upload') )); ?>
		<?php echo form_close(); ?>
	
	</div>
</div>