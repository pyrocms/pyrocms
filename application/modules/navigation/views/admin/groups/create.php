<h3>New navigation group</h3>
    
<?= form_open('admin/navigation/groups/create'); ?>

<fieldset>
	
	<legend>Group</legend>
	
	<div class="field">
		<label for="title">Title</label>
		<?= form_input('title', $this->validation->title, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="url">Abbreviation</label>
		<?= form_input('abbrev', $this->validation->abbrev, 'class="text"'); ?>
	</div>
	
</fieldset>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>