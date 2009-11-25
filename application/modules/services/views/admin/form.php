<?php if($method == 'create'): ?>
	<h3><?php echo lang('service_create_title');?></h3>	
<?php else: ?>
	<h3><?php echo sprintf(lang('service_edit_title'), $service->title);?></h3>
<?php endif; ?>

<?php echo form_open($this->uri->uri_string()); ?>

	<div class="field">
		<label for="title"><?php echo lang('service_title_label');?></label>
		<?php echo form_input('title', $service->title, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="price"><?php echo lang('service_price_label');?> (<?php echo $this->settings->item('currency');?>)</label>
		<?php echo form_input('price', $service->price, 'class="text width-5"'); ?> <?php echo form_dropdown('pay_per', $pay_per_options, $service->pay_per) ?>
	</div>
	
	<div class="field">
		<label for="description"><?php echo lang('service_desc_label');?></label>
		<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $service->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
	</div>
	
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>