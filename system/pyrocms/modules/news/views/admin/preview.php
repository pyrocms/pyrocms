<h1><?php echo $article->title; ?></h1>

<p style="float:left; width: 40%;">
	<?php echo anchor('news/' .date('Y/m', $article->created_on) .'/'. $article->slug, NULL, 'target="_blank"'); ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
	<?php echo anchor('admin/news/edit/'. $article->id, lang('news_edit_label'), ' target="_parent"'); ?>
</p>

<iframe src="<?php echo site_url('news/' .date('Y/m', $article->created_on) .'/'. $article->slug); ?>" width="99%" height="480"></iframe>