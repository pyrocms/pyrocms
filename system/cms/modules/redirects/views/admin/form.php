<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title">
				<?php if($this->method == 'add'): ?>
					<?php echo lang('redirects:add_title');?>
				<?php else: ?>
					<?php echo lang('redirects:edit_title');?>
				<?php endif ?>
			</span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php echo form_open(uri_string(), 'class="crud"') ?>
				<fieldset class="padding-top">
				
					<ul>

						<li class="row-fluid input-row">
							<label class="span3" for="type"><?php echo lang('redirects:type');?></label>
							<div class="input span9">
								<?php echo form_dropdown('type', array('301' => lang('redirects:301'), '302' => lang('redirects:302')), !empty($redirect['type']) ? $redirect['type'] : '302');?>
							</div>
						</li>

						<li class="row-fluid input-row">
							<label class="span3" for="from"><?php echo lang('redirects:from');?></label>
							<div class="input span9">
								<?php echo form_input('from', str_replace('%', '*', $redirect['from']));?>
							</div>
						</li>

						<li class="row-fluid input-row">
							<label class="span3" for="to"><?php echo lang('redirects:to');?></label>
							<div class="input span9">
								<?php echo form_input('to', $redirect['to']);?>
							</div>
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