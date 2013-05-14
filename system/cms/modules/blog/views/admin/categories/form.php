<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
				<span class="title"><?php echo sprintf(lang('cat:edit_title'), $category->title);?></span>
			<?php else: ?>
				<span class="title"><?php echo lang('cat:create_title');?></span>
			<?php endif ?>
		</section>

		<div class="padded">
			
			<?php echo form_open($this->uri->uri_string(), 'class="crud'.((isset($mode)) ? ' '.$mode : '').'" id="categories"') ?>

			<div class="form_inputs">

				<ul>
					<li class="even">
						<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
						<div class="input"><?php echo  form_input('title', $category->title) ?></div>
						<label for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>
						<div class="input"><?php echo  form_input('slug', $category->slug) ?></div>
						<?php echo  form_hidden('id', $category->id) ?>
					</li>
				</ul>

			</div>

			<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?></div>

			<?php echo form_close() ?>

		</div>
		
	</section>


</div>
</section>