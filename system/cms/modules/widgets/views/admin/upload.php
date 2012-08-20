<fieldset>

	<legend><?php echo lang('widgets.upload_title');?></legend>

	<?php echo form_open_multipart('admin/widgets/upload', array('class' => 'crud'));?>

		<ul>
			<li>
				<label for="userfile"><?php echo lang('widgets.upload_desc');?></label><br/>
				<input type="file" name="userfile" class="input" />
			</li>
		</ul>
		
		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload') )); ?>
		</div>
	<?php echo form_close(); ?>
	
</fieldset>
