<h1><?php echo $article->title; ?></h1>

<p><?php echo anchor('news/' .date('Y/m', $article->created_on) .'/'. $article->slug, NULL, 'target="_blank"'); ?></p>

<iframe src="<?php echo site_url('news/' .date('Y/m', $article->created_on) .'/'. $article->slug); ?>" width="99%" height="480"></iframe>