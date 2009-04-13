<?= form_open($this->uri->uri_string()); ?>

<div class="field">
	<label for="title">Title</label>
	<?= form_input('title', $package->title, 'class="text"'); ?>
</div>

<div class="field">
	<label for="description">Description</label>
	<?= $this->spaw->show(); ?>
</div>

<? if( $this->uri->segment(3,'create') == 'create' ): ?>
<div class="field">
	<label for="title">Featured</label>
	<input type="checkbox" name="featured" />
</div>
<? endif; ?>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>