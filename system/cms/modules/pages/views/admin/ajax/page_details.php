<h4><?php echo $page->title; ?></h4>

<input id="page-id" type="hidden" value="<?php echo $page->id; ?>" />
<input id="page-uri" type="hidden" value="<?php echo !empty($page->uri) ? $page->uri : $page->slug; ?>" />

<fieldset>
	<legend><?php echo lang('pages.detail_label'); ?></legend>
	<p>
		<strong>ID:</strong> #<?php echo $page->id; ?>
	</p>
	<p>
		<strong><?php echo lang('pages.status_label'); ?>:</strong> <?php echo lang('pages.' . $page->status . '_label'); ?>
	</p>
	<p>
		<strong><?php echo lang('pages.slug_label');?>:</strong> 
		<a href="<?php echo site_url('admin/pages/preview/'.$page->id);?>?iframe" rel="modal-large" target="_blank">
			<?php echo site_url(!empty($page->uri) ? $page->uri : $page->slug); ?>
		</a>
	</p>
</fieldset>

<!-- Meta data tab -->
<fieldset>
	<legend><?php echo lang('pages.meta_label');?></legend>
	<p>
		<strong><?php echo lang('pages.meta_title_label');?>:</strong> <?php echo !empty($page->meta_title) ? $page->meta_title : '&mdash;'; ?>
	</p>
	<p>
		<strong><?php echo lang('pages.meta_keywords_label');?>:</strong> <?php echo !empty($page->meta_keywords) ? $page->meta_keywords : '&mdash;'; ?>
	</p>
	<p>
		<strong><?php echo lang('pages.meta_desc_label');?>:</strong> <?php echo !empty($page->meta_description) ? $page->meta_description : '&mdash;'; ?>
	</p>
</fieldset>	

<div class="buttons">
	<?php echo anchor('admin/pages/create/' . $page->id, lang('pages.create_label'), 'class="button"'); ?>
	<?php echo anchor('admin/pages/edit/' . $page->id, lang('pages.edit_label'), 'class="button"'); ?>
	<?php echo anchor('admin/pages/delete/' . $page->id, lang('pages.delete_label'), 'class="confirm button"'); ?>
</div>