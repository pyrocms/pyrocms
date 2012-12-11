<div class="post">

	<h3><?php echo $post->title ?></h3>

	<div class="meta">
		<div class="date"><?php echo lang('blog:posted_label');?>: <span><?php echo format_date($post->created_on) ?></span></div>
		
		<?php if (isset($post->display_name)): ?>
		<div class="author">
			<?php echo lang('blog:written_by_label') ?>: 
			<span><?php echo anchor('user/' . $post->username, $post->display_name) ?></span>
		</div>
		<?php endif ?>

		<?php if ($post->category->slug): ?>
		<div class="category">
			<?php echo lang('blog:category_label');?>: 
			<span><?php echo anchor('blog/category/'.$post->category->slug, $post->category->title);?></span>
		</div>
		<?php endif ?>
		<?php if ($post->keywords): ?>
		<div class="keywords">
			<?php echo lang('blog:tagged_label');?>:
			<?php foreach ($post->keywords as $keyword): ?>
				<span><?php echo anchor('blog/tagged/'.$keyword->name, $keyword->name, 'class="keyword"') ?></span>
			<?php endforeach ?>
		</div>
		<?php endif ?>
	</div>

	<div class="body">
		<?php echo $post->body ?>
	</div>
	
</div>

<?php if (Settings::get('enable_comments')): ?>

<div id="comments">
	
	<div id="existing-comments">
		
		<h4><?php echo lang('comments:title') ?></h4>

		<?php echo $this->comments->display() ?>

	</div>

	<?php if ($form_display): ?>

		<?php echo $this->comments->form() ?>

	<?php else: ?>

		<?php echo sprintf(lang('blog:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post->comments_enabled)))) ?>

	<?php endif ?>

</div>

<?php endif ?>