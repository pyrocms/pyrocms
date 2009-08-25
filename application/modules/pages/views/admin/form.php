<?= form_open($this->uri->uri_string()); ?>
<div class="fieldset fieldsetBlock active tabs">	
	<div class="header">		
		<? if($this->uri->segment(3,'create') == 'create'): ?>
			<h3><?=lang('page_create_title');?></h3>
		<? else: ?>
			<h3><?=sprintf(lang('page_edit_title'), $page->title);?></h3>
		<? endif; ?>
	</div>    
  	<div class="tabs">
		<ul class="clear-box">
			<li><a href="#fieldset1"><span><?=lang('page_content_label');?></span></a></li>
			<li><a href="#fieldset2"><span><?=lang('page_meta_label');?></span></a></li>
			<li><a href="#fieldset3"><span><?=lang('page_advanced_label');?></span></a></li>
		</ul>
		
		<!-- Page content tab -->
		<fieldset id="fieldset1">
			<legend><?=lang('page_content_label');?></legend>
			<div class="field">
				<label for="title"><?=lang('page_title_label');?></label>
				<input type="text" id="title" name="title" maxlength="60" value="<?= $page->title; ?>" class="text" />
				<span class="required-icon tooltip"><?=lang('page_required_label');?></span>
			</div>
			<div class="field">
				<label for="slug"><?=lang('page_url_label');?></label>
				<?=site_url() ?>
				<input type="text" id="slug" name="slug" maxlength="60" size="20" value="<?= $page->slug; ?>" class="text width-10" />
				<span class="required-icon tooltip"><?=lang('page_required_label');?></span>
				<?=$this->config->item('url_suffix'); ?>
			</div>
			<div class="field">
				<label for="parent_id"><?=lang('page_parent_page_label');?></label>
				<select name="parent_id" id="parent_id" size="1">
					<option value=""><?=lang('page_no_selection_label');?></option>
					<? create_tree_select($this->data->pages, 0, 0, $page->parent_id, $page->id); ?>
				</select>
			</div>
			<?php /* Removed the language option for now, we need to plan this better
			<div class="field">
				<label for="lang"><?=lang('page_language_label');?></label>
				<?=form_dropdown('lang', $languages, $page->lang); ?>
			</div>	
			*/ ?>
					
			<div class="field spacer-left">
				<?=form_textarea(array('id'=>'body', 'name'=>'body', 'value' => htmlentities(stripslashes($page->body)), 'rows' => 50, 'class'=>'wysiwyg-advanced')); ?>
			</div>
		</fieldset>
		
		<!-- Meta data tab -->
		<fieldset id="fieldset2">
			<legend><?=lang('page_meta_label');?></legend>
			<div class="field">
				<label for="meta_title"><?=lang('page_meta_title_label');?></label>
				<input type="text" id="meta_title" name="meta_title" maxlength="255" value="<?= $page->meta_title; ?>" class="text" />
			</div>
			<div class="field">
				<label for="meta_keywords"><?=lang('page_meta_keywords_label');?></label>
				<input type="text" id="meta_keywords" name="meta_keywords" maxlength="255" value="<?= $page->meta_keywords; ?>" class="text" />
			</div>
			<div class="field">
				<label for="meta_description"><?=lang('page_meta_desc_label');?></label>
				<textarea id="meta_description" name="meta_description"><?= $page->meta_description; ?></textarea>
			</div>
		</fieldset>	
		
		<!-- Advanced tab -->
		<fieldset id="fieldset3">
			<legend><?=lang('page_advanced_label');?></legend>
			<div class="field">
				<label for="layout_file"><?=lang('page_layout_file_label');?></label>
				<input type="text" id="layout_file" name="layout_file" maxlength="255" value="<?= $page->layout_file ? $page->layout_file : 'default'; ?>" class="text" />
			</div>
		</fieldset>	
	</div>	
</div>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>