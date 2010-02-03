<div class="box">

	<?php if($method == 'create'): ?>
		<h3><?php echo lang('var_create_title');?></h3>
		
	<?php else: ?>
		<h3><?php echo sprintf(lang('var_edit_title'), $variable->name);?></h3>
		
	<?php endif; ?>
	
	<div class="box-container">

	
	<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
	
		<fieldset>
			<ol>
				<li class="even">
				<label for="name"><?php echo lang('var_name_label');?></label>
				<?php echo  form_input('name', $variable->name); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
			</ol>
            <ol>
				<li class="even">
				<label for="data"><?php echo lang('var_data_label');?></label>
				<?php echo  form_input('data', $variable->data); ?>				
				</li>
			</ol>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</fieldset>
		
	<?php echo form_close(); ?>
	
	</div>
</div>