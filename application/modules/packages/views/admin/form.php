<?= form_open($this->uri->uri_string()); ?>
	<div class="field">
		<label for="title"><?=lang('pack_title_label');?></label>
		<?= form_input('title', $package->title, 'class="text"'); ?>
		<span class="required-icon tooltip"><?=lang('pack_required_label');?></span>
	</div>
	
	<div class="field">
		<label for="description"><?=lang('pack_desc_label');?></label>
		<?=form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $package->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
	</div>
	
	<? if( $this->uri->segment(3,'create') == 'create' ): ?>
		<div class="field">
			<label for="title"><?=lang('pack_featured_label');?></label>
			<input type="checkbox" name="featured" />
		</div>
	<? endif; ?>
	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>