<h2><?php echo $article->title; ?></h2>

<?php if($article->category->slug): ?>
	<p><?php echo lang('news_posted_label'); ?> <?php echo anchor('news/category/'.$article->category->slug, $article->category->title); ?> <?php echo lang('news_date_at'); ?> <?php echo date('M d, Y', $article->created_on); ?></p>
<?php else: ?>
	<p><?php echo lang('news_posted_label_alt'); ?> <?php echo date('M d, Y', $article->created_on); ?></p>
<?php endif; ?>

<?php echo stripslashes($article->body); ?>

<?php
if( $this->settings->item('enable_social_bookmarks'))
{
	echo $this->load->view('fragments/social_bookmarking/toolbar', array('bookmark' => array('title' => $article->title)));
}		
?>

<div class="comments">
	<?php echo $this->load->view('comments/comments', array('module' => $this->module, 'module_id' => $article->id)); ?>	
</div>