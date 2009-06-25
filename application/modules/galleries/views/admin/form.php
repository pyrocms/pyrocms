<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h3><?=lang('gal_create_title');?></h3>
<? else: ?>
	<h3><?=sprintf(lang('gal_edit_title'), $gallery->title);?></h3>
<? endif; ?>

<?= form_open($this->uri->uri_string()); ?>
	<div class="field">
		<label for="title"><?=lang('gal_title_label');?></label>
		<input type="text" id="title" name="title" maxlength="255" value="<?= $gallery->title; ?>" class="text" />
		<span class="required-icon tooltip"><?=lang('gal_required_label');?></span>
	</div>
	
	<div class="field">
		<label for="parent"><?=lang('gal_parent_gallery_label');?></label>		
		<select name="parent" size="1">
			<option value=""><?=lang('gal_no_parent_select_label');?></option>
			<? create_tree_select($galleries, 0, 0, $gallery->parent, $gallery->id); ?>
		</select>
	</div>
	
	<div class="field">
		<label for="description"><?=lang('gal_desc_label');?></label>
		<?=form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
	</div>
	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>