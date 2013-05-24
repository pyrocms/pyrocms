<section class="content-wrapper">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<?php if ($this->method == 'create'): ?>
				<span class="title"><?php echo lang('variables:create_title');?></span>
			<?php else: ?>
				<span class="title"><?php echo sprintf(lang('variables:edit_title'), $variable->name);?></span>
			<?php endif ?>
		</section>


		<?php echo form_open($this->uri->uri_string(), 'class="crud" id="variables"') ?>
		<?php if ($this->method == 'edit') echo form_hidden('variable_id', $variable->id) ?>
		
		<div class="form_inputs">
		
			<ul>
				<li class="row-fluid input-row">
					<label class="span3" for="name"><?php echo lang('name_label');?> <span>*</span></label>
					<div class="input span9">
						<?php echo  form_input('name', $variable->name) ?>
					</div>
				</li>
				
				<li class="row-fluid input-row">
					<label class="span3" for="data"><?php echo lang('variables:data_label');?> <span>*</span></label>
					<div class="input span9">
						<?php echo  form_input('data', $variable->data) ?>
					</div>
				</li>
			</ul>
				
			<div class="btn-group form-btn-group">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>
		
		</div>
		
		<?php echo form_close() ?>
		
	</section>


</div>
</section>