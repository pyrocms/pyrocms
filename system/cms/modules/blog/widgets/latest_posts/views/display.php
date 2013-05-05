<section class="widget latest_posts">
	
	<?php if ( empty ($blog_widget)): ?>
	<h4 class="widget-title">{{ helper:lang line="blog:currently_no_posts" }}</h4>
<?php endif ?>
	
	<?php foreach($blog_widget as $post_widget): ?>
		<article class="post">
			<h4 class="widget-title"><?php echo anchor('blog/'.date('Y/m', $post_widget->created_on) .'/'.$post_widget->slug, $post_widget->title) ?></h4>
			<p class="widget-date">[<?php echo date('F d Y', $post_widget->created_on); ?>]</p>
			<p class="preview"><?php echo $post_widget->body ?>&hellip; <?php echo anchor('blog/'.date('Y/m', $post_widget->created_on) .'/'.$post_widget->slug, "Read More") ?></p>
		</article>
	<?php endforeach ?>
</section>