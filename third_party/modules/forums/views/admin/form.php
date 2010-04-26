<div class="box">

	<?php if($method == 'create_category'): ?>
		<h3><?php echo lang('forums_create_category_title');?></h3>
	<?php else: ?>
		<h3><?php echo sprintf(lang('forums_edit_category_title'), $category->title);?></h3>
	<?php endif; ?>

	<div class="box-container">

		<?php echo form_open($this->uri->uri_string(), 'class="crud"', array('id' => $category->id)); ?>

					<ol>

						<li>
							<label for="title"><?php echo lang('forums_title_label');?></label>
							<?php echo form_input('title', $category->title, 'maxlength="100"'); ?>
							<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
						</li>

					</ol>

		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>

		<?php echo form_close(); ?>

	</div>
</div>