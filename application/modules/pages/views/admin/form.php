<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h2>Create Page</h2>
	
<? else: ?>
	<h2>Edit Page "<?= $page->title; ?>"</h2>
<? endif; ?><?= form_open($this->uri->uri_string()); ?><div class="field">	<label for="title">Title</label>	<input type="text" id="title" name="title" maxlength="100" value="<?= $page->title; ?>" class="text" /></div><div class="field">	<label for="slug">URL</label>	<?=site_url() ?>
	<input type="text" id="slug" name="slug" maxlength="100" size="20" value="<?= $page->slug; ?>" class="text width-10" />	<?=$this->config->item('url_suffix'); ?>
</div><div class="field">	<label for="parent">Parent page</label>	<select name="parent" id="parent" size="1">		<option value="">-- None --</option>		<? create_tree_select($this->data->pages, 0, 0, $page->parent, $page->id); ?>	</select></div>

<div class="field">
	<label for="lang">Language</label>
	<?=form_dropdown('lang', $languages, $page->lang); ?>
</div><div class="field width-full">	<label for="body">Content</label>	<?= $this->spaw->show(); ?></div>
<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?> <?= form_close(); ?>