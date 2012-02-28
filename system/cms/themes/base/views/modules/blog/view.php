{{ theme:partial name="aside" }}

<article class="single_post">	
	<h5>{{ theme:image file="link.png" }} <?php echo $post->title; ?><small><a href="{{ base:url }}blog" title="Back to the blog">&larr; Back</a></small></h5>
			
	<div class="post_date">
		<span class="date">
			{{ theme:image file="date.png" }}
			About <?php $now = time(); $posted = date($post->created_on); echo timespan($posted, $now); ?> ago.
		</span>
	</div>
			
	<hr>
	
	<div class="post_body">
		<?php echo $post->body; ?>
	</div>
			
	<div class="post_meta">
		<?php if($post->keywords) : ?>
			{{ theme:image file="tags.png" }}
			<span class="tags">
				<?php echo $post->keywords; ?>
			</span>
		<?php endif; ?>
	</div>			

	<?php if ($post->comments_enabled): ?>
		<?php echo display_comments($post->id); ?>
	<?php endif; ?>
</article>