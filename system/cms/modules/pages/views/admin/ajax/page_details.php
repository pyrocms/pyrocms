<input id="page-id" type="hidden" value="<?php echo $page->id; ?>" />
<input id="page-uri" type="hidden" value="<?php echo ( ! empty($page->uri)) ? $page->uri : $page->slug; ?>" />

<fieldset>
	<legend><?php echo lang('pages:detail_label'); ?></legend>
	<p>
		<strong>ID:</strong> #<?php echo $page->id; ?>
	</p>
	<p>
		<strong><?php echo lang('pages:status_label'); ?>:</strong> <?php echo lang("pages:{$page->status}_label"); ?>
	</p>
	<p>
		<strong><?php echo lang('global:slug');?>:</strong>
		<a href="<?php echo site_url('admin/pages/preview/'.$page->id);?>?iframe" rel="modal-large" target="_blank">
			<?php echo site_url(!empty($page->uri) ? $page->uri : $page->slug); ?>
		</a>
	</p>
</fieldset>

<!-- Meta data tab -->
<?php if ($page->meta_title or $page->meta_keywords or $page->meta_description): ?>
<fieldset>
	<legend><?php echo lang('pages:meta_label');?></legend>
	<?php if ($page->meta_title): ?>
	<p>
		<strong><?php echo lang('pages:meta_title_label');?>:</strong> <?php echo $page->meta_title ?>
	</p>
	<?php endif ?>
	<?php if ($page->meta_keywords): ?>
	<p>
		<strong><?php echo lang('pages:meta_keywords_label');?>:</strong> <?php echo Keywords::get_string($page->meta_keywords) ?>
	</p>
	<?php endif ?>
	<?php if ($page->meta_description): ?>
	<p>
		<strong><?php echo lang('pages:meta_desc_label');?>:</strong> <?php echo $page->meta_description ?>
	</p>
	<?php endif ?>
</fieldset>	
<?php endif ?>

<div class="buttons">
	<?php echo anchor('admin/pages/create/'.$page->id, lang('pages:create_label'), 'class="button"'); ?>
	<?php echo anchor('admin/pages/duplicate/'.$page->id, lang('pages:duplicate_label'), 'class="button"'); ?>
	<?php echo anchor('admin/pages/edit/'.$page->id, lang('global:edit'), 'class="button"'); ?>
	<?php echo anchor('admin/pages/delete/'.$page->id, lang('global:delete'), 'class="confirm button"'); ?>
</div>