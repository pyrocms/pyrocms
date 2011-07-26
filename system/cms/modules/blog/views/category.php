<h2 id="page_title"><?php echo $category->title; ?></h2>
<?php if (!empty($blog)): ?>
<?php foreach ($blog as $post): ?>
	<div class="blog_post">
		<!-- Post heading -->
		<div class="post_heading">
			<h2><?php echo  anchor('blog/' .date('Y/m', $post->created_on) .'/'. $post->slug, $post->title); ?></h2>
			<p class="post_date"><?php echo lang('blog_posted_label');?>: <?php echo format_date($post->created_on); ?></p>
			<?php if($post->category_slug): ?>
			<p class="post_category">
				<?php echo lang('blog_category_label');?>: <?php echo anchor('blog/category/'.$post->category_slug, $post->category_title);?>
			</p>
			<?php endif; ?>
		</div>
		<div class="post_body">
			<?php echo $post->intro; ?>
		</div>
	</div>
<?php endforeach; ?>

<?php echo $pagination['links']; ?>

<?php else: ?>
	<p><?php echo lang('blog_currently_no_posts');?></p>
<?php endif; ?>