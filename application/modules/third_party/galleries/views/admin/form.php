<?php if($method == 'create'): ?>
	<h3><?php echo lang('gal_create_title');?></h3>
<?php else: ?>
	<h3><?php echo sprintf(lang('gal_edit_title'), $gallery->title);?></h3>
<?php endif; ?>

<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
	<div class="field">
		<label for="title"><?php echo lang('gal_title_label');?></label>
		<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery->title; ?>" class="text" />
		<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
	</div>
	
	<div class="field">
		<label for="parent"><?php echo lang('gal_parent_gallery_label');?></label>		
		<select name="parent" size="1">
			<option value=""><?php echo lang('gal_no_parent_select_label');?></option>
			<?php create_tree_select($galleries, 0, 0, $gallery->parent, $gallery->id); ?>
		</select>
	</div>
	
	<div class="field">
		<label for="description"><?php echo lang('gal_desc_label');?></label>
		<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
	</div>
	
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>