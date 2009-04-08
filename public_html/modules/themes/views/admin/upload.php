
	<h2>Upload Theme</h2>
	
	<p class="align-right">[ <?=anchor('admin/themes/index', 'Theme List') ?> ]</p>
	
	<? if ($this->session->flashdata('success')):?>
    	<div class="fcc-success"><?= $this->session->flashdata('success'); ?></div>
    <? endif; ?>
    
    <? if ($this->session->flashdata('error')):?>
    	<div class="fcc-error"><?= $this->session->flashdata('error'); ?></div>
    <? endif; ?>

	<?= form_open_multipart('admin/themes/upload');?>
	
	<p>
    	Please select a file and click Upload button<br />
		<input id="fileToUpload" type="file" name="userfile" class="input">
	</p>

    <p>
    	<input type="image" name="btnUpload" value="Upload" src="/assets/img/admin/fcc/btn-upload.jpg" />
	</p>

	<?=form_close(); ?>