<?php if($this->method == 'add'): ?>
	<h3><?php echo lang('redirects.add_title');?></h3>
<?php else: ?>
	<h3><?php echo lang('redirects.edit_title');?></h3>
<?php endif; ?>

<?php echo form_open(uri_string(), 'class="crud"'); ?>
	<ul>
	<li>
		<label for="from"><?php echo lang('redirects.from');?></label>
		<?php echo form_input('from', $redirect->from);?>
	</li>
	<li>
		<label for="to"><?php echo lang('redirects.to');?></label>
		<?php echo form_input('to', $redirect->to);?>
	</li>
	</ul>

	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>