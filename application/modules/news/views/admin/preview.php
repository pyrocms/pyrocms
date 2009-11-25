<h2 class="spacer-top-none"><?php echo $article->title; ?></h2>
<p>
	<strong><?php echo lang('news_posted_label');?>:</strong> <?php echo date('M d, Y', $article->created_on); ?><br/>		
	<?php if($article->category_slug): ?>
		<strong><?php echo lang('news_category_label');?>:</strong> <?php echo anchor('news/category/'.$article->category_slug, $article->category_title);?>
	<?php endif; ?>
</p>
<hr/>

<?php if ($article->attachment): ?>
	<img src="/uploads/news/<?php echo $article->slug;?>/<?php echo $article->attachment;?>" class="left">
<?php endif; ?>

<p><em><?php echo $article->intro;?></em></p>

<?php echo stripslashes($article->body);?> 