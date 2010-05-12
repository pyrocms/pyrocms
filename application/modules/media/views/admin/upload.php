<?php echo $template['partials']['nav']; ?>
<h3><?php echo lang('media.upload.title');?></h3>
<?php echo form_open_multipart('admin/media/upload', array('class' => 'crud'));?>

<ol>
	<li>
		<label for="userfile"><?php echo lang('media.labels.upload');?></label><br/>
		<input type="file" name="userfile" class="input" />
	</li>
</ol>

<?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload') )); ?>
<?php echo form_close(); ?>
