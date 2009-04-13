<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h3>Create navigation link</h3>
	
<? else: ?>
	<h3>Edit navigation link "<?= $navigation_link->title; ?>"</h3>
<? endif; ?>


<?= form_open($this->uri->uri_string()); ?><fieldset>
	<legend>Details</legend>
	
	<div class="field">
		<label for="title">Text</label>
		<input type="text" id="title" name="title" maxlength="50" value="<?= $navigation_link->title; ?>" />
	</div>
	
	<div class="field">
		<label for="navigation_group_id">Group</label>
		<?=form_dropdown('navigation_group_id', $groups_select, $navigation_link->navigation_group_id, 'size="'.count($groups_select).'"') ?>
	</div>
	
	<div class="field">
		<label for="position">Position</label>
		<input type="text" id="position" name="position" value="<?= $navigation_link->position; ?>" />
	</div>
	
</fieldset>


<fieldset>
	<legend>Location</legend>
	
	<p>Please pick <strong>one</strong> of the types of link from below.</p>
	
	<div class="field float-left">
		<label for="url">URL</label>
		<input type="text" id="url" name="url" value="<?= $navigation_link->url; ?>" />
	</div>
	
	<div class="field float-left">
		<label for="module_name">Module</label>
		<?=form_dropdown('module_name', array('-- Select --')+$modules_select, $navigation_link->module_name) ?>
	</div>
	
	<div class="field float-left">
		<label for="uri">Site Link (URI)</label>
		<input type="text" id="uri" name="uri" value="<?= $navigation_link->uri; ?>" />
	</div>
	
	<div class="field float-left">
		<label for="page_id">Page</label>
		<select name="page_id">
			<option value="">-- Select --</option>
			<? create_tree_select($pages_select, 0, 0, $navigation_link->page_id); ?>
		</select>
	</div>

</fieldset>
<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>