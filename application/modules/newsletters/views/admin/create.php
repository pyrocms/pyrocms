<?= form_open('admin/newsletters/create'); ?>

<div class="field clearfix">
	<label for="title">Title</label>
	<input type="text" id="title" name="title" maxlength="100" value="<?= $this->validation->title; ?>" />
</div>

<div class="field clearfix">
	<label for="body">Message</label>
	<?= $this->spaw->show(); ?>
</div>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>