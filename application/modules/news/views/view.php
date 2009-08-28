<? $this->load->helper('typography'); ?>
<h2><?= $article->title; ?></h2>
<p>
	<strong><?=lang('news_posted_label');?>:</strong> <?= date('M d, Y', $article->created_on); ?><br/>		
	<? if($article->category_slug): ?>
		<strong><?=lang('news_category_label');?>:</strong> <?=anchor('news/category/'.$article->category_slug, $article->category_title);?>
	<? endif; ?>
</p>
<hr/>
<?=stripslashes($article->body);?> 
<hr/>
<?php if( $this->settings->item('enable_social_bookmarks')): ?>
<?= $this->load->view('fragments/social_bookmarking/toolbar', array('bookmark' => array('title' => $article->title))); ?>
<hr/>
<?php endif; ?>

<h3><?=lang('news_comments_title');?></h3>
    
<fieldset class="alternative float-left width-half">
	<legend><?=lang('news_other_comments_label');?></legend>
	<?= $this->load->module_view('comments', 'comments', array('comments' => $this->comments_m->getComments(array('module' => $this->module, 'module_id' => $article->id, 'is_active' => 1)))); ?>
</fieldset>
                
<fieldset class="float-right width-half">
	<legend><?=lang('news_your_comments_label');?></legend>
	<?= $this->load->module_view('comments', 'form', array('module'=>$this->module, 'id' => $article->id)); ?> 
</fieldset>
