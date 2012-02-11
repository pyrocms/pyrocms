<section class="title">
	<h4><?php echo lang('robots:title:overview'); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="txt"><?php echo lang('robots:label:txt'); ?> <span>*</span></label>
				<div class="input"><?php echo form_textarea('txt', set_value('txt', $txt), 'class="width-full"'); ?></div>
			</li>
		</ul>
		
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>