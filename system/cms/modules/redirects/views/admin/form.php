<section class="title">
<?php if($this->method == 'add'): ?>
	<h4><?php echo lang('redirects:add_title');?></h4>
<?php else: ?>
	<h4><?php echo lang('redirects:edit_title');?></h4>
<?php endif ?>
</section>

<section class="item">
	<div class="content">
		<?php echo form_open(uri_string(), 'class="crud"') ?>
			<ul>
			<li>
				<label for="type"><?php echo lang('redirects:type');?></label><br>
				<?php echo form_dropdown('type', array('301' => lang('redirects:301'), '302' => lang('redirects:302')), !empty($redirect['type']) ? $redirect['type'] : '302');?>
			</li>
	
			<hr>
			<li>
				<label for="from"><?php echo lang('redirects:from');?></label><br>
				<?php echo form_input('from', str_replace('%', '*', $redirect['from']));?>
			</li>
	
			<hr>
	
			<li>
				<label for="to"><?php echo lang('redirects:to');?></label><br>
				<?php echo form_input('to', $redirect['to']);?>
			</li>
			</ul>
	
			<hr>
	
			<div class="buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>
		<?php echo form_close() ?>
	</div>
</section>