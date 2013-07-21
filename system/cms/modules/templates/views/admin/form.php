<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title">
				<?php if($this->method == 'edit' and ! empty($email_template)): ?>
					<?php echo sprintf(lang('templates:edit_title'), $email_template->name) ?>
				<?php else: ?>
					<?php echo lang('templates:create_title') ?>
				<?php endif ?>
			</span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php echo form_open(current_url(), 'class="crud"') ?>
			
				<fieldset class="padding-top">
				
					<ul>
					
						<?php if ( ! $email_template->is_default): ?>
						<li class="row-fluid input-row">
							<label class="span3" for="name"><?php echo lang('name_label') ?> <span>*</span></label>
							<div class="input span9"><?php echo form_input('name', $email_template->name) ?></div>
						</li>
						
						<li class="row-fluid input-row">
							<label class="span3" for="slug"><?php echo lang('templates:slug_label') ?> <span>*</span></label>
							<div class="input span9"><?php echo form_input('slug', $email_template->slug) ?></div>
						</li>
						
						<li class="row-fluid input-row">
							<label class="span3" for="lang"><?php echo lang('templates:language_label') ?></label>
							<div class="input span9"><?php echo form_dropdown('lang', $lang_options, array($email_template->lang)) ?>
						</li>
						
						<li class="row-fluid input-row">
							<label class="span3" for="description"><?php echo lang('desc_label') ?> <span>*</span></label>
							<div class="input span9"><?php echo form_input('description', $email_template->description) ?></div>
						</li>
						
						<?php endif ?>
						<li class="row-fluid input-row">
							<label class="span3" for="subject"><?php echo lang('templates:subject_label') ?> <span>*</span></label>
							<div class="input span9"><?php echo form_input('subject', $email_template->subject) ?></div>
						</li>
					
						<li class="row-fluid input-row">
							<label for="body"><?php echo lang('templates:body_label') ?> <span>*</span></label>
							<br style="clear:both" />
							<div class="padded no-padding-top">
								<?php echo form_textarea('body', $email_template->body, 'class="templates wysiwyg-advanced"') ?>
							</div>
						</li>
					
					</ul>
				
					<div class="btn-group padded no-padding-bottom">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
					</div>
			
				</div>
						
			<?php echo form_close() ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>