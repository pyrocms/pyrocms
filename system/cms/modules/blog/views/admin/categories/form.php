<div class="padding">


	<section id="page-title">
		<h1>
			<?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
				<?php echo sprintf(lang('cat:edit_title'), $category->title) ?>
			<?php else: ?>
				<?php echo lang('cat:create_title');?>
			<?php endif ?>
		</h1>
	</section>


	<!-- .panel -->
	<section class="panel">
	
		<!-- .panel-content -->
		<div class="panel-content">


			<?php echo form_open($this->uri->uri_string(), 'class="crud'.((isset($mode)) ? ' '.$mode : '').'" id="categories"') ?>

			<div class="form_inputs">

				<ul>
					<li class="even">
						<label for="title"><?php echo lang('global:title') ?> <span>*</span></label>
						<div class="input"><?php echo form_input('title', $category->title) ?></div>
						<label for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>
						<div class="input"><?php echo form_input('slug', $category->slug) ?></div>
						<?php echo form_hidden('id', $category->id) ?>
					</li>
				</ul>

			</div>

			<div class="panel-footer">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>

			<?php echo form_close() ?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>