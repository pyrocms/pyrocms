<?php if ($this->method == 'create'): ?>
	<h3><?php echo lang('blog_create_title'); ?></h3>
<?php else: ?>
		<h3><?php echo sprintf(lang('blog_edit_title'), $post->title); ?></h3>
<?php endif; ?>

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#blog-content-tab"><span><?php echo lang('blog_content_label'); ?></span></a></li>
		<li><a href="#blog-options-tab"><span><?php echo lang('blog_options_label'); ?></span></a></li>
	</ul>

	<!-- Content tab -->
	<div id="blog-content-tab">
		<ol>
			<li class="even">
				<label for="title"><?php echo lang('blog_title_label'); ?></label>
				<?php echo form_input('title', htmlspecialchars_decode($post->title), 'maxlength="100"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>
			<li>
				<label for="slug"><?php echo lang('blog_slug_label'); ?></label>
				<?php echo form_input('slug', $post->slug, 'maxlength="100" class="width-20"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>
			<li class="even">
				<label for="status"><?php echo lang('blog_status_label'); ?></label>
				<?php echo form_dropdown('status', array('draft' => lang('blog_draft_label'), 'live' => lang('blog_live_label')), $post->status) ?>
			</li>
			<li>
				<label for="intro"><?php echo lang('blog_intro_label'); ?></label>
				<?php echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $post->intro, 'rows' => 5, 'class' => 'wysiwyg-simple')); ?>
			</li>
			<li class="even">
				<label for="body"><?php echo lang('blog_content_label'); ?></label>
				<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 50, 'class' => 'wysiwyg-advanced')); ?>
			</li>
	
		</ol>
	</div>

	<!-- Options tab -->
	<div id="blog-options-tab">
		<ol>
			<li>
				<label for="category_id"><?php echo lang('blog_category_label'); ?></label>
				<?php echo form_dropdown('category_id', array(lang('blog_no_category_select_label')) + $categories, @$post->category_id) ?>
					[ <?php echo anchor('admin/blog/categories/create', lang('blog_new_category_label'), 'target="_blank"'); ?> ]
			</li>
			<li class="even date-meta">
				<label><?php echo lang('blog_date_label'); ?></label>
				<div style="float:left;">
					<?php echo form_input('created_on', date('Y-m-d', $post->created_on), 'maxlength="10" id="datepicker" class="text width-20"'); ?>
				</div>
				<label class="time-meta"><?php echo lang('blog_time_label'); ?></label>
				<?php echo form_dropdown('created_on_hour', $hours, date('H', $post->created_on)) ?>
				<?php echo form_dropdown('created_on_minute', $minutes, date('i', ltrim($post->created_on, '0'))) ?>
			</li>
			<li>
				<label for="comments_enabled"><?php echo lang('blog_comments_enabled_label');?></label>
				<?php echo form_checkbox('comments_enabled', 1, $post->comments_enabled == 1); ?>
			</li>
		</ol>
	</div>

</div>

<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>