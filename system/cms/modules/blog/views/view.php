<div class="blog:post">
	<!-- Post heading -->
	<div class="post_heading">
		<h4><?php echo $post->title; ?></h4>
		<?php if (isset($post->display_name)): ?>
		<p class="author"><?php echo lang('blog:written_by_label'); ?>: <?php echo anchor('user/' . $post->author_id, $post->display_name); ?></p>
		<?php endif; ?>
		<p class="post_date"><span class="post_date_label"><?php echo lang('blog:posted_label');?>: </span><?php echo format_date($post->created_on); ?></p>
		<?php if($post->category->slug): ?>
		<p class="post_category">
			<?php echo lang('blog:category_label');?>: <?php echo anchor('blog/category/'.$post->category->slug, $post->category->title);?>
		</p>
		<?php endif; ?>
	</div>
	<?php if($post->keywords): ?>
	<p class="post_keywords">
		<?php echo lang('blog:tagged_label');?>:
		<?php echo $post->keywords; ?>
	</p>
	<?php endif; ?>
	<div class="post_body">
		<?php echo $post->body; ?>
	</div>
</div>

<?php if ($post->comments_enabled): ?>
	<?php echo display_comments($post->id); ?>
<?php endif; ?>