<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('variables:create_title');?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('variables:edit_title'), $variable->name);?></h4>
	<?php endif ?>
</section>

<section class="item">
	<div class="content">

		<?php echo form_open($this->uri->uri_string(), 'class="crud" id="variables"') ?>
		<?php if ($this->method == 'edit') echo form_hidden('variable_id', $variable->id) ?>
		
		<div class="form_inputs">
		
			<ul>
				<li class="even">
					<label for="name"><?php echo lang('name_label');?> <span>*</span></label>
					<div class="input"><?php echo  form_input('name', $variable->name) ?></div>
				</li>
				
				<li class="">
					<label for="data"><?php echo lang('variables:data_label');?> <span>*</span></label>
					<div class="input"><?php echo  form_input('data', $variable->data) ?></div>
				</li>
			</ul>
				
			<div>
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>
		
		</div>
		
		<?php echo form_close() ?>
		
	</div>
</section>