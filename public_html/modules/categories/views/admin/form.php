<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h2>Create category</h2>
	
<? else: ?>
	<h2>Edit category "<?= $category->title; ?>"</h2>
<? endif; ?>

<?= form_open($this->uri->uri_string()); ?>

<div class="field">	<label for="title">Title</label>	<?= form_input('title', $category->title, 'class="text"'); ?></div><? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>