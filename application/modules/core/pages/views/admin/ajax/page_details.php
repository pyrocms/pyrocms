<h4><?php echo $page->title; ?></h4>

<input id="page-id" type="hidden" value="<?php echo $page->id; ?>" />
<input id="page-path" type="hidden" value="<?php echo !empty($page->path) ? $page->path : $page->slug; ?>" />

<fieldset>
	<legend><?php echo lang('page_detail_label'); ?></legend>
	<p>
		<strong>ID:</strong> #<?php echo $page->id; ?>
	</p>
	<p>
		<strong><?php echo lang('page_status_label'); ?>:</strong> <?php echo lang('page_' . $page->status . '_label'); ?>
	</p>
	<p>
		<strong><?php echo lang('page_slug_label');?>:</strong> 
		<a href="<?php echo site_url('admin/pages/preview/'.$page->id);?>?iframe" rel="modal-large" target="_blank">
			<?php echo site_url(!empty($page->path) ? $page->path : $page->slug); ?>
		</a>
	</p>
</fieldset>

<!-- Meta data tab -->
<fieldset>
	<legend><?php echo lang('page_meta_label');?></legend>
	<p>
		<strong><?php echo lang('page_meta_title_label');?>:</strong> <?php echo $page->meta_title; ?>
	</p>
	<p>
		<strong><?php echo lang('page_meta_keywords_label');?>:</strong> <?php echo $page->meta_keywords; ?>
	</p>
	<p>
		<strong><?php echo lang('page_meta_desc_label');?>:</strong> <?php echo $page->meta_description; ?>
	</p>
</fieldset>	

<div id="page-buttons">
	<div class="button">
		<?php echo anchor('admin/pages/create/' . $page->id, lang('page_create_label')); ?>
	</div>
	
	<div class="button">
		<?php echo anchor('admin/pages/edit/' . $page->id, lang('page_edit_label')); ?>
	</div>
	
	<div class="button">
		<?php echo anchor('admin/pages/delete/' . $page->id, lang('page_delete_label'), 'class="confirm"'); ?>
	</div>
</div>