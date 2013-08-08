<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo sprintf(lang('templates:clone_title'), $template_name) ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php echo form_open(current_url(), 'class="crud"') ?>
			
				<fieldset class="padding-top">
				
					<ul>
						<li class="row-fluid input-row">
						    <label class="span3" for="lang"><?php echo lang('templates:choose_lang_label') ?></label>
						    <div class="input span9">
						    	<?php echo form_dropdown('lang', $lang_options) ?>
						    </div>
						</li>
					</ul>

				</fieldset>
			
			<?php echo form_close() ?>


			<div class="btn-group padded no-padding-top">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>