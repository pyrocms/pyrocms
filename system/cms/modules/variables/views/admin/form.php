<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('variables.create_title');?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('variables.edit_title'), $variable->name);?></h4>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="variables"'); ?>
<?php if ($this->method == 'edit') echo form_hidden('variable_id', $variable->id); ?>

		<ul>
			<li class="even">
				<label for="name"><?php echo lang('name_label');?></label><br>
				<?php echo  form_input('name', $variable->name); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			</li>
			
			<hr>
			
			<li class="">
				<label for="data"><?php echo lang('variables.data_label');?></label><br>
				<?php echo  form_input('data', $variable->data); ?>
			</li>
		</ul>
		
		<hr>

		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>

<?php echo form_close(); ?>
</section>