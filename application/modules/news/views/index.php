<h2><?php echo lang('news_articles_title');?></h2>
<div class="float-left width-two-thirds">
	<?php if (!empty($news)): ?>	
		<?php foreach ($news as $article): ?>
			<h3><?php echo  anchor('news/' .date('Y/m', $article->created_on) .'/'. $article->slug, $article->title); ?></h3>			
			<p><?php echo nl2br($article->intro) ?> <?php echo anchor('news/' .date('Y/m', $article->created_on) .'/'. $article->slug, lang('news_read_more_label'))?></p>
			<p>
				<em><?php echo lang('news_posted_label');?>: <?php echo date('M d, Y', $article->created_on); ?></em>&nbsp;				
				<?php if($article->category_slug): ?>
					<em><?php echo lang('news_category_label');?>: <?php echo anchor('news/category/'.$article->category_slug, $article->category_title);?></em>
				<?php endif; ?>
			</p>			
			<hr/>
		<?php endforeach; ?>		
		<p><?php echo $pagination['links']; ?></p>		
	<?php else: ?>
		<p><?php echo lang('news_currently_no_articles');?></p>
	<?php endif; ?>
</div>

<div class="float-right width-quater">
	<?php $this->load->view('fragments/rss_box') ?>	
	<hr />	
	<?php $this->load->view('fragments/archive_box') ?>	
</div>