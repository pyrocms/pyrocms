<?php if ($this->method == 'create'): ?>
	<h3><?php echo lang('variables.create_title');?></h3>

<?php else: ?>
	<h3><?php echo sprintf(lang('variables.edit_title'), $variable->name);?></h3>
<?php endif; ?>
	
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="variables"'); ?>

	<fieldset>
		<ul>
			<li class="even">
				<label for="name"><?php echo lang('variables.name_label');?></label>
				<?php echo  form_input('name', $variable->name); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			</li>
			<li class="even">
				<label for="data"><?php echo lang('variables.data_label');?></label>
				<?php echo  form_input('data', $variable->data); ?>
			</li>
		</ul>

		<div class="float-right">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
	</fieldset>

<?php echo form_close(); ?>