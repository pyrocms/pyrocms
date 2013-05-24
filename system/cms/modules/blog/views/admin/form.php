<section class="content-wrapper">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
		<?php if ($this->method == 'create'): ?>
			<span class="title"><?php echo lang('blog:create_title') ?></span>
		<?php else: ?>
			<span class="title"><?php echo sprintf(lang('blog:edit_title'), $post->title) ?></span>
		<?php endif ?>
		</section>


		<?php echo form_open_multipart() ?>

			
		<!-- .nav-tabs -->
		<ul class="nav nav-tabs form-nav-tabs no-padding-bottom bg grayLightest">

			<li class="active">
				<a href="#blog-content-tab" data-toggle="tab">
					<span><?php echo lang('blog:content_label') ?></span>
				</a>
			</li>

			<?php if ($stream_fields): ?>
			<li>
				<a href="#blog-custom-fields" data-toggle="tab">
					<span><?php echo lang('global:custom_fields') ?></span>
				</a>
			</li>
			<?php endif; ?>

			<li>
				<a href="#blog-options-tab" data-toggle="tab">
					<span><?php echo lang('blog:options_label') ?></span>
				</a>
			</li>

		</ul>
		<!-- /.nav-tabs -->


		<!-- .tab-content -->
		<div class="tab-content">

			<!-- Content tab -->
			<div class="tab-pane active" id="blog-content-tab">
				<fieldset>
					<ul>
						<li class="row-fluid input-row">
							<label class="span3" for="title"><?php echo lang('global:title') ?> <span>*</span></label>
							<div class="input span9"><?php echo form_input('title', htmlspecialchars_decode($post->title), 'maxlength="100" id="title"') ?></div>
						</li>
			
						<li class="row-fluid input-row">
							<label class="span3" for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>
							<div class="input span9"><?php echo form_input('slug', $post->slug, 'maxlength="100" class="width-20"') ?></div>
						</li>
			
						<li class="row-fluid input-row">
							<label class="span3" for="status"><?php echo lang('blog:status_label') ?></label>
							<div class="input span9"><?php echo form_dropdown('status', array('draft' => lang('blog:draft_label'), 'live' => lang('blog:live_label')), $post->status) ?></div>
						</li>
				
						<li class="row-fluid input-row">
							<label for="body"><?php echo lang('blog:content_label') ?> <span>*</span></label>
							<div>
								<?php echo form_dropdown('type', array(
									'html' => 'html',
									'markdown' => 'markdown',
									'wysiwyg-simple' => 'wysiwyg-simple',
									'wysiwyg-advanced' => 'wysiwyg-advanced',
								), $post->type, 'class="skip inline"') ?>
							</div>
			
							<div>
								<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 30, 'class' => $post->type)) ?>
							</div>
						</li>

					</ul>
				<?php echo form_hidden('preview_hash', $post->preview_hash)?>
				</fieldset>
			</div>


			<?php if ($stream_fields): ?>

			<div class="tab-pane" id="blog-custom-fields">
				<fieldset>
					<ul>

						<?php foreach ($stream_fields as $field) echo $this->load->view('admin/partials/streams/form_single_display', array('field' => $field), true) ?>

					</ul>
				</fieldset>
			</div>

			<?php endif; ?>


			<!-- Options tab -->
			<div class="tab-pane" id="blog-options-tab">
				<fieldset>
					<ul>
			
						<li class="row-fluid input-row">
							<label class="span3" for="category_id"><?php echo lang('blog:category_label') ?></label>
							<div class="input span9">
								<?php echo form_dropdown('category_id', array(lang('blog:no_category_select_label')) + $categories, @$post->category_id) ?>
							</div>
						</li>
			
						<?php if ( ! module_enabled('keywords')): ?>
							<?php echo form_hidden('keywords'); ?>
						<?php else: ?>
							<li class="row-fluid input-row">
								<label class="span3" for="keywords"><?php echo lang('global:keywords') ?></label>
								<div class="input span9"><?php echo form_input('keywords', $post->keywords, 'id="keywords"') ?></div>
							</li>
						<?php endif; ?>
			
						<li class="row-fluid input-row">
							<label class="span3"><?php echo lang('blog:date_label') ?></label>
			
							<div class="input span9">
								<div class="input-append date">
									<?php echo form_input('created_on', date('m/d/Y', $post->created_on), 'class="input-small" maxlength="10" id="datepicker" data-toggle="datepicker"') ?>
									<span class="add-on"><i class="icon-calendar"></i></span>
								</div>
								<?php echo form_dropdown('created_on_hour', $hours, date('H', $post->created_on), 'class="skip input-small"') ?> :
								<?php echo form_dropdown('created_on_minute', $minutes, date('i', ltrim($post->created_on, '0')), 'class="skip input-small"') ?>
							</div>
						</li>
			
						<?php if ( ! module_enabled('comments')): ?>
							<?php echo form_hidden('comments_enabled', 'no'); ?>
						<?php else: ?>
							<li class="row-fluid input-row">
								<label class="span3" for="comments_enabled"><?php echo lang('blog:comments_enabled_label');?></label>
								<div class="input span9">
									<?php echo form_dropdown('comments_enabled', array(
										'no' => lang('global:no'),
										'1 day' => lang('global:duration:1-day'),
										'1 week' => lang('global:duration:1-week'),
										'2 weeks' => lang('global:duration:2-weeks'),
										'1 month' => lang('global:duration:1-month'),
										'3 months' => lang('global:duration:3-months'),
										'always' => lang('global:duration:always'),
									), $post->comments_enabled ? $post->comments_enabled : '3 months') ?>
								</div>
							</li>
						<?php endif; ?>
					</ul>
				</fieldset>
			</div>

		</div>
		<!-- /.tab-content -->

		<input type="hidden" name="row_edit_id" value="<?php if ($this->method != 'create'): echo $post->id; endif; ?>" />

		<div class="btn-group form-btn-group">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
		</div>

	<?php echo form_close() ?>

	</section>


</div>
</section>