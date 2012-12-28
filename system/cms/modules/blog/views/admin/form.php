<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('blog:create_title') ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('blog:edit_title'), $post->title) ?></h4>
<?php endif ?>
</section>

<section class="item">
<div class="content">

<?php echo form_open_multipart() ?>

<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#blog-content-tab"><span><?php echo lang('blog:content_label') ?></span></a></li>
		<li><a href="#blog-options-tab"><span><?php echo lang('blog:options_label') ?></span></a></li>
	</ul>

	<!-- Content tab -->
	<div class="form_inputs" id="blog-content-tab">
		<hr style="margin-top:5px;">

		<ul>
			<li>
				<label for="title"><?php echo lang('global:title') ?> <span>*</span></label>
				<div class="input"><?php echo form_input('title', htmlspecialchars_decode($post->title), 'maxlength="100" id="title"') ?></div>
			</li>

			<li>
				<label for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>
				<div class="input"><?php echo form_input('slug', $post->slug, 'maxlength="100" class="width-20"') ?></div>
			</li>

			<li>
				<label for="intro"><?php echo lang('blog:intro_label') ?></label>
				<div class="one_full">
					<?php echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $post->intro, 'rows' => 5, 'class' => 'blog wysiwyg-simple')) ?>
				</div>
			</li>

			<li class="editor clearfix">
				<label for="body"><?php echo lang('blog:content_label') ?></label>
				<div class="input small-side">
					<?php echo form_dropdown('type', array(
						'html' => 'html',
						'markdown' => 'markdown',
						'wysiwyg-simple' => 'wysiwyg-simple',
						'wysiwyg-advanced' => 'wysiwyg-advanced',
					), $post->type) ?>
				</div>

				<div class="one_full">
					<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 30, 'class' => $post->type)) ?>
				</div>
			</li>
		</ul>
	<?php echo form_hidden('preview_hash',$post->preview_hash)?>

	</div>

	<!-- Options tab -->
	<div class="form_inputs" id="blog-options-tab">
		<hr style="margin-top:5px;">

		<ul>

			<li>
				<label for="status"><?php echo lang('blog:status_label') ?></label>
				<div class="input"><?php echo form_dropdown('status', array('draft' => lang('blog:draft_label'), 'live' => lang('blog:live_label')), $post->status) ?></div>
			</li>

			<li>
				<label for="category_id"><?php echo lang('blog:category_label') ?></label>
				<div class="input">
				<?php echo form_dropdown('category_id', array(lang('blog:no_category_select_label')) + $categories, @$post->category_id) ?>
					[ <a id="new-category" href="<?php echo site_url('admin/blog/categories/create') ?>" target="_blank"><?php echo lang('blog:new_category_label') ?></a> ]
				</div>
			</li>

			<li>
				<label for="keywords"><?php echo lang('global:keywords') ?></label>
				<div class="input"><?php echo form_input('keywords', $post->keywords, 'id="keywords"') ?></div>
			</li>

			<li class="date-meta">
				<label><?php echo lang('blog:date_label') ?></label>

				<div class="input datetime_input">
				<?php echo form_input('created_on', date('Y-m-d', $post->created_on), 'maxlength="10" id="datepicker" class="text width-20"') ?> &nbsp;
				<?php echo form_dropdown('created_on_hour', $hours, date('H', $post->created_on)) ?> :
				<?php echo form_dropdown('created_on_minute', $minutes, date('i', ltrim($post->created_on, '0'))) ?>

				</div>
			</li>

			<li>
				<label for="comments_enabled"><?php echo lang('blog:comments_enabled_label');?></label>
				<div class="input">
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
		</ul>

	</div>

</div>

<div class="buttons">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
</div>

<?php echo form_close() ?>

</div>
</section>
