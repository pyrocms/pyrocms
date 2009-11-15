<?php echo form_open($this->uri->uri_string()); ?>

	<div class="field">
		<label for="title"><?php echo lang('pack_title_label');?></label>
		<?php echo form_input('title', $package->title); ?>
		<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
	</div>
	
	<div class="field">
		<label for="description"><?=lang('pack_desc_label');?></label>
		<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $package->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
	</div>
	
	<?php if( $this->uri->segment(3,'create') == 'create' ): ?>
		<div class="field">
			<label for="title"><?php echo lang('pack_featured_label');?></label>
			<input type="checkbox" name="featured" />
		</div>
	<?php endif; ?>
	
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
	
<?php echo form_close(); ?>