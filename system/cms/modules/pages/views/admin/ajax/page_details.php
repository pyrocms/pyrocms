<input id="page-id" type="hidden" value="<?php echo $page->id ?>" />
<input id="page-uri" type="hidden" value="<?php echo ( ! empty($page->uri)) ? $page->uri : $page->slug ?>" />

<fieldset>
	<legend><?php echo lang('pages:detail_label') ?></legend>
	<p>
		<strong>ID:</strong> #<?php echo $page->id ?>
	</p>
	<p>
		<strong><?php echo lang('pages:status_label') ?>:</strong> <?php echo lang("pages:{$page->status}_label") ?>
	</p>
	<p>
		<strong><?php echo lang('global:slug') ?>:</strong>
		<a href="<?php echo !empty($page->uri) ? $page->uri : $page->slug ?>" target="_blank">
			/<?php echo !empty($page->uri) ? $page->uri : $page->slug ?>
		</a>
	</p>
	<p>
		<strong><?php echo lang('pages:type_id_label') ?>:</strong>
		<?php echo $page->page_type_title; ?>
	</p>
</fieldset>

<!-- Meta data tab -->
<?php if ($page->meta_title or $page->meta_keywords or $page->meta_description): ?>
<fieldset>
	<legend><?php echo lang('pages:meta_label') ?></legend>
	<?php if ($page->meta_title): ?>
	<p>
		<strong><?php echo lang('pages:meta_title_label') ?>:</strong> <?php echo $page->meta_title ?>
	</p>
	<?php endif ?>
	<?php if ($page->meta_keywords): ?>
	<p>
		<strong><?php echo lang('pages:meta_keywords_label') ?>:</strong> <?php echo $page->meta_keywords ?>
	</p>
	<?php endif ?>
	<?php if ($page->meta_description): ?>
	<p>
		<strong><?php echo lang('pages:meta_desc_label') ?>:</strong> <?php echo $page->meta_description ?>
	</p>
	<?php endif ?>
</fieldset>	
<?php endif ?>

<div class="buttons">
	<?php 

		if ($this->db->count_all('page_types') > 1)
		{
			echo anchor('admin/pages/choose_type?modal=true&parent='.$page->id, lang('pages:create_label'), 'class="button modal"');
		}
		else
		{
			$type_id = $this->db->select('id')->limit(1)->get('page_types')->row()->id;
			echo anchor('admin/pages/create?parent='.$page->id.'&page_type='.$type_id, lang('pages:create_label'), 'class="button"');
		}

	?>
	<?php echo anchor('admin/pages/duplicate/'.$page->id, lang('pages:duplicate_label'), 'class="button"') ?>
	<?php echo anchor('admin/pages/edit/'.$page->id, lang('global:edit'), 'class="button"') ?>
	<?php echo anchor('admin/pages/delete/'.$page->id, lang('global:delete'), 'class="confirm button"') ?>
</div>