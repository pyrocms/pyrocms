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

		<?php echo form_open(uri_string(), 'class="crud"') ?>
			<ul>
				<li class="row-fluid input-row">
					<label class="span3" for="type"><?php echo lang('redirects:type');?></label><br>
					<div class="input span9">
						<?php echo form_dropdown('type', array('301' => lang('redirects:301'), '302' => lang('redirects:302')), !empty($redirect['type']) ? $redirect['type'] : '302');?>
					</div>
				</li>
		
				<li class="row-fluid input-row">
					<label class="span3" for="from"><?php echo lang('redirects:from');?></label><br>
					<div class="input span9">
						<?php echo form_input('from', str_replace('%', '*', $redirect['from']));?>
					</div>
				</li>
		
				<li class="row-fluid input-row">
					<label class="span3" for="to"><?php echo lang('redirects:to');?></label><br>
					<div class="input span9">
						<?php echo form_input('to', $redirect['to']);?>
					</div>
				</li>
			</ul>
	
			<div class="btn-group padded">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>

		<?php echo form_close() ?>
	</section>


</div>
</section>