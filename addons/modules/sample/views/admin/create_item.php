<div id="sample_form_box">

	<h3><?php echo lang('sample.new_item'); ?></h3>

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		<ol>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('sample.name'); ?></label>
				<?php echo form_input('name', set_value('name'), 'class="width-15"'); ?>
				<span class="required-icon tooltip">Required</span>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="slug"><?php echo lang('sample.slug'); ?></label>
				<?php echo form_input('slug', set_value('slug'), 'class="width-15"'); ?>
				<span class="required-icon tooltip">Required</span>
			</li>
		</ol>

		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'custom_button') )); ?>
	
	<?php echo form_close(); ?>

</div>
