<article id="single_post">
	<h2><?php echo $post->title; ?></h2>	
	<div id="post_date">
		<?php echo date('M d, Y',$post->created_on); ?> by <a href="/users/profile/<?php echo $post->author_id; ?>"><?php echo $post->display_name; ?></a>
	</div>
	<div id="post_body"><?php echo $post->body; ?></div>
	<div id="post_meta">
		<span class="tags">
		    <?php if($post->keywords) : ?>
		    	<?php foreach ($post->keywords as $keyword): if ($keyword->name!='featured'): ?>
		    	<span><?php echo anchor(($this->config->item('blog_uri')!=null? $this->config->item('blog_uri').'/':null).'tagged/'.$keyword->name, $keyword->name, 'class="keyword"') ?></span>
		    	<?php endif; endforeach; ?>
		    <?php endif; ?>
		</span>
	</div>			
	<?php if ($post->comments_enabled): ?>
		<?php echo display_comments($post->id); ?>
	<?php endif; ?>
</article>