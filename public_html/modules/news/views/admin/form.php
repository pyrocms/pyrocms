<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h3>Create article</h3>
	
<? else: ?>
	<h3>Edit article "<?= $article->title; ?>"</h3>
<? endif; ?>

<?= form_open($this->uri->uri_string()); ?>

<fieldset>

	<legend>Details</legend>
	
	<div class="field">
		<label for="category_id">Category</label>
		<?=form_dropdown('category_id', array('-- None --')+$categories, @$article->category_id) ?>	
        [ <?= anchor('admin/categories/create', 'Add a category', 'target="_blank"'); ?> ]
	</div>
	
	<div class="field">
		<label for="category_id">Status</label>
		<?=form_dropdown('status', array('draft'=>'Draft', 'live'=>'Live'), $article->status) ?>	
	</div>
	
	<div class="field">
		<label>Date</label>
		<?=form_dropdown('created_on_day', $days, !empty($article->created_on_day) ? $article->created_on_day : date('j', isset($article->created_on) ? $article->created_on : now())) ?>
		<?=form_dropdown('created_on_month', $months, !empty($article->created_on_month) ? $article->created_on_month : date('n', isset($article->created_on) ? $article->created_on : now())) ?>
		<?=form_dropdown('created_on_year', $years, !empty($article->created_on_year) ? $article->created_on_year : date('Y', isset($article->created_on) ? $article->created_on : now())) ?>
		
		Time
		<?=form_dropdown('created_on_hour', $hours, !empty($article->created_on_hour) ? $article->created_on_hour : date('G', isset($article->created_on) ? $article->created_on : now())) ?>
		<?=form_dropdown('created_on_minute', $minutes, !empty($article->created_on_minute) ? $article->created_on_minute : date('i', isset($article->created_on) ? $article->created_on : now())) ?>
	</div>

</fieldset>

<fieldset>

	<legend>Content</legend>
		
	<div class="field">
		<label for="title">Title</label>
		<?=form_input('title', $article->title, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="intro">Introduction</label>
		<?=form_textarea(array('id'=>'intro', 'name'=>'intro', 'value'=>$article->intro, 'rows'=>5)); ?>
	</div>
	
	<div class="field">
		<label for="body">Body</label>
		<?=$this->spaw->show(); ?>
	</div>
	
</fieldset>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>