<section class="padded">
<div class="container-fluid">


	<section class="box">

		<?php if($this->method == 'edit' and ! empty($email_template)): ?>
			<section class="box-header">
		    	<span class="title"><?php echo sprintf(lang('templates:edit_title'), $email_template->name) ?></span>
			</section>
		<?php else: ?>
			<section class="box-header">
		    	<span class="title"><?php echo lang('templates:create_title') ?></span>
			</section>
		<?php endif ?>

		<?php echo form_open(current_url()) ?>
		
			<ul>
			
				<?php if ( ! $email_template->is_default): ?>
				<li class="row-fluid input-row">
					<label class="span3" for="name"><?php echo lang('name_label') ?> <span>*</span></label>
					<div class="input span9">
						<?php echo form_input('name', $email_template->name) ?>
					</div>
				</li>
				
				<li class="row-fluid input-row">
					<label class="span3" for="slug"><?php echo lang('templates:slug_label') ?> <span>*</span></label>
					<div class="input span9">
						<?php echo form_input('slug', $email_template->slug) ?>
					</div>
				</li>
				
				<li class="row-fluid input-row">
					<label class="span3" for="lang"><?php echo lang('templates:language_label') ?></label>
					<div class="input span9">
						<?php echo form_dropdown('lang', $lang_options, array($email_template->lang)) ?>
					</div>
				</li>
				
				<li class="row-fluid input-row">
					<label class="span3" for="description"><?php echo lang('desc_label') ?> <span>*</span></label>
					<div class="input span9">
						<?php echo form_input('description', $email_template->description) ?>
					</div>
				</li>
				
				<?php endif ?>
				<li class="row-fluid input-row">
					<label class="span3" for="subject"><?php echo lang('templates:subject_label') ?> <span>*</span></label>
					<div class="input span9">
						<?php echo form_input('subject', $email_template->subject) ?>
					</div>
				</li>
			
				<li class="row-fluid input-row">
					<label for="body"><?php echo lang('templates:body_label') ?> <span>*</span></label>
					<div class="input">
						<?php echo form_textarea('body', $email_template->body, 'class="wysiwyg-advanced"') ?>
					</div>
				</li>
			
			</ul>
		
			<div class="btn-group padded">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>
					
		<?php echo form_close() ?>
		</div>
		
	</section>


</div>
</section>