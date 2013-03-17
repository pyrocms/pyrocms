{{ theme:partial name="aside" }}

<article class="single_post">	
	<h5>{{ theme:image file="link.png" }} <?php echo $post[0]["title"]; ?><small><a href="{{ base:url }}blog" title="Back to the blog">&larr; Back</a></small></h5>
			
	<div class="post_date">
		<span class="date">
			{{ theme:image file="date.png" }}
			About <?php $now = time(); $posted = date($post[0]["created_on"]); echo timespan($posted, $now); ?> ago.
		</span>
	</div>
			
	<hr>
	
	<div class="post_body">
		<?php echo $post[0]["body"]; ?>
	</div>
			
	<div class="post_meta">
		<?php if($post[0]["keywords"]) : ?>
			{{ theme:image file="tags.png" }}
			<span class="tags">
				<?php echo $post[0]["keywords"]; ?>
			</span>
		<?php endif; ?>
	</div>
	
	<?php if (Settings::get('enable_comments')): ?>	
		
		<div id="existing-comments">
			<h4><?php echo lang('comments:title') ?></h4>
			<?php echo $this->comments->display() ?>
		</div>		

		
		<?php if ($form_display): ?>
			<?php echo $this->comments->form() ?>
		<?php else: ?>
			<?php echo sprintf(lang('blog:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post[0]['comments_enabled'])))) ?>
		<?php endif ?>
	
	<?php endif; ?>
</article>