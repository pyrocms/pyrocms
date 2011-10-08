<?php if($this->method == 'add'): ?>
	<section class="title">
		<h4><?php echo lang('redirects.add_title');?></h4>
	</section>
<?php else: ?>
	<section class="title">
		<h4><?php echo lang('redirects.edit_title');?></h4>
	</section>
<?php endif; ?>

<section class="item">
<?php echo form_open(uri_string(), 'class="crud"'); ?>
	<ul>
	<li>
		<label for="from"><?php echo lang('redirects.from');?></label><br>
		<?php echo form_input('from', $redirect->from);?>
	</li>
	
	<hr>
	
	<li>
		<label for="to"><?php echo lang('redirects.to');?></label><br>
		<?php echo form_input('to', $redirect->to);?>
	</li>
	</ul>
	
	<hr>
	
	<div class="buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>
</section>