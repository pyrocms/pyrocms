<div class="p">


	<!-- .panel -->
	<section class="panel panel-default">


		<div class="panel-heading">
			<h3 class="panel-title">
				<?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
					<?php echo sprintf(lang('cat:edit_title'), $category->title) ?>
				<?php else: ?>
					<?php echo lang('cat:create_title');?>
				<?php endif ?>
			</h3>
		</div>

		
		<?php echo form_open($this->uri->uri_string(), 'class="crud'.((isset($mode)) ? ' '.$mode : '').'" id="categories"') ?>

			<!-- .panel-body -->
			<div class="panel-body">
				
				<div class="form-group">
				<div class="row">
					
					<label class="col-lg-2" for="title"><?php echo lang('global:title') ?> <span>*</span></label>

					<div class="col-lg-10">
						<?php echo form_input('title', $category->title, 'class="form-control"') ?>
					</div>

				</div>
				</div>

				
				<div class="form-group">
				<div class="row">
					
					<label class="col-lg-2" for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>

					<div class="col-lg-10">
						<?php echo form_input('slug', $category->slug, 'class="form-control"') ?>
					</div>

				</div>
				</div>

				
				<?php echo form_hidden('id', $category->id) ?>

			</div>
			<!-- /.panel-body -->

				
			<div class="panel-footer">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>

		<?php echo form_close() ?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>