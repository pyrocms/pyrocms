<h3>Upload Theme</h3>

<p class="align-right">[ <?=anchor('admin/themes/index', 'Theme List') ?> ]</p>

<?= form_open_multipart('admin/themes/upload');?>

<p>
    Please select a file and click Upload button<br />
	<input id="fileToUpload" type="file" name="userfile" class="input">
</p>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('upload') )); ?>

<?=form_close(); ?>