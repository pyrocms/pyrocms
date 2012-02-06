<?php if ( ! empty($blog)): ?>
<?php foreach ($blog as $post): ?>
	<div class="blog_post">
		<!-- Post heading -->
		<div class="post_heading">
			<h4><?php echo anchor('blog/' .date('Y/m', $post->created_on) .'/'. $post->slug, $post->title); ?></h4>
			<p class="post_date"><?php echo lang('blog_posted_label');?>: <?php echo format_date($post->created_on); ?></p>
			<?php if ($post->category_slug): ?>
			<p class="post_category">
				<?php echo lang('blog_category_label');?>: <?php echo anchor('blog/category/'.$post->category_slug, $post->category_title);?>
			</p>
			<?php endif; ?>
		</div>
		<?php if($post->keywords): ?>
		<p class="post_keywords">
			<?php echo lang('blog_tagged_label');?>:
			<?php echo $post->keywords; ?>
		</p>
		<?php endif; ?>
		<div class="post_body">
			<?php echo $post->intro; ?>
		</div>
	</div>
<?php endforeach; ?>

<?php else: ?>
	<p><?php echo lang('blog_search_no_posts_found');?></p>
	<?php echo form_open('blog/search');?>
		<?php echo form_input(
			array(
				'name'	=> 'b_keywords',
				'placeholder'	=> 'Press enter to search...',
			));
		?>
	<?php echo form_close(); ?>
<?php endif; ?>