<?php echo form_open('admin/newsletters/create'); ?>

	<div class="field">
		<label for="title"><?php echo lang('letter_title_label');?></label>
		<input type="text" id="title" name="title" maxlength="100" value="<?php echo $this->validation->title; ?>" class="text" />
		<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
	</div>
	
	<div class="field">
		<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' => htmlentities(stripslashes($this->validation->body)), 'rows' => 40, 'class'=>'wysiwyg-advanced')); ?>
	</div>
	
	<?php $this->load->view('admin/partials/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>