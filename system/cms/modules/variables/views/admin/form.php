<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<?php if ($this->method == 'create'): ?>
				<span class="title"><?php echo lang('variables:create_title');?></span>
			<?php else: ?>
				<span class="title"><?php echo sprintf(lang('variables:edit_title'), $variable->name);?></span>
			<?php endif ?>
		</section>

		<div class="padded">

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


</div>
</section>