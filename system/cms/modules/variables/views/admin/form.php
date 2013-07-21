<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title">
				<?php if ($this->method == 'create'): ?>
					<?php echo lang('variables:create_title');?>
				<?php else: ?>
					<?php echo sprintf(lang('variables:edit_title'), $variable->name);?>
				<?php endif ?>
			</span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php echo form_open($this->uri->uri_string(), 'class="crud" id="variables"') ?>
			<?php if ($this->method == 'edit') echo form_hidden('variable_id', $variable->id) ?>
			
			<fieldset class="padding-top">
			
				<ul>
					<li class="row-fluid input-row">
						<label class="span3" for="name"><?php echo lang('name_label');?> <span>*</span></label>
						<div class="input span9"><?php echo  form_input('name', $variable->name) ?></div>
					</li>
					
					<li class="row-fluid input-row">
						<label class="span3" for="data"><?php echo lang('variables:data_label');?> <span>*</span></label>
						<div class="input span9"><?php echo  form_input('data', $variable->data) ?></div>
					</li>
				</ul>

			</fieldset>
					
			<div class="btn-group padded no-padding-bottom">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>


			<?php echo form_close() ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>