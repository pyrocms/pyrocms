<?php if (isset($category->title)): ?>
	<h2 id="page_title"><?php echo $category->title; ?></h2>

<?php elseif (isset($tag)): ?>
	<h2 id="page_title"><?php echo lang('blog:tagged_label').': '.$tag; ?></h2>

<?php endif; ?>

<?php if ( ! empty($blog)): ?>
<?php foreach ($blog as $post): ?>
	<div class="post">
		<!-- Post heading -->
		<h3><?php echo  anchor('blog/'.date('Y/m/', $post->created_on).$post->slug, $post->title); ?></h3>
		
		<div class="meta">
			<div class="date">
				<?php echo lang('blog:posted_label');?>: 
				<span><?php echo format_date($post->created_on); ?></span>
			</div>
			
			<?php if ($post->category_slug): ?>
			<div class="category">
				<?php echo lang('blog:category_label');?>: 
				<span><?php echo anchor('blog/category/'.$post->category_slug, $post->category_title);?></span>
			</div>
			<?php endif; ?>
			<?php if ($post->keywords): ?>
			<div class="keywords">
				<?php echo lang('blog:tagged_label');?>:
				<?php foreach ($post->keywords as $keyword): ?>
					<span><?php echo anchor('blog/tagged/'.$keyword->name, $keyword->name, 'class="keyword"') ?></span>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>
		<div class="intro">
			<?php echo $post->intro; ?>
		</div>
	</div>
<?php endforeach; ?>

<?php echo $pagination['links']; ?>

<?php else: ?>
	<p><?php echo lang('blog:currently_no_posts');?></p>
<?php endif; ?>