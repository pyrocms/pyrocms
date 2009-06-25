<h3><?= lang('theme_upload_title');?></h3>
<p class="align-right">[ <?=anchor('admin/themes/index', lang('theme_list_label')) ?> ]</p>
<?= form_open_multipart('admin/themes/upload');?>
<p>
	<?= lang('theme_upload_desc');?><br />
	<input id="fileToUpload" type="file" name="userfile" class="input">
</p>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('upload') )); ?>
<?=form_close(); ?>