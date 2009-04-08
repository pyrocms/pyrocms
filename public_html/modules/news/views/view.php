
<? $this->load->helper('typography'); ?>

	<h2><?= $article->title; ?></h2>
	
	<p>
		<strong>Posted:</strong> <?= date('M d, Y', $article->created_on); ?><br/>
			
		<? if($article->category_slug): ?>
		<strong>Category:</strong> <?=anchor('news/category/'.$article->category_slug, $article->category_title);?>
		<? endif; ?>
	</p>
	
	<hr/>
	
	<? if ($article->attachment): ?>
		<img src="/uploads/news/<?=$article->slug;?>/<?=$article->attachment;?>" class="left">
	<? endif; ?>
	
	<p><em><?=$article->intro;?></em></p>
	
	<p><?=$article->body;?></p>
	
    
    <h3>Comments</h3>
    
	<fieldset class="alternative float-left width-half">
		<legend>They said...</legend>
		<?= $this->comments_m->getComments($this->matchbox->fetch_module(), $article->id); ?>
	</fieldset>
                
	<fieldset class="float-right width-half">
		<legend>You say...?</legend>
		<?= $this->load->module_view('comments', 'form', array('module'=>'news', 'id' => $article->id)); ?> 
	</fieldset>
	