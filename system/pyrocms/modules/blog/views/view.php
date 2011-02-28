<div class="blog_article">
	<!-- Article heading -->
	<div class="article_heading">
		<h2><?php echo $article->title; ?></h2>
		<p class="article_date"><?php echo lang('blog_posted_label');?>: <?php echo format_date($article->created_on); ?></p>
		<?php if($article->category->slug): ?>
		<p class="article_category">
			<?php echo lang('blog_category_label');?>: <?php echo anchor('blog/category/'.$article->category->slug, $article->category->title);?>
		</p>
		<?php endif; ?>
	</div>
	<div class="article_body">
		<?php echo stripslashes($article->body); ?>
	</div>
</div>
<?php echo display_comments($article->id); ?>
