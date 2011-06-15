<div class="blog_post">
	<!-- Post heading -->
	<div class="post_heading">
		<h2><?php echo $post->title; ?></h2>
		<?php if ($post->author): ?>
		<p class="author"><?php echo lang('blog_written_by_label'); ?>: <?php echo anchor('user/' . $post->author_id, $post->author->display_name); ?></p>
		<?php endif; ?>
		<p class="post_date"><span class="post_date_label"><?php echo lang('blog_posted_label');?>: </span><?php echo format_date($post->created_on); ?></p>
		<?php if($post->category->slug): ?>
		<p class="post_category">
			<?php echo lang('blog_category_label');?>: <?php echo anchor('blog/category/'.$post->category->slug, $post->category->title);?>
		</p>
		<?php endif; ?>
	</div>
	<div class="post_body">
		<?php echo $post->body; ?>
	</div>
</div>

<?php if ($post->comments_enabled): ?>
	<?php echo display_comments($post->id); ?>
<?php endif; ?>