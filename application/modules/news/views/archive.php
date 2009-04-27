<h2>Archive</h3>

<h3><?=$month_year;?></h3>

<div class="float-left width-two-thirds">

	<? if (!empty($news)): ?>
	
		<? foreach ($news as $article): ?>
			<h3><?=  anchor('news/' .date('Y/m', $article->created_on) .'/'. $article->slug, $article->title); ?></h3>
			
			<p><?= nl2br($article->intro) ?> <?= anchor('news/' .date('Y/m', $article->created_on) .'/'. $article->slug, 'Read More&nbsp;&raquo;')?></p>
			
			<p>
				<em>Posted: <?= date('M d, Y', $article->created_on); ?></em>&nbsp;
				
				<? if($article->category_slug): ?>
				<em>Category: <?=anchor('news/category/'.$article->category_slug, $article->category_title);?></em>
				<? endif; ?>
			</p>
			
			<hr/>
		<? endforeach; ?>
		
		<p><?=$pagination['links']; ?></p>
		
	<? else: ?>
		<p>There are no articles at the moment.</p>
	<? endif; ?>

</div>

<div class="float-right width-quater">

	<? $this->load->view('fragments/rss_box') ?>
	
	<hr />
	
	<? $this->load->view('fragments/archive_box') ?>
	
</div>