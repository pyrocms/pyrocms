<? if ($photos): ?>
 
<h3>Photos in this Gallery</h3>

<div id="photos">

	<?=form_open('admin/galleries/deletephoto');?>
    <? foreach($photos as $photo): ?>
    	<div class="float-left align-center spacer-right">
    		<input type="checkbox" name="delete[<?=$photo->id?>]" /><br />
			<?=image('galleries/' . $this->uri->segment(4) . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('title'=>$photo->description));?><br />
		</div>
	<? endforeach; ?>
	
	<br class="clear-both" />
	<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('delete') )); ?>
	<?= form_close(); ?>
</div>

<? endif; ?>

<hr class="clear-both" />

<h3>Add a Photo</h3>

<?= form_open_multipart('admin/galleries/upload/' . $this->uri->segment(4)); ?>

<div class="field">
	<label>Photo</label>
	<input type="file" class="text" name="userfile" id="userfile" />
</div>

<div class="field">
	<label>Description</label>
	<input type="text" class="text" name="description" id="description" maxlength="100" />
</div>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>