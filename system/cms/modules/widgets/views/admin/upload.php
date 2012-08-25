<fieldset>

	<legend><?php echo lang('widgets.upload_title');?></legend>

	<?php echo form_open_multipart('admin/widgets/upload', array('class' => 'crud'));?>

		<ul>
			<li>
				<h4><?php echo lang('widgets.upload_desc');?></h4>
			</li>
			
			<li>
				<input type="file" name="userfile" class="input" />
			</li>
		</ul>
		
		<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload') )); ?></div>
		
	<?php echo form_close(); ?>
	
</fieldset>
