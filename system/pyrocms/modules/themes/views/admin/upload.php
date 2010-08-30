<h3><?php echo lang('themes.upload_title');?></h3>

<?php echo form_open_multipart('admin/themes/upload', array('class' => 'crud'));?>

	<ol>
		<li>
			<label for="userfile"><?php echo lang('themes.upload_desc');?></label><br/>
			<input type="file" name="userfile" class="input" />
		</li>
	</ol>
	
	<div class="float-right">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload') )); ?>
	</div>
<?php echo form_close(); ?>
