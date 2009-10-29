<?php echo form_open($this->uri->uri_string()); ?>
<?php echo form_hidden('parent_id', @$page->parent_id); ?>

<div class="fieldset fieldsetBlock active tabs">	
	<div class="header">		
		<?php if($this->uri->segment(3,'create') == 'create'): ?>
			<h3><?php echo lang('page_create_title');?></h3>
		<?php else: ?>
			<h3><?php echo sprintf(lang('page_edit_title'), $page->title);?></h3>
		<?php endif; ?>
	</div>    
  	<div class="tabs">
		<ul class="clear-box">
			<li><a href="#fieldset1"><span><?php echo lang('page_content_label');?></span></a></li>
			<li><a href="#fieldset2"><span><?php echo lang('page_meta_label');?></span></a></li>
			<li><a href="#fieldset3"><span><?php echo lang('page_advanced_label');?></span></a></li>
		</ul>
		
		<!-- Page content tab -->
		<fieldset id="fieldset1">
			<legend><?=lang('page_content_label');?></legend>
			<div class="field">
				<label for="title"><?=lang('page_title_label');?></label>
				<input type="text" id="title" name="title" maxlength="60" value="<?php echo $page->title; ?>" />
				<span class="required-icon tooltip"><?php echo lang('page_required_label');?></span>
			</div>
			<div class="field">
				<label for="slug"><?=lang('page_url_label');?></label>
				
				<?php if(!empty($page->parent_id)): ?>
					<?php echo site_url().$parent_page->path; ?>/
				<?php else: ?>
					<?php echo site_url(); ?>
				<?php endif; ?>
				
				<?php if($this->uri->segment(3,'') == 'edit'): ?>
					<?php echo form_hidden('slug', $page->slug); ?>
					<?php echo form_input('', $page->slug, 'maxlength="60" size="20" class="width-10" disabled="disabled"'); ?>
				<?php else: ?>
					<?php echo form_input('slug', $page->slug, 'maxlength="60" size="20" class="width-10"'); ?>
				<?php endif; ?>
				
				<span class="required-icon tooltip"><?php echo lang('page_required_label');?></span>
				<?php echo $this->config->item('url_suffix'); ?>
			</div>
					
			<div class="field spacer-left">
				<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' => stripslashes($page->body), 'rows' => 50, 'class'=>'wysiwyg-advanced')); ?>
			</div>
		</fieldset>
		
		<!-- Meta data tab -->
		<fieldset id="fieldset2">
			<legend><?php echo lang('page_meta_label');?></legend>
			<div class="field">
				<label for="meta_title"><?php echo lang('page_meta_title_label');?></label>
				<input type="text" id="meta_title" name="meta_title" maxlength="255" value="<?php echo $page->meta_title; ?>" />
			</div>
			<div class="field">
				<label for="meta_keywords"><?php echo lang('page_meta_keywords_label');?></label>
				<input type="text" id="meta_keywords" name="meta_keywords" maxlength="255" value="<?php echo $page->meta_keywords; ?>" />
			</div>
			<div class="field">
				<label for="meta_description"><?php echo lang('page_meta_desc_label');?></label>
				<textarea id="meta_description" name="meta_description"><?php echo $page->meta_description; ?></textarea>
			</div>
		</fieldset>	
		
		<!-- Advanced tab -->
		<fieldset id="fieldset3">
			<legend><?php echo lang('page_advanced_label');?></legend>
			<!-- <div class="field">
				<label for="layout_file"><?php //echo lang('page_access_level_label');?></label>
				<?php //echo form_dropdown('access_level', $roles_select, $page->access_level); ?>
			</div> -->
			<div class="field">
				<label for="layout_file"><?php echo lang('page_layout_file_label');?></label>
				<input type="text" id="layout_file" name="layout_file" maxlength="255" value="<?php echo $page->layout_file ? $page->layout_file : 'default'; ?>" />
			</div>
		</fieldset>
		
	</div>
</div>

<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>