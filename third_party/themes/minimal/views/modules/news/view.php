<div class="news_article">
	<!-- Article heading -->
	<div class="article_heading clearfix">
		<h2><?php echo  anchor('news/' .date('Y/m', $article->created_on) .'/'. $article->slug, $article->title); ?></h2>
		<p class="article_date"><?php echo lang('news_posted_label');?>: <?php echo date('M d, Y', $article->created_on); ?></p>
		<?php if($article->category->slug): ?>
		<p class="article_category">
			<?php echo lang('news_category_label');?>: <?php echo anchor('news/category/'.$article->category->slug, $article->category->title);?>
		</p>
		<?php endif; ?>
	</div>
	<?php echo stripslashes($article->body); ?>
</div>
<?php echo display_comments($article->id); ?>
