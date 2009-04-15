<h2 class="spacer-top-none"><?= $article->title; ?></h2>

<p>
	<strong>Posted:</strong> <?= date('M d, Y', $article->created_on); ?><br/>
		
	<? if($article->category_slug): ?>
	<strong>Category:</strong> <?=anchor('news/category/'.$article->category_slug, $article->category_title);?>
	<? endif; ?>
</p>

<hr/>

<? if ($article->attachment): ?>
	<img src="/uploads/news/<?=$article->slug;?>/<?=$article->attachment;?>" class="left">
<? endif; ?>

<p><em><?=$article->intro;?></em></p>

<p><?=$article->body;?></p>