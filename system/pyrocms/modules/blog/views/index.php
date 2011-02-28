<?php if (!empty($blog)): ?>
<?php foreach ($blog as $article): ?>
	<div class="blog_article">
		<!-- Article heading -->
		<div class="article_heading">
			<h2><?php echo  anchor('blog/' .date('Y/m', $article->created_on) .'/'. $article->slug, $article->title); ?></h2>
			<p class="article_date"><?php echo lang('blog_posted_label');?>: <?php echo format_date($article->created_on); ?></p>
			<?php if($article->category_slug): ?>
			<p class="article_category">
				<?php echo lang('blog_category_label');?>: <?php echo anchor('blog/category/'.$article->category_slug, $article->category_title);?>
			</p>
			<?php endif; ?>
		</div>
		<div class="article_body">
			<?php echo stripslashes($article->intro); ?>
		</div>
	</div>
<?php endforeach; ?>

<?php echo $pagination['links']; ?>

<?php else: ?>
	<p><?php echo lang('blog_currently_no_articles');?></p>
<?php endif; ?>