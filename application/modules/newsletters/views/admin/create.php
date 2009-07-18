<?= form_open('admin/newsletters/create'); ?>

	<div class="field">
		<label for="title"><?=lang('letter_title_label');?></label>
		<input type="text" id="title" name="title" maxlength="100" value="<?= $this->validation->title; ?>" class="text" />
		<span class="required-icon tooltip"><?=lang('letter_required_label');?></span>
	</div>
	
	<div class="field">
		<?=form_textarea(array('id'=>'body', 'name'=>'body', 'value' => htmlentities(stripslashes($this->validation->body)), 'rows' => 40, 'class'=>'wysiwyg-advanced')); ?>
	</div>
	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>