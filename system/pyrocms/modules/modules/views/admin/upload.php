<h3><?php echo lang('modules.upload_title');?></h3>

<?php echo form_open_multipart('admin/modules/upload', array('class' => 'crud'));?>

	<ol>
		<li>
			<label for="userfile"><?php echo lang('modules.upload_desc');?></label><br/>
			<input type="file" name="userfile" class="input" />
		</li>
	</ol>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload') )); ?>
	</div>
<?php echo form_close(); ?>
