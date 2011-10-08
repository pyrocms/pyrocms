<section class="title">
<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('blog_create_title'); ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('blog_edit_title'), $post->title); ?></h4>
<?php endif; ?>
</section>

<section class="item">
	
<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#blog-content-tab"><span><?php echo lang('blog_content_label'); ?></span></a></li>
		<li><a href="#blog-options-tab"><span><?php echo lang('blog_options_label'); ?></span></a></li>
	</ul>
	
	<hr>
	
	<!-- Content tab -->
	<div id="blog-content-tab">
		<ul>
			<li class="even">
				<label for="title"><?php echo lang('blog_title_label'); ?></label><br>
				<?php echo form_input('title', htmlspecialchars_decode($post->title), 'maxlength="100"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>
			
			<hr>
			
			<li>
				<label for="slug"><?php echo lang('blog_slug_label'); ?></label><br>
				<?php echo form_input('slug', $post->slug, 'maxlength="100" class="width-20"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
			</li>
			
			<hr>
			
			<li class="even">
				<label for="status"><?php echo lang('blog_status_label'); ?></label><br>
				<?php echo form_dropdown('status', array('draft' => lang('blog_draft_label'), 'live' => lang('blog_live_label')), $post->status) ?>
			</li>
			
			<hr>
			
			<li>
				<label for="intro"><?php echo lang('blog_intro_label'); ?></label><br>
				<?php echo form_textarea(array('id' => 'intro', 'name' => 'intro', 'value' => $post->intro, 'rows' => 5, 'class' => 'wysiwyg-simple')); ?>
			</li>
			
			<hr>
			
			<li class="even editor">
				<label for="body"><?php echo lang('blog_content_label'); ?></label><br>
				
				<?php echo form_dropdown('type', array(
					'html' => 'html',
					'markdown' => 'markdown',
					'wysiwyg-simple' => 'wysiwyg-simple',
					'wysiwyg-advanced' => 'wysiwyg-advanced',
				), $post->type); ?>
				
				<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 50, 'class' => $post->type)); ?>
			</li>
			
		</ul>
	</div>

	<!-- Options tab -->
	<div id="blog-options-tab">
		<ul>
			<li>
				<label for="category_id"><?php echo lang('blog_category_label'); ?></label><br>
				<?php echo form_dropdown('category_id', array(lang('blog_no_category_select_label')) + $categories, @$post->category_id) ?>
					[ <?php echo anchor('admin/blog/categories/create', lang('blog_new_category_label'), 'target="_blank"'); ?> ]
			</li>
			
			<hr>
			
			<li class="even">
				<label for="keywords"><?php echo lang('global:keywords'); ?></label><br>
				<?php echo form_input('keywords', $post->keywords) ?>
			</li>
			
			<hr>
			
			<li class="date-meta">
				<label><?php echo lang('blog_date_label'); ?></label><br>
				
				<div style="float:left;">
					<?php echo form_input('created_on', date('Y-m-d', $post->created_on), 'maxlength="10" id="datepicker" class="text width-20"'); ?> &nbsp;
				</div>
				
				<label class="time-meta"><?php echo lang('blog_time_label'); ?></label>
				<?php echo form_dropdown('created_on_hour', $hours, date('H', $post->created_on), 'style="width:4em;"') ?>
				<?php echo form_dropdown('created_on_minute', $minutes, date('i', ltrim($post->created_on, '0'))) ?>
			</li>
			
			<hr>
			
			<li class="even">
				<label for="comments_enabled"><?php echo lang('blog_comments_enabled_label');?></label>
				<?php echo form_checkbox('comments_enabled', 1, ($this->method == 'create' && ! $_POST) or $post->comments_enabled == 1); ?>
			</li>
		</ul>
	</div>

</div>

<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>

<style type="text/css">
form.crudli.date-meta div.selector {
    float: left;
    width: 30px;
}
form.crud li.date-meta div input#datepicker { width: 8em; }
form.crud li.date-meta div.selector { width: 5em; }
form.crud li.date-meta div.selector span { width: 1em; }
form.crud li.date-meta label.time-meta { min-width: 4em; width:4em; }
</style>