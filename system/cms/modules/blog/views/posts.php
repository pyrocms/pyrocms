<?php if ( !empty($blog) ): ?>
	
	<?php foreach ($blog as $post) : ?>

		<article class="post<?php echo ($post->relevance=='featured')? ' featured':null; ?>">
			<a href="<?php echo $post->url; ?>" title="<?php echo $post->title; ?>">
				<h5> <?php echo $post->title; ?></h5>
			</a>
			<div class="post_date">
				<span class="date">
					<?php echo date('M d, Y',$post->created_on); ?>
				</span>
			</div>		
			<div class="post_intro">
				<?php echo $post->featured_image; ?>
				<?php echo $post->intro; ?>
			</div>
			<div class="post_meta">
			    <span class="tags">
			        <?php if($post->keywords) : ?>
			        	<?php foreach ($post->keywords as $keyword):  ?>
			        	<span><?php echo anchor(($this->config->item('blog_uri')!=null? $this->config->item('blog_uri').'/':null).'tagged/'.$keyword->name, $keyword->name, 'class="keyword"') ?></span>
			        	<?php endforeach; ?>
			        <?php endif; ?>
			    </span>
			</div>	
		</article>

	<?php endforeach; ?>
	
	<?php  echo $pagination['links']; ?>

<?php else: ?>
	<p><?php echo lang('blog_currently_no_posts');?></p>
<?php endif; ?>