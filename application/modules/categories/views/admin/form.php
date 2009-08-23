<?php if($this->uri->segment(3,'create') == 'create'): ?>
	<h2><?php echo lang('cat_create_title');?></h2>	
<?php else: ?>
	<h2><?php echo sprintf(lang('cat_edit_title'), $this->data->category->title);?></h2>
<?php endif; ?>
<?php echo form_open($this->uri->uri_string()); ?>
	<div class="field">
		<label for="title"><?php echo lang('cat_title_label');?></label>
		<?php echo  form_input('title', $category->title, 'class="text"'); ?>
		<span class="required-icon tooltip"><?php echo lang('cat_required_label');?></span>
	</div>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>