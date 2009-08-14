<h2 class="spacer-top-none"><?= $article->title; ?></h2>
<p>
	<strong><?=lang('news_posted_label');?>:</strong> <?= date('M d, Y', $article->created_on); ?><br/>		
	<? if($article->category_slug): ?>
		<strong><?=lang('news_category_label');?>:</strong> <?=anchor('news/category/'.$article->category_slug, $article->category_title);?>
	<? endif; ?>
</p>
<hr/>

<? if ($article->attachment): ?>
	<img src="/uploads/news/<?=$article->slug;?>/<?=$article->attachment;?>" class="left">
<? endif; ?>

<p><em><?=$article->intro;?></em></p>

<?=stripslashes($article->body);?> 