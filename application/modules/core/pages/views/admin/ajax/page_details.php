<h4><?php echo $page->title; ?></h4>

<input id="page-id" type="hidden" value="<?php echo $page->id; ?>" />
<input id="page-path" type="hidden" value="<?php echo !empty($page->path) ? $page->path : $page->slug; ?>" />

<fieldset>
	<legend>Details</legend>
	<p>
		ID: #<?php echo $page->id; ?>
	</p>
	<p>
		<?php echo lang('page_slug_label');?>: 
		<a href="<?php echo site_url('admin/pages/preview/'.$page->id);?>?iframe" rel="preview-modal" target="_blank">
			/<?php echo !empty($page->path) ? $page->path : $page->slug; ?>
		</a>
	</p>
</fieldset>

<!-- Meta data tab -->
<fieldset>
	<legend><?php echo lang('page_meta_label');?></legend>
	<p>
		<?php echo lang('page_meta_title_label');?>: <?php echo $page->meta_title; ?>
	</p>
	<p>
		<?php echo lang('page_meta_keywords_label');?>: <?php echo $page->meta_keywords; ?>
	</p>
	<p>
		<?php echo lang('page_meta_desc_label');?>: <?php echo $page->meta_description; ?>
	</p>
</fieldset>	

<div id="page-buttons">
	<div class="float-left">
		<a href="<?php echo site_url('admin/pages/create/' . $page->id); ?>">
			<button class="button">
				<strong>
					<?php echo lang('page_create_label');?>
				</strong>
			</button>
		</a>
	</div>
	
	<div class="float-left">
		<a href="<?php echo site_url('admin/pages/edit/' . $page->id); ?>">
			<button class="button">
				<strong>
					<?php echo lang('page_edit_label');?>
				</strong>
			</button>
		</a>
	</div>
	
	<div class="float-left">
		<a href="<?php echo site_url('admin/pages/delete/' . $page->id); ?>">
			<button class="button confirm">
				<strong>
					<?php echo lang('page_delete_label');?>
				</strong>
			</button>
		</a>
	</div>
</div>