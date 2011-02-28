<ul class="navigation">
	<?php foreach($blog_widget as $article_widget): ?>
		<li><?php echo anchor('blog/'.date('Y/m', $article_widget->created_on) .'/'.$article_widget->slug, $article_widget->title); ?></li>
	<?php endforeach; ?>
</ul>