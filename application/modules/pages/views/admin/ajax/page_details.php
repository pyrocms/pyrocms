<h3><?php echo $page->title; ?></h3>

<fieldset id="fieldset1">
	<legend>Details</legend>
	<p>
		ID: #<?=$page->id; ?>
	</p>
	<p>
		<?=lang('page_url_label');?>: <?=anchor(!empty($page->path) ? $page->path : $page->slug); ?>
	</p>
</fieldset>

<!-- Meta data tab -->
<fieldset id="fieldset2">
	<legend><?=lang('page_meta_label');?></legend>
	<p>
		<?=lang('page_meta_title_label');?>: <?= $page->meta_title; ?>
	</p>
	<p>
		<?=lang('page_meta_keywords_label');?>: <?= $page->meta_keywords; ?>
	</p>
	<p>
		<?=lang('page_meta_desc_label');?>: <?= $page->meta_description; ?>
	</p>
</fieldset>	

<div id="page-buttons">
	<div class="float-left">
		<a href="<?php echo site_url('admin/pages/edit/' . $page->id); ?>">
			<button class="button">
				<strong>
					<?= lang('page_edit_label');?>
					<img class="icon" alt="Edit selected" src="<?=image_url('admin/icons/paper_content_pencil_48.png');?>" />
				</strong>
			</button>
		</a>
	</div>
	
	<div class="float-left">
		<a href="<?php echo site_url('admin/pages/delete/' . $page->id); ?>">
			<button class="button confirm">
				<strong>
					<?= lang('page_delete_label');?>
					<img class="icon" alt="Delete selected" src="<?=image_url('admin/icons/cross_48.png');?>" />
				</strong>
			</button>
		</a>
	</div>
</div>