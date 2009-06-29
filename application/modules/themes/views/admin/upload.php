<h3><?php echo lang('theme_upload_title');?></h3>
<p class="align-right">[ <?php echo anchor('admin/themes/index', lang('theme_list_label')) ?> ]</p>
<?php echo form_open_multipart('admin/themes/upload');?>
<p>
	<?php echo lang('theme_upload_desc');?><br />
	<input id="fileToUpload" type="file" name="userfile" class="input">
</p>
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('upload') )); ?>
<?php echo form_close(); ?>