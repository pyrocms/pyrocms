<section class="title">
	<?php if ($this->controller === 'admin_categories' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('cat_edit_title'), $category->title);?></h4>
	<?php else: ?>
	<h4><?php echo lang('cat_create_title');?></h4>
	<?php endif; ?>
</section>

<section class="item">
	<?php echo form_open(uri_string(), 'class="crud '.$this->method.'" id="categories"'); ?>
	<?php echo form_hidden('id', $category->id); ?>

	<div class="form_inputs">

		<ul>
			<li>
				<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
				<div class="input"><?php echo  form_input('title', $category->title); ?></div>
			</li>
			
			<li>
				<label for="slug"><?php echo lang('global:slug'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('slug', $category->slug); ?></div>
			</li>
		</ul>
		
	</div>

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>

	<?php echo form_close(); ?>
</section>