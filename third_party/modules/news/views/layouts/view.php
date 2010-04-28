<h2><?php echo $article->title; ?></h2>
<?php if($article->category->slug): ?>
	<p><?php echo lang('news_posted_label'); ?> <?php echo anchor('news/category/'.$article->category->slug, $article->category->title); ?> <?php echo lang('news_date_at'); ?> <?php echo date('M d, Y', $article->created_on); ?></p>
<?php else: ?>
	<p><?php echo lang('news_posted_label_alt'); ?> <?php echo date('M d, Y', $article->created_on); ?></p>
<?php endif; ?>

<?php echo $template['module_body']; ?>
<?php
if( $this->settings->item('enable_social_bookmarks'))
{
	echo $this->load->view('fragments/social_bookmarking/toolbar', array('bookmark' => array('title' => $article->title)));
}
?>
<?php echo display_comments($article->id); ?>