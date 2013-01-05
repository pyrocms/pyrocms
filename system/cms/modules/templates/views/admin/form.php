<div class="one_full">
<?php if($this->method == 'edit' and ! empty($email_template)): ?>
	<section class="title">
    	<h4><?php echo sprintf(lang('templates:edit_title'), $email_template->name) ?></h4>
	</section>
<?php else: ?>
	<section class="title">
    	<h4><?php echo lang('templates:create_title') ?></h4>
	</section>
<?php endif ?>

<section class="item">
	<div class="content">
	<?php echo form_open(current_url(), 'class="crud"') ?>
	
		<div class="form_inputs">
		
			<ul>
			
				<?php if ( ! $email_template->is_default): ?>
				<li class="<?php echo alternator('even', '') ?>">
					<label for="name"><?php echo lang('name_label') ?> <span>*</span></label>
					<div class="input"><?php echo form_input('name', $email_template->name) ?></div>
				</li>
				
				<li  class="<?php echo alternator('even', '') ?>">
					<label for="slug"><?php echo lang('templates:slug_label') ?> <span>*</span></label>
					<div class="input"><?php echo form_input('slug', $email_template->slug) ?></div>
				</li>
				
				<li class="<?php echo alternator('even', '') ?>">
					<label for="lang"><?php echo lang('templates:language_label') ?></label>
					<div class="input"><?php echo form_dropdown('lang', $lang_options, array($email_template->lang)) ?>
				</li>
				
				<li class="<?php echo alternator('even', '') ?>">
					<label for="description"><?php echo lang('desc_label') ?> <span>*</span></label>
					<div class="input"><?php echo form_input('description', $email_template->description) ?></div>
				</li>
				
				<?php endif ?>
				<li class="<?php echo alternator('even', '') ?>">
					<label for="subject"><?php echo lang('templates:subject_label') ?> <span>*</span></label>
					<div class="input"><?php echo form_input('subject', $email_template->subject) ?></div>
				</li>
			
				<li class="<?php echo alternator('even', '') ?>">
					<label for="body"><?php echo lang('templates:body_label') ?> <span>*</span></label>
					<br style="clear:both" />
					<?php echo form_textarea('body', $email_template->body, 'class="templates wysiwyg-advanced"') ?>
				</li>
			
			</ul>
		
			<div class="buttons padding-top">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>
	
		</div>
				
	<?php echo form_close() ?>
	</div>
</section>
</div>