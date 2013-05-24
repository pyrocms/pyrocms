<section class="content-wrapper">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
				<span class="title"><?php echo sprintf(lang('cat:edit_title'), $category->title);?></span>
			<?php else: ?>
				<span class="title"><?php echo lang('cat:create_title');?></span>
			<?php endif ?>
		</section>

		<?php echo form_open($this->uri->uri_string(), 'class="crud'.((isset($mode)) ? ' '.$mode : '').'" id="categories"') ?>

			<fieldset>
				<ul>
					<li class="row-fluid input-row">
						<label class="span3" for="title"><?php echo lang('global:title');?> <span>*</span></label>
						<div class="input span9"><?php echo  form_input('title', $category->title) ?></div>
					</li>

					<li class="row-fluid input-row">
						<label class="span3" for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>
						<div class="input span9"><?php echo  form_input('slug', $category->slug) ?></div>
						<?php echo  form_hidden('id', $category->id) ?>
					</li>
				</ul>

			<fieldset>

			<div class="btn-group form-btn-group">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>

		<?php echo form_close() ?>
		
	</section>


</div>
</section>