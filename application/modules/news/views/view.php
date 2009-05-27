<? $this->load->helper('typography'); ?>

<h2><?= $article->title; ?></h2>

<p>
	<strong>Posted:</strong> <?= date('M d, Y', $article->created_on); ?><br/>
		
	<? if($article->category_slug): ?>
	<strong>Category:</strong> <?=anchor('news/category/'.$article->category_slug, $article->category_title);?>
	<? endif; ?>
</p>

<hr/>

<?=stripslashes($article->body);?>
    
<h3>Comments</h3>
    
<fieldset class="alternative float-left width-half">
	<legend>They said...</legend>
	<?= $this->comments_m->getComments($this->module, $article->id); ?>
</fieldset>
                
<fieldset class="float-right width-half">
	<legend>You say...?</legend>
	<?= $this->load->module_view('comments', 'form', array('module'=>$this->module, 'id' => $article->id)); ?> 
</fieldset>
