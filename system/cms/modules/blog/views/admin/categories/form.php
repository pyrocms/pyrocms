<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title">

				<?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
					<?php echo sprintf(lang('cat:edit_title'), $category->title);?>
				<?php else: ?>
					<?php echo lang('cat:create_title');?>
				<?php endif ?>

			</span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php echo form_open($this->uri->uri_string(), 'class="crud'.((isset($mode)) ? ' '.$mode : '').'" id="categories"') ?>

				<fieldset class="padding-top">

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

				</fieldset>

				<div class="padded no-padding-bottom btn-group">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
				</div>

			<?php echo form_close() ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>