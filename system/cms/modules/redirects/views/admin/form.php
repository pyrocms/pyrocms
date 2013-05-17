<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
		<?php if($this->method == 'add'): ?>
			<span class="title"><?php echo lang('redirects:add_title');?></span>
		<?php else: ?>
			<span class="title"><?php echo lang('redirects:edit_title');?></span>
		<?php endif ?>
		</section>

		<div class="padded">
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
		
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>

			<?php echo form_close() ?>
		</div>
	</section>


</div>
</section>